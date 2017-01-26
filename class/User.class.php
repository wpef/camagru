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
	//Might be improved, by automatically checking if exists before create;
		if (is_array($log))
			$this->create($log);
		else if (is_string($log))
		{
			$this->getInfos($log);
			if (self::$verbose)
				echo $this . " CONSTRUCTED" . PHP_EOL;
		}
	}

	public function __destruct() {
		if (self::$verbose)
			echo "USER : " . $this->login . " DESTRUCTED" . PHP_EOL;
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

	static function doc() {
		return (file_get_contents('User.doc.txt'));
	}

/* ==> MY METHODS <== */

	private function auth($log, $pass) {
	//$log & $pass must be sent by $_POST; $pass is sent hashed;
		if ($log === $this->login && $pass === $this->_passwd)
			return TRUE;
		return FALSE;
	}

	public function getInfos($log) {
	//fills the new User vars with database datas;

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
		$this->_passwd = $usr['pass'];
		$this->mail = $usr['mail'];
		$this->f_name = $usr['f_name'];
		$this->name = $usr['f_name'] . " " . $usr['l_name'];
		$this->isadmin = $usr['isadmin'];
	}

	public function create($usr_infos) {
	//$usr_infos must be an array in which every key corresponds to the DB entries;

		if (!is_array($usr_infos))
			return FALSE;
		
		//Check required values;
		if (!key_exists('login', $usr_infos) || !key_exists('pass', $usr_infos) || !key_exists('mail', $usr_infos))
			return FALSE;

		//send query;
		$db = connect_db(FALSE);
		$query = insert_datas('users', $usr_infos);
		$db->exec('USE ' . $DB_NAME);
		
		try { $db->exec($query);
		} catch (PDOexception $e) {
			die ('ERROR CREATING USER: ' . $e->getMessage());
		}

		//VERBOSE
		if (self::$verbose)
			echo "USER : " . $usr_infos['login'] . " added to DB" . PHP_EOL;
		
		//Create OBJECT
		$this->__construct($usr_infos['login']);
 	}
 }

 /* DEBUG */

User::$verbose = TRUE;

$pef_a = Array (
	'login' => 'pef',
	'pass' => 'osef',
	'mail' => 'osef@sisi.fr',
	'f_name' => 'foulques',
	'isadmin' => 1
	);

$pef = new User($pef_a);
$new = new User('pef');


?>