<?php

//include_once(ROOT . "config/inc.php");
define('DIR', ROOT . "photos/");


class Picture {
	public		$owner;
	public		$src;
	public		$name;
	public		$comment;
	public		$likes;
	public static $verbose = false;

/* ==> DEFAULT METHOD <== */
	public function __construct($datas) {
		if (!is_array($datas)
			|| !array_key_exists('src', $datas)
			return FALSE;
		$this->src = $datas['src'];
		if (!array_key_exists('owner', $datas))
			$this->owner = $_SESSION['user']->login;	
		return $this;
	}

	public function __destruct() {
		if (self::$verbose)
			echo $this ." DESTRUCTED" . PHP_EOL;
	}

	public function __toString () {
		return "IMG :" . $this->src . PHP_EOL;
	}

/* ==> My Functions <== */

	public function proceed() {
		//proceed HERE;
		return TRUE;
	}

	public function add_todb() { 
		return TRUE;
	}
}

$new = new Picture('39kjf49');
echo $new->owner;echo $new->name;

?>