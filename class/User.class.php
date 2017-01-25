<?php

class User {
	public $login; //
	public $f_name;
	public $name;
	public static $verbose = FALSE;
	public $isadmin;
	private $passwd;

	/* ==> DEFAULT METHOD <== */
	public function __construct($login) {
		// create class getting infos from BDD searching for login
		// ==> (SELECT login, mdp, etc. FROM users WHERE login == $login)
		
	}

	public function __destruct() {
	}

	public function __toString () {

	}

	/* MY METHODS */
	public function auth($_POST['login'], $_POST['passwd'])
	{
		//if $_POST[login] ==> get_mdp && compare;
	}

	public function create($usr_infos)
	{
		if (!is_array($usr_infos))
			return FALSE;
 	}
}

?>
