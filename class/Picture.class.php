<?php

//include_once(ROOT . "config/inc.php");
//define('DIR', ROOT . "photos/");
session_start(); //debug 

class Picture {
	public		$owner;
	public		$src;
	public		$name;
	public		$comment;
	public		$likes;
	public static $verbose = false;

/* ==> DEFAULT METHOD <== */
	public function __construct($datas) {
		if (is_array($datas) && array_key_exists('src', $datas))
			$this->proceed_array($datas);
		else
			$this->__destruct();
	}

	public function __destruct() {
		if (self::$verbose)
			echo $this ." DESTRUCTED" . PHP_EOL;
	}

	public function __toString () {
		return "IMG :" . $this->src . " from " . $this->owner . PHP_EOL;
	}

/* ==> My Functions <== */

	public function proceed_array($a) {
		foreach ($a as $d => $v)
		{
			switch ($d) {
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
		}
	}

	public function proceed() {
		//proceed HERE;
		return TRUE;
	}

	public function add_todb() { 
		return TRUE;
	}
}

// $new = array(
// 	'src' => "yyo",
// 	'name' => "photo",
// 	'owner' => $_SESSION['user']->login);

// $pict = new Picture($new);
// if (!empty($pict))
// 	echo $pict;

?>