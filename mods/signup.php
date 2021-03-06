<?php
include_once('../config/inc.php');

//ACTION
if ($_GET['action'] == 'create')
{
	if (create_user())
		header('Location: '. WEBROOT . 'pages/login.php?action=signin');
	else
		header('Location: '. WEBROOT . 'pages/login.php?action=signup');
}

if ($_GET['action'] == 'confirm')
{
	if (confirm_user())
		header('Location: '. WEBROOT . 'pages/login.php?action=signin');
	else
		header('Location: '. WEBROOT . 'pages/login.php?action=signup');

}


//REQUIRED FUNCTIONS;
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
		if (userExists($new_user))
		{
			$_SESSION['alert'] = "The login you are trying to use is already registered. Please try again with a new login";
			return FALSE;
		}

		//Add new user to db
		$current_user = new User($new_user);
		if (isset($current_user->error))
		{
			$_SESSION['alert'] = $current_user->error;
			return FALSE;
		}

		//prepare mail
			$name = $current_user->login;
			$to = $current_user->mail;
			$subject = "Confirm the account you created on Camagru.com";
			$token = hash('whirlpool', $current_user->login);
			$link = "http://" . $_SERVER['HTTP_HOST'] . WEBROOT
						. "mods/signup.php?login=" . $current_user->login . "&token=" . $token .  "&action=confirm";
			$message = " <html> <head> <title>Confirm your account on Camagru</title></head><body><p>Hello " . $name . ",</p><p>You have just created an account on Camagru.com, but you still need to activate your account</p><p>Here is the link to activate :<br/><a href=\"". $link . "\">Activate my account</a></p><p>or copy-paste this link in your bowser : </p><p>" . $link . "</p><p>Thanks for activating the account.</p><p>Peace. <3</p></body></html>";
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

?>