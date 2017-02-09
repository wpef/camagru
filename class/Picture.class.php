<?php
//debug
//include_once('../config/inc.php');
//define('DIR', ROOT . "photos/");
//end

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
/* ==> GET & SET <== */

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
		$d = str_replace(' ','+',$d); //JS to PHP decode
		$d = substr($d,strpos($d,",")+1); //remove data:img/png ...
		$datas = base64_decode($d); //decode string
		
		//Check & upload
		if (_checkDatas($datas))
		{
			//upload
			if ($this->_uploadImg($datas))
			{
				//set vars;
				if (!isset($this->name))
					$this->name = $this->_getNewName();
				if (!isset($this->src))
					$this->src = DIR . $this->name;
				if (!isset($this->owner))
					$this->owner = $_SESSION['user']->login;
			}
		}
		else
			$this->error .= "WRONG FORMAT";
	}

	private function _uploadImg($img)
	{
		if (file_put_contents($img_src, $img))
			return TRUE;
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
		//proceed HERE;
		return TRUE;
	}

	public function add_todb() { 
		return TRUE;
	}
}

$new = array( 'data' => file_get_contents(DIR . 'img64.png')
	);

$pict = new Picture($new);
if (!empty($pict))
	echo $pict;

?>