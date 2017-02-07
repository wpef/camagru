<?php

// SET HERE DOCUMENT ROOT; 
$root = "camagru";


//NOT TO BE MODIFIED
	define('ROOT', $_SERVER['DOCUMENT_ROOT'] . "/". $root . "/");
	define('WEBROOT', "/". $root . "/");

	if (defined('ROOT')) :
		include_once (ROOT . "/config/manage_db.php");
		include_once (ROOT . "/class/User.class.php");
		include_once (ROOT . "pages/functions.php");
		session_start();
	endif;
//

?>