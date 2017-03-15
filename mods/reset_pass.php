<?php
include_once ("../config/inc.php");

if ($_GET['act'] == 'send')
{
	$usr = new User($_POST['login']);
	
	if (!$usr || $usr->mail !== $_POST['mail'])
	{ 
		$_SESSION['alert'] = "Wrong loging or email adress provided." ;
		header('Location: '. WEBROOT . 'pages/login.php?action=reset&act=getinfos');
		return FALSE;
	}

	//PREPARE MAIL
		$to = $usr->mail;
		$subject = "Reset your password for Camagru.com";
		$token = $usr->token();
		$link = "http://" . $_SERVER['HTTP_HOST'] . WEBROOT
						. 'pages/login.php?action=reset&act=confirm&login=' . $usr->login
						. "&token=" . $token;
		$message = "<html><head><title>Reset your password for Camagru</title></head><body><p>Hello " . $usr->login . ",</p><p>This message contains a link to reset your password on Camagru.com, if you did not request it, ignore this message.</p><p>Here is the link to reset your password :<br/><a href=\"". $link . "\">Reset my password</a></p><p>or copy-paste this link in your bowser : </p><p>" . $link . "</p><p>Peace. <3</p></body></html>";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Camagru.com <hello@camagru.com>' . "\r\n";
	//END

	//send mail
	if (mail($to, $subject, $message, $headers))
		$_SESSION['message'] = "We've just sent you an email at $to with a link to reset your password.";
	else
		$_SESSION['alert'] = 'Password reset request rejected, the e-mail could not be sent';
	header('Location: '. WEBROOT . 'pages/login.php?action=signin');
}

if ($_GET['act'] == 'reset')
{
	if ($_POST['new_pw'] === $_POST['new_pw1'])
	{
		$_SESSION['user']->modif('pass', hash('whirlpool', $_POST['new_pw1']));
		$_SESSION['message'] = "Your password has been successfully reset, you may now login with your new password";
		header('Location: '. WEBROOT . 'pages/login.php?action=signin');
	}
	else
	{
		$_SESSION['alert'] = "The passwords you provided are not the same.";
		header('Location: '. WEBROOT . 'pages/login.php?action=reset&act=getinfos');
	}
}

?>