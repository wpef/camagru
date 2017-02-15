<?php
//debug
//include_once('../config/inc.php');
//define('DIR', ROOT . "photos/");
//end

define ('MAX_SIZE', 1000000);

class Picture {
	public		$owner;
	public		$src;
	public		$name;
	public		$comments;
	public		$likes;
	public		$error;
	public static $verbose = false;

/* ==> DEFAULT METHOD <== */
	public function __construct($datas) {
		if (is_array($datas))
			$this->proceedArray($datas);
		else
			$this->error = "NO DATAS";
	}

	public function __destruct() {
		if (self::$verbose)
			echo $this ." DESTRUCTED" . PHP_EOL;
	}

	public function __toString () {
		return "IMG :" . $this->src . " from " . $this->owner . PHP_EOL;
	}

/* ==> My Functions <== */

	public function proceedArray($a) {
		foreach ($a as $d => $v)
		{
			switch ($d) {
			//set vars;
				case 'src':
					$this->src = $v;
					break;
				case 'name':
					$this->name = $v;
					break;
				case 'owner' :
					$this->owner = $v;
					break;
			}
			//push file & set unset vars;
			if (array_key_exists('data', $a))
				$this->proceedDatas($a['data']);
		}
	}

	public function proceedDatas($d)
	{		
		//proceed datas;
		$datas = str_replace(' ','+',$d); //JS to PHP decode
		$datas = substr($datas,strpos($datas,",")+1); //remove data:img/png ...
		$datas = base64_decode($datas); //decode string

		//Check & upload
		if ($this->_checkDatas($d) === TRUE)
		{
			if (!isset($this->name))
				$this->name = $this->_getNewName();
			if (!isset($this->src))
				$this->src = DIR . $this->name;
			if (!isset($this->owner))
					$this->owner = $_SESSION['user']->login;

			$this->_uploadImg($datas);
		}
	}

	private function _uploadImg($img)
	{
		if (file_put_contents($this->src, $img)) {
			$this->_pushToDb();
			return TRUE;
		}
		else
			$this->error = "An error occured uploading the file.";
			return FALSE;	
	}

	private function _getNewName()
	{
		$i = 0;
		do {
			$file = 'photo' . $i . '.png';
			$i++;
			} while (file_exists(DIR . $file));
		return ($file); 
	}

	private function _checkDatas($d) {
		//check type
		if ((substr($d, 0, 22)) !== 'data:image/png;base64,') {
			$this->error = "Wrong image type (must be a .png file)";
			return FALSE;
		}

		//check size
		if ($len = strlen($d) > MAX_SIZE) {
			$len = $len / 100;
			$this->error = "Wrong image size ($len KB / 1MB max.)";
			return FALSE;
		}

		//check user
		if (!isset($this->owner) and !isset($_SESSION['user']->login)) {
			$this->error = "An unexpected error occured : (OWNER)";
			return FALSE;
		}
		return TRUE;
	}

	private function _pushToDb() {
		//check required
		if (!isset($this->owner) || !isset($this->src) || !isset($this->name))
			return FALSE;

		//turn $this to array
		date_default_timezone_set('Europe/Paris');
		$datas = array(
		'pic_src'		=>	$this->src,
		'pic_owner' 	=>	$this->owner,
		'pic_name'		=>	$this->name,
		'added_on'		=>	date('Y-m-d H:i:s', time()) // ==> other table
		);

		//push
		insert_datas('pictures', $datas);
	}
}

/*$new = array('data' => file_get_contents(DIR . 'img64.png'),
	'owner' => 'C WAM');

$pict = new Picture();
$pict->proceedDatas($new['data']);
if ($pict->error)
echo $pict->error;

if (!empty($pict))
	echo $pict;
*/
?>