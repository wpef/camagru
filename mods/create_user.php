<?php
include_once ($_SERVER['DOCUMENT_ROOT'] . "/class/User.class.php");

session_start(); //for debug

header('Refresh: 3; URL=/index.php');

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
	$_SESSION['auth_err'] = 'login_exists';
	echo "The login you are trying to use is already registered. Please try again with a new login";
	//relaunch signup with error message;
	return;
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
<p>Here is the link to activate :<br/><a href=\"http://localhost:8080/mods/confirm_account.php?login=" . $current_user->login . "&token=" . $token .  "\"> Activate my account</a></p>
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
	echo "Your account was succesfully created, please confirm registration via the email we sent you.";
else
	echo 'User creation rejected, the e-mail confirmation could not be sent';

?>