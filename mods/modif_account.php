<?php

include_once ($_SERVER["DOCUMENT_ROOT"] . "/config/manage_db.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/class/User.class.php");
session_start();
header('Refresh: 1; URL=/index.php');

if (!$_POST) { return FALSE; }

//check password; 
if (!empty($_POST['old_pw']) && !empty($_POST['new_pw1']))
{
	if ($_SESSION['user']->auth(hash('whirlpool' , $_POST['old_pw'])))
	{
		if ($_POST['new_pw1'] === $_POST['new_pw2'])
			$_SESSION['user']->modif('pass', hash('whirlpool',$_POST['new_pw2']));
		else
			echo "Please confirm your new password";
	}
	else
		echo "The old password you provided is wrong.";
}

foreach ($_POST as $key => $value) {
	if ($key != 'submit' && $key != 'old_pw' && $key != 'new_pw1' && $key != 'new_pw2' && $key != 'login' && !empty($value))
	{
		$_SESSION['user']->modif($key, $value);
		echo "The " . $key . " value as been modified.<br>";
	}
}

?>