<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/config/manage_db.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/class/User.class.php');
session_start();

function create_user()
{
	$new_user = array (
		'login' => $_POST['login'],
		'pass' => hash('whirlpool', $_POST['pass']),
		'mail' => $_POST['mail'],
		'l_name' => $_POST['l_name'],
		'f_name' => $_POST['f_name']
		);

	//si login deja utilisé
	if (user_exists($new_user))
	{
		$_SESSION['alert'] = "The login you are trying to use is already registered. Please try again with a new login";
		return FALSE;
	}

	//Add new user to db
	$current_user = new User($new_user);

	//prepare mail
	$to = $current_user->mail;
	$subject = "Confirm the account you created on Camagru.com";
	$token = hash('whirlpool', $current_user->login);
	$message = "
	<html>
	<head>
	<title>Confirm your account on Camagru</title>
	</head>
	<body>
	<p>Hello " . $current_user->name . ",</p>
	<p>You have just created an account on Camagru.com, but you still need to activate your account</p>
	<p>Here is the link to activate :<br/><a href=\"http://localhost:8080/camagru/mods/signup.php?login=" . $current_user->login . "&token=" . $token .  "&action=confirm\"> Activate my account</a></p>
	<p>Thanks for activating the account.</p>
	<p>Peace. <3</p>
	</body>
	</html>
	";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Camagru.com <hello@camagru.com>' . "\r\n";

	//send mail
	if (mail($to, $subject, $message, $headers))
	{
		$_SESSION['message'] = "Your account was succesfully created, please confirm registration via the email we sent you.";
		return TRUE;
	}
	else
		$_SESSION['alert'] = 'User creation rejected, the e-mail confirmation could not be sent';
		return FALSE;
}

function confirm_user()
{
	$user = new User($_GET['login']);
	if ($user->confirm($_GET['token']))
	{
		$user->signin();
		$_SESSION['message'] = "Your account was successfully verified. You are now signed in as " . $user->login;
		return TRUE;
	}
	else
	{
		$_SESSION['alert'] = "Your login or token is wrong.";
		return FALSE;
	}

}

if ($_GET['action'] == 'create')
{
	if (create_user())
		header('Location: /camagru/pages/login.php?action=signin');
	else
		header('Location: /camagru/pages/login.php?action=signup');
}

if ($_GET['action'] == 'confirm')
{
	if (confirm_user())
		header('Location: /camagru/pages/login.php?action=signin');
	else
		header('Location: /camagru/pages/login.php?action=signup');

}

?>