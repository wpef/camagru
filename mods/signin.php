<?php

include_once('../config/inc.php');

sign_in();
header('Location: '. WEBROOT . 'pages/login.php?action=signin');

function sign_in() {
	if (!$_POST['login'] || !$_POST['pass'])
	{
		$_SESSION['alert'] = "An error occured";
		return FALSE;
	}

	$user = new User($_POST['login']);

	if (!$user)
		$_SESSION['alert'] = "The login you provided is not registered";

	if ($user->auth(hash('whirlpool', $_POST['pass'])))
	{
		if ($user->signin())
		{
			$_SESSION['message'] = "You were succesfully logged in.";
			return TRUE;
		}
	}
	else
		$_SESSION['alert'] = "Wrong password or login.";
	return FALSE; 
}

?>