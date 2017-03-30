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
	public			$error;
	public			$confirmed;

/* ==> DEFAULT METHOD <== */
	public function __construct($log) {
	// if user exists on DB, all vars will be set, else it will be added to DB
		if (userExists($log))
		{
			$this->getInfos($log);
			if (self::$verbose)
				echo $this . " CONSTRUCTED" . PHP_EOL;
		}
		else
			$this->_create($log);
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

		//setting query string;
		$query = "SELECT * FROM users WHERE login = ?;";

		//getting result;
		$res = getDatas($query, $log);
		//var_dump($res);

		//setting vars
		$res = $res[0];
		$this->login = $res['login'];
		$this->_passwd = $res['pass'];
		$this->mail = $res['mail'];
		$this->f_name = $res['f_name'];
		$this->l_name = $res['l_name'];
		$this->name = $res['f_name'] . " " . $res['l_name'];
		$this->isadmin = $res['isadmin'];
		$this->confirmed = $res['confirmed'];
	}

	private function _create($usr_infos) {
	//$usr_infos must be an array in which every key corresponds to the DB entries;

		if (!is_array($usr_infos) OR (!$this->_checkArray($usr_infos)))
		{
			if (!isset($this->error))
				$this->error = "Wrond datas provided";
			return FALSE;
		}

		//send query;
		insertDatas('users', $usr_infos);

		//VERBOSE
		if (self::$verbose)
			echo "USER : " . $usr_infos['login'] . " added to DB" . PHP_EOL . "<br/>";
		
		//Create OBJECT
		$this->__construct($usr_infos['login']);
 	}

 	public function toDetailsHTML () {
 		$user_html = "<a class='pic_owner' href='". WEBROOT . "pages/gallery.php?user=$this->login'>$this->login</a>";
 		return ($user_html);
 	}

 	private function _checkArray ($a)
 	{
 		if (!array_key_exists('login', $a) OR !array_key_exists('pass', $a) OR !array_key_exists('mail', $a))
 		{
 			$this->error = "An error occured";
 			return FALSE;
 		}
 		if (count($a['login']) > 15)
 		{
 			$this->error =  "Login max length is 15 char.";
 			return FALSE;
 		}
 		if (preg_match("#[\W]+#", $a['login']) == 1)
 		{
 			$this->error =  "Login must only contains letters numbers and underscores";
 			return FALSE;
 		}
 		if (!filter_var($a['mail'], FILTER_VALIDATE_EMAIL) OR count($a['mail']) > 30)
 		{
 			$this->error =  "The email adress is not valid";
 			return FALSE;
 		}
 		return TRUE;
 	}

 	public function confirm($token)
 	{
 		if ($token == hash('whirlpool', $this->login))
 		{
 			$this->confirmed = TRUE;

 			//set var in db;
 			$query = "UPDATE users SET confirmed=1 WHERE login='$this->login';";
 			sendQuery($query);
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

 	public function getImages()
 	{
 		$p_query = "SELECT pic_id FROM pictures WHERE pic_owner = ? ORDER BY added_on DESC;";
 		$images_ids = getDatas($p_query, $this->login);
 		return ($images_ids);
 	}

 	public function notif($datas)
 	{
 		$picture = new Picture ($datas['com_pic']);
 		$author = $datas['com_author'];
 		$content = $datas['com_cont'];
 		$date = $datas['com_date'];
 		//en cours
 	}
 }

?>