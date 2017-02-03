<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . "/config/manage_db.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . "/class/User.class.php");
session_start();

if ($_GET['action'] == 'reset' || $_GET['action'] == 'send')
	header('Refresh: 1; URL=/camagru/index.php'); //send to login
?>

<?php if ($_GET['action'] == 'getinfos') : ?>

	<form name="reset_pass" method="post" action="/camagru/mods/reset_pass.php?action=send">
	Login : <input type="text" name="login" required/><br>
	Mail  : <input type="text" name="mail" required /><br>
	<input type="submit" name="submit" value="Send reset link" /><br>
	</form>

<?php endif; ?>

<?php 

if ($_GET['action'] == 'send')
{
	$usr = new User($_POST['login']);
	
	if (!$usr || $usr->mail !== $_POST['mail'])
	{ 
		echo "Wrong loging or email adress provided." ;
		return FALSE;
	}

	//else : prepare mail
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
	<p>Here is the link to reset your password :<br/><a href=\"http://localhost:8080/camagru/mods/reset_pass.php?action=confirm&login=" . $usr->login . "&token=" . $token .  "\">Reset my password</a></p>
	<p>Peace. <3</p>
	</body>
	</html>
	";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Camagru.com <hello@camagru.com>' . "\r\n";

	//send mail
	if (mail($to, $subject, $message, $headers))
		echo "We've just sent you an email with a link to reset your password.";
	else
		echo 'Password reset request rejected, the e-mail could not be sent';

}
?>

<?php

if ($_GET['action'] == 'confirm') :
	$log = $_GET['login'];
	$token = $_GET['token'];

if (isset($_SESSION['user']))
	unset($_SESSION['user']);
$_SESSION['user'] = new User($log);
if (isset($_SESSION['user']) && $token === $_SESSION['user']->token()) :

?>

	<p> You are resetting the password for <?php echo $log ?>.</p>
	<form name="reset" method="post" action="/camagru/mods/reset_pass.php?action=reset">
	New Password : <input type="text" name="new_pw" required/><br>
	Confirm Password  : <input type="text" name="new_pw1" required /><br>
	<input type="submit" name="submit" value="Reset password" /><br>
	</form>

<?php endif; endif; ?>

<?php
if ($_GET['action'] == 'reset')
{
	if ($_POST['new_pw'] === $_POST['new_pw1'])
	{
		$_SESSION['user']->modif('pass', hash('whirlpool', $_POST['new_pw1']));
		echo "Your password has been successfully reset, you may now login with your new password";
	}
	else
	{
		echo "The passwords you provided are not the same.";
	}
}

?>