<?php

define('DIR', WEBROOT . "photos/");
define ('MAX_SIZE', 10000000);

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
			$this->_create($datas);
			$this->_pushToDb();
		}
		else {
			$this->_proceedArray($datas);
			$this->_pushToDb();
		}
	}

	private function _create($d)
	{
		$datas = str_replace(' ','+',$d);
		$datas = substr($datas,strpos($datas,",")+1);
		$datas = base64_decode($datas);

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

	public	function merge($sticker) 
	{
		$img_path = explode("/", $this->src);
		$img_path = $img_path[count($img_path) - 1];
		$img_path = ROOT . "photos/" . $img_path;
		
		$img_info = getimagesize($img_path);
		$img_h = $img_info[1];
		$img_w = $img_info[0];
		
		$stick_info = getimagesize($sticker);
		$stick_h = $stick_info[1];
		$stick_w = $stick_info[0];

		$stick = imagecreatefrompng($sticker);
		$image = imagecreatefrompng($img_path);
		if (empty($stick) OR empty($image))
		{
			$_SESSION['alert'] = "Woops... Something went wrong !";
			die();
		}

		imagealphablending($stick, false);
		imagesavealpha($stick, true);
		
		if (imagecopyresized($image, $stick, 0, 0, 0, 0, $img_w, $img_h, $stick_w, $stick_h))
		{
			header('Content-Type: image/png');
			imagepng($image, $img_path);
		}
		else
			$this->error = "Woops... A problem occured merging images";
		
		imagedestroy($stick);
		imagedestroy($image);
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
	}

	public function like($login) //go to user class
	{
		//checking logged_on
		if (empty($login))
		{
			echo "You must be logged in to like pictures";
			return FALSE;
		}
		//checking owner
		if ($this->owner == $login)
		{
			echo "You cannot like your own picture";
			return FALSE;
		}

		//checking if liked
		$p_query = "SELECT * FROM likes 
						WHERE (like_pic = $this->id AND like_author = '$login');";

		//like or unlike
		if (count(getDatas($p_query, "")) > 0)
		{
			echo "unliked";
			$this->unlike($login);
			$this->likes = $this->likes - 1;
		}
		else
		{ 
			echo "liked";
			insertDatas("likes", array("like_pic" => $this->id, "like_author" => $login));
			$this->likes++;
		}
		
		//reset likes count;
		sendQuery("UPDATE pictures SET pic_likes = $this->likes WHERE pic_id = $this->id;");

		return TRUE;
	}

	public function unlike($login) //go to user class
	{
		sendQuery("DELETE FROM likes WHERE (like_pic = $this->id AND like_author = '$login');");
	}

	public function addComment($login, $content)
	{
		$content = htmlentities($content);
		$datas = array (
			'com_pic' => $this->id,
			'com_cont' => $content,
			'com_date' => date('Y-m-d H:i:s', time()),
			'com_author' => $login
			);
		
		$owner = new User ($this->owner);
		if ($owner)
		{
			insertDatas('comments', $datas);
			$owner->notif($datas);
		}
		return $datas;
	}

	public function modify($datas)
	{
		//$datas is an array like $db_entry => $new_value;
		foreach ($datas as $k => $v)
		{
			if (is_string($v))
				$v = "'$v'";
			sendQuery("UPDATE pictures SET $k = $v WHERE pic_id = $this->id;");
		}
		$this->_pull($this->id);
		return TRUE;
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

	public function getId()
	{
		if ($this->id)
			return ($this->id);
		if ($this->src)
		{
			$query = "SELECT pic_id FROM pictures WHERE pic_src = '$this->src';";
			$res = getDatas($query, '');
			$this->id = $res[0]['pic_id'];
			return $this->id;
		}
	}

	public function getComments($limit, $offset)
	{
		//SET VARS
		if (!empty($offset) && $offset > 0)
		{
			$query = "SELECT * FROM comments WHERE com_pic = $this->id ORDER BY com_date DESC LIMIT $offset, 3;";
		}
		else if (!empty($limit))
			$query = "SELECT * FROM comments WHERE com_pic = $this->id ORDER BY com_date DESC LIMIT 3;";
		else
		{
			$query = "SELECT * FROM comments WHERE com_pic = $this->id ORDER BY com_date DESC;";
		}

		$res = getDatas($query, '');
		return $res;
	}

/* ==> DISPLAY <== */
	public function toImgHTML()
	{
		$s = 	"<section class='image'>";
		$s .= 	"<img src=\"$this->src\"/>";
		$s .=	"</section>";
		
		return $s;
	}

	public function toArticleHTML($user, $close)
	{
	//Return a picture formatted as an article $user must be a User object, is $close == true the last closing tag will be added;
		$isowned = 0;
		if ($this->owner == $user->login OR $user->isadmin)
			$isowned = 1;
		$user_html = new User ($this->owner);
		$user_html = $user_html->toDetailsHTML();
		$date = $this->date;
		$del_icon = "<i class=\"del fa fa-times\" aria-hidden=\"true\"></i>";

		//HEADER
		$h =	"<article class='picture' id='pic$this->id'>";
		$h .= 	"<header class='pic_header'>";

		if (!$isowned)
			$h .= "<h2 class='pic_name'>$this->name</h2>";
		else
		{
			$h .= $del_icon;
			$h .= "<span class='edit'>";
			$h .= "<input type='text' name='newName' class='pic_name' value='$this->name' readonly='true'>";
			$h .= "</span>";
		}

		//DETAILS
		$s =	"<section class='details'>";
		$s .= 	"by&nbsp;$user_html";
		$s .= 	"&nbsp<span class='pic_date'>$date</span> ";
		$s .= "</section>";
		$s .= "</header>";

		//IMAGE
		$img = $this->toImgHTML();

		if ($close)
			return ($h . $s . $img . "</article>");
		else
			return ($h . $s . $img);
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

	private function _checkDatas($d)
	{
		//check type
		if ((substr($d, 0, 22)) !== 'data:image/png;base64,'
				&& (substr($d, 0, 23)) !== 'data:image/jpeg;base64,') {
			$this->error = "Wrong image type (must be a .png or .jpg/jpeg file)";
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

	private function _proceedArray($a)
	{
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
}


?>