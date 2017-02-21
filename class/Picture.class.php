<?php
//debug
//include_once('../config/inc.php');
define('DIR', WEBROOT . "photos/");
//end

define ('MAX_SIZE', 1000000);

class Picture {
	public		$id;
	public		$owner;
	public		$src;
	public		$name;
	public		$date;
	public		$comments;
	public		$likes;
	public		$error;
	public static $verbose = false;

/* ==> DEFAULT METHOD <== */
	public function __construct($datas) {
		//takes array paramater, if contains 'data' -> create and push, if contains 'id' vars will be set from DB;
		
		if (!is_array($datas))
			return;

		foreach ($datas as $d => $v) {
			switch ($d) {
				case 'id' :
					$this->_pull($v);
					break;
				case 'data' :
					$this->_push($v);
					break;
			}
		}
		return ($this);
	}

	public function __destruct() {
		if (self::$verbose)
			echo $this ." DESTRUCTED" . PHP_EOL;
	}

	public function __toString () {
		return "IMG :" . $this->src . " from " . $this->owner . PHP_EOL;
	}

/* ==> PUSH <== */
	private function _push($datas)
	{
		if (!isset($this->id)) {
			$this->create($datas);
			$this->_pushToDb();
		}
		else {
			$this->_proceedArray($datas);
			$this->_pushToDb();
		}
	}

	public function create($d)
	{		
		//proceed datas;
		$datas = str_replace(' ','+',$d); //JS to PHP decode
		$datas = substr($datas,strpos($datas,",")+1); //remove data:img/png ...
		$datas = base64_decode($datas); //decode string

		//Check
		if ($this->_checkDatas($d) === TRUE)
		{
			if (!isset($this->name))
				$this->name = $this->_getNewName();
			if (!isset($this->src))
				$this->src = DIR . $this->name;
			if (!isset($this->owner))
					$this->owner = $_SESSION['user']->login;
			if (!isset($this->date)) {
				date_default_timezone_set('Europe/Paris');
				$this->date = date('Y-m-d H:i:s', time());
			}
			//upload
			$this->_uploadImg($datas);
		}
	}

	private function _uploadImg($img)
	{
		if (file_put_contents(ROOT . 'photos/' . $this->name, $img))
			return TRUE;
		else
			$this->error = "An error occured uploading the file : $this->src";
			return FALSE;	
	}

	private function _pushToDb()
	{
		//check required
		if (!isset($this->owner) || !isset($this->src) ||
				!isset($this->name) || !isset($this->date))
			return FALSE;

		//turn $this to array
		$datas = array(
		'pic_src'		=>	$this->src,
		'pic_owner' 	=>	$this->owner,
		'pic_name'		=>	$this->name,
		'added_on'		=>	$this->date
		);

		//push
		if (!isset($this->id))
			insertDatas('pictures', $datas);
		// else alter pic_id = _id; IMPORTANT !!!!
	}

	public function like($login)
	{
		//checking if liked
		$p_query = "SELECT * FROM likes 
						WHERE like_pic = $this->id AND like_author = $login;";
		if (count(getDatas($p_query, "")) > 0)
		{
			$_SESSION['alert'] = "You can like each picture only once.";
			exit;
		}

		//liking
		insertDatas("likes", array("like_pic" => $this->id, "like_author" => $login));
		$this->likes++;
		$this->modify(array('pic_likes', $this->likes));
	}
	
/* ==> PULL <== */
	private function _pull($id)
	{
		//except
		if (!is_numeric($id))
			return FALSE;
		
		//set vars;
		$this->id = $id;

		//db query;
		$query = "SELECT * FROM pictures WHERE pic_id = ?;";
		$res = getDatas($query, $id);

		$this->_proceedArray($res[0]);
	}

	private function _proceedArray($a) {
		//treat STD
		foreach ($a as $d => $v)
		{
			switch ($d) {
			//set vars;
				case 'pic_src':
					$this->src = $v;
					break;
				case 'pic_name':
					$this->name = $v;
					break;
				case 'pic_owner' :
					$this->owner = $v;
					break;
				case 'added_on' :
					$this->date = $v;
					break;
				case 'pic_likes' :
					$this->likes = $v;
					break;
			}
		}
	}

	public function modify($datas)
	{
		//$datas is an array like $db_entry => $new_value;
		$p_query = "UPDATE pictures SET ? = ? WHERE pic_id = $this->id;";
		foreach ($datas as $d)
			insertDatas2($p_query, $d);
	}

/* ==> DISPLAY <== */
	public function toImgHTML()
	{
		$s = "<figure>";
		$s .= "<img src=\"$this->src\"/>";
		$s .= "<figcaption>$this->name by $this->owner on $this->date liked $this->likes time(s)</figcaption>";
		$s .= "</figure>";
		return $s;
	}

/* -> USEFULL METHODS <- */
	private function _getNewName()
	{
		$i = 0;
		do {
			$file = 'photo' . $i . '.png';
			$i++;
			} while (file_exists(ROOT . 'photos/' . $file));
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
}

?>