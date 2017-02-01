<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/manage_db.php');

class User {

	public			$login;
	private			$_passwd;
	public			$f_name;
	public			$name;
	public			$mail;
	public static	$verbose = FALSE;
	public			$isadmin;
	public			$confirmed;

/* ==> DEFAULT METHOD <== */
	public function __construct($log) {
	// if user exists on DB, all vars will be set, else it will be added to DB
		if (user_exists($log))
		{
			$this->getInfos($log);
			if (self::$verbose)
				echo $this . " CONSTRUCTED" . PHP_EOL;
		}
		else
			$this->create($log);
	}

	public function __destruct() {
		if (self::$verbose)
			echo "USER : " . $this->login . " DESTRUCTED" . PHP_EOL;
	}

	public function __toString () {		
		if (!$this->login)
			return "USER :\tNot found!\n---------------------------\n";
		
		$ad = $this->isadmin ? "YES" : "NO";
		
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

	public function auth($pass) {
	//$log & $pass must be sent by $_POST; $pass is sent hashed;
		if ($pass === $this->_passwd)
			return TRUE;
		return FALSE;
	}

	public function getInfos($log) {
	//fills the new User vars with database datas;

		//check for array
		if (is_array($log))
			$log = $log['login'];
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
		$this->confirmed = $usr['confirmed'];
	}

	public function create($usr_infos) {
	//$usr_infos must be an array in which every key corresponds to the DB entries;

		if (!is_array($usr_infos))
			return FALSE;

		//Check required values;
		if (!key_exists('login', $usr_infos) || !key_exists('pass', $usr_infos) || !key_exists('mail', $usr_infos))
		{
			echo "lacking required key" . PHP_EOL;
			return FALSE;
		}

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
			echo "USER : " . $usr_infos['login'] . " added to DB" . PHP_EOL . "<br/>";
		
		//Create OBJECT
		$this->__construct($usr_infos['login']);
 	}

 	public function confirm($token)
 	{
 		if ($token == hash('whirlpool', $this->login))
 		{
 			$this->confirmed = TRUE;

 			//set var in db;
 			$query = "update users set confirmed=1 where login='$this->login'";
 			$db = connect_db(FALSE);
 			$db->exec('USE' . $DB_NAME);
 			try { $db->exec($query);}
 			catch (PDOexception $e) {
 				die ('ERROR UPDATING USER: ' . $e->getMessage());
			}

			//ret;
 			return TRUE;
 		}
 		else
 			return FALSE;
 	}

 	public function signin()
 	{
 		if ($this->confirmed)
 		{
 			$_SESSION['log'] = TRUE;
 			$_SESSION['user'] = $this;
 			return TRUE;
 		}
 		echo "Please confirm your account before signing in";
 		return FALSE;
 	}
 }

?>