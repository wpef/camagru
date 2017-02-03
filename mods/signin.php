<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/config/manage_db.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/class/User.class.php');
session_start();

sign_in();
header('Location: /pages/login.php?action=signin');

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