<?php

require_once('..' . '/config/manage_db.php');

class User {
	public			$login;
	private			$passwd;
	public			$f_name;
	public			$name;
	public			$mail;
	public static	$verbose = FALSE;
	public			$isadmin;

	/* ==> DEFAULT METHOD <== */
	public function __construct($log) {
	// create class getting infos from BDD searching for login
	// ==> (SELECT login, mdp, etc. FROM users WHERE login == $login)
		
		$db = connect_db(FALSE);

		//setting query string;
		$query = "select * FROM users WHERE login = '" . $log . "';";

		//getting result;
		$db->exec("USE " . $DB_NAME);
		$usr = $db->query($query)->fetch();

		//setting vars
		$this->login = $usr['login'];
		$this->passwd = $usr['pass'];
		$this->mail = $usr['mail'];
		$this->f_name = $usr['f_name'];
		$this->name = $usr['f_name'] . " " . $usr['l_name'];
		$this->isadmin = $usr['isadmin'];		

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

		$st = "USER :\n";
		$log = "\t" . "Login = " . $this->login . "\n"; 
		$name = "\t" . "Name = " . $this->name . "\n";
		$mail = "\t" . "Mail = " . $this->mail . "\n";
		$adm = "\t" . "isadmin = " . $ad . "\n";
		$end = "---------------------------\n"; 

		return ($st . $log . $name . $mail . $adm . $end);
	}

	/* MY METHODS */
	public function auth($log, $pass)
	{
		//if $_POST[login] ==> get_mdp && compare;
	}

	public function create($usr_infos)
	{
		if (!is_array($usr_infos))
			return FALSE;
 	}
}


// DEBUG
User::$verbose = TRUE;
$usr = new User('pef');

?>
