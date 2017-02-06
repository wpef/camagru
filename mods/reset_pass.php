<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . "/config/manage_db.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . "/class/User.class.php");

session_start(); 

if ($_GET['act'] == 'send')
{
	$usr = new User($_POST['login']);
	
	if (!$usr || $usr->mail !== $_POST['mail'])
	{ 
		$_SESSION['alert'] = "Wrong loging or email adress provided." ;
		header('Location: /camagru/pages/login.php?action=reset&act=getinfos');
		return FALSE;
	}

	$to = $usr->mail;
	$subject = "Reset your password for Camagru.com";
	$token = $usr->token();
	$message = "
	<html>
	<head>
	<title>Reset your password for Camagru</title>
	</head>
	<body>
	<p>Hello " . $usr->name . ",</p>
	<p>This message contains a link to reset your password on Camagru.com, if you did not request it, ignore this message.</p>
	<p>Here is the link to reset your password :<br/><a href=\"http://localhost:8080/camagru/pages/login.php?action=reset&act=confirm&login=" . $usr->login . "&token=" . $token .  "\">Reset my password</a></p>
	<p>Peace. <3</p>
	</body>
	</html>
	";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Camagru.com <hello@camagru.com>' . "\r\n";

	//send mail
	if (mail($to, $subject, $message, $headers))
		$_SESSION['message'] = "We've just sent you an email with a link to reset your password.";
	else
		$_SESSION['alert'] = 'Password reset request rejected, the e-mail could not be sent';
	header('Location: /camagru/pages/login.php?action=signin');
}

if ($_GET['act'] == 'reset')
{
	if ($_POST['new_pw'] === $_POST['new_pw1'])
	{
		$_SESSION['user']->modif('pass', hash('whirlpool', $_POST['new_pw1']));
		$_SESSION['message'] = "Your password has been successfully reset, you may now login with your new password";
		header('Location: /camagru/pages/login.php?action=signin');
	}
	else
	{
		$_SESSION['alert'] = "The passwords you provided are not the same.";
		header('Location: /camagru/pages/login.php?action=reset&act=getinfos');
	}
}

?>