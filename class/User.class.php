<?php

require_once('..' . '/config/manage_db.php');

class User {

	public			$login;
	private			$_passwd;
	public			$f_name;
	public			$name;
	public			$mail;
	public static	$verbose = FALSE;
	public			$isadmin;

/* ==> DEFAULT METHOD <== */
	public function __construct($log) {

		//IF (!user_exists($log))
		if ($log === "__new__") {
			return;
		}
		//ELSE

		//Connect to db
		$db = connect_db(FALSE);

		//setting query string;
		$query = "select * FROM users WHERE login = '" . $log . "';";

		//getting result;
		$db->exec("USE " . $DB_NAME);
		$curs = $db->query($query);
		$usr = $curs->fetch();
		$curs->closeCursor();

		//setting vars
		$this->login = $usr['login'];
		$this->passwd = $usr['pass'];
		$this->mail = $usr['mail'];
		$this->f_name = $usr['f_name'];
		$this->name = $usr['f_name'] . " " . $usr['l_name'];
		$this->isadmin = $usr['isadmin'];

		//VERBOSE
		if (self::$verbose)
			echo ($this);
	}

	public function __destruct() {
	}

	public function __toString () {

		if ($this->isadmin)
			$ad = "YES";
		else
			$ad = "NO";

		if (!$this->login)
			return "USER :\tNot found!\n---------------------------\n";
		$st = "USER :\n";
		$log = "\t" . "Login = " . $this->login . "\n"; 
		$name = "\t" . "Name = " . $this->name . "\n";
		$mail = "\t" . "Mail = " . $this->mail . "\n";
		$adm = "\t" . "isadmin = " . $ad . "\n";
		$end = "---------------------------\n"; 

		return ($st . $log . $name . $mail . $adm . $end);
	}

/* ==> MY METHODS <== */
	private function auth($log, $pass)
	{
	//$log & $pass must be sent by $_POST; $pass is sent hashed;
		if ($log === $this->login && $pass === $this->_passwd)
			return TRUE;
		return FALSE;
	}

	public function create($usr_infos)
	{
	//$usr_infos must be an array in which every key corresponds to the DB entries;

		if (!is_array($usr_infos))
			return FALSE;
		
		//Check required values;
		if (!key_exists('login', $usr_infos) || !key_exists('pass', $usr_infos) || !key_exists('mail', $usr_infos))
			return FALSE;

		//send query;
		$db = connect_db(FALSE);
		$query = insert_datas('users', $usr_infos);
		var_dump($query);
		$db->exec('USE ' . $DB_NAME);
		
		try { $db->exec($query);
		} catch (PDOexception $e) {
			die ('ERROR CREATING USER: ' . $e->getMessage());
		}

		//VERBOSE
		if (self::$verbose)
			echo "USER :" . $usr_infos['login'] . " added to DB" . PHP_EOL;
		
		//Create OBJECT
		$this->__construct($usr_infos['login']);
		return $this;
 	}
}

?>