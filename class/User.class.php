<?php

include_once(ROOT . "config/inc.php");

class User {

	public			$login;
	private			$_passwd;
	public			$f_name;
	public			$l_name;
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
		$this->l_name = $usr['l_name'];
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
		insert_datas('users', $usr_infos);

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
 			$query = "update users set confirmed=1 where login='$this->login';";
 			$db = connect_db(FALSE);
 			$db->exec('USE' . $DB_NAME);
 			try { $db->exec($query);}
 			catch (PDOexception $e) {
 				die ('ERROR UPDATING USER: ' . $e->getMessage());
			}
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

 	public function logout()
 	{
 		foreach ($_COOKIE as $key => $val) {
			setcookie($key, "", time()-3600);
		}
		if (isset($_COOKIE))
			unset ($_COOKIE);

		foreach ($_SESSION as $key => $val) {
			$_SESSION[$key] = "";
			unset($_SESSION[$key]);
		}
		if (isset($_SESSION))
			unset ($_SESSION);

		session_destroy();
		$this->__destruct();
 	}

 	public function modif($attr, $val)
 	{
 		//modif method is used to modify an attribute into the DB. It also update the vars in the User object;
 		if ($attr == 'ID')
 			return FALSE;
 		$db = connect_db(FALSE);
 		$val = is_string($val) ? "'".$val."'" : $val;
 		$qry = "update users set " . $attr . "=" . $val . "where login='$this->login';";
 		try { $db->exec($qry);}
 		catch (PDOexception $e) {
 			die ('ERROR UPDATING USER: ' . $e->getMessage());
 		}
 		$this->getInfos($this->login);
 		return TRUE;
 	}

 	public function token()
 	{
 		return hash('md5', $_passwd);
 	}

 	public function getImages($order) {
 		$sel = array('pic_src', 'pic_name'); //comments and like;
 		$a = array('select' => $sel,
 			'where' => 'pic_owner = ' . $this->login,
 			'order' => !empty($order) ? $order : 'added_on');
 		
 		$images = get_datas('pictures', $a);
 	}
 }

?>