<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . "/class/User.class.php");
session_start(); //for debug
header('Refresh: 1; URL=/index.php');

if (!$_POST['login'] || !$_POST['pass'])
{
	echo "An error occured";
	var_dump($_POST);
	return FALSE;
}

$user = new User($_POST['login']);
if (!$user)
	echo "The login you provided is not registered"; //resend to signin;
if ($user->auth(hash('whirlpool', $_POST['pass']))) {
	if ($user->signin()) {
		echo "You were succesfully logged in"; //send to index;
		return TRUE;
	}
	else
		echo "The password you provided does not match your login.";
}
return FALSE; //re-send to signin;

?>