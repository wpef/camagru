<?php

include_once(ROOT . "config/inc.php");
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
			|| !array_key_exists('src', $datas))
			return FALSE;
		proceed_array($datas);
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

?>