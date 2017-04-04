<?php

include ($_SERVER['DOCUMENT_ROOT'] . "/class/User.class.php");
header('Refresh: 1; URL=/index.php'); //send to sign in page. 


if (!$_GET)
	return;
$user = new User($_GET['login']);
if ($user->confirm($_GET['token']))
{
	$user->signin();
	echo "Your account was successfully verified. You can now sign in using your account details.";
}
else
	echo "Your login or token is not recognised. Please sign up again or send an email to the webmaster.";

?>