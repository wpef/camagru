<?php
include_once('../config/inc.php');

if (!$_POST) {
	$_SESSTION['alert'] = "an error occured.";
	exit(header('Location: '. WEBROOT . 'pages/account_settings.php'));
}

if (modif_account())
	header('Location: '. WEBROOT . '/index.php');
else
	header('Location: '. WEBROOT . 'pages/account_settings.php');

function modif_account()
{
	//check password; 
	if (!empty($_POST['old_pw']))
	{
		if (!empty($_POST['new_pw1']) && !empty($_POST['new_pw2']))
		{
			if ($_SESSION['user']->auth(hash('whirlpool' , $_POST['old_pw'])))
			{
				if ($_POST['new_pw1'] === $_POST['new_pw2'])
				{
					$_SESSION['user']->modif('pass', hash('whirlpool',$_POST['new_pw2']));
					$_SESSION['message'] = "password, ";
				}
				else
				{
					$_SESSION['alert'] = "Please confirm your new password";
					return FALSE;
				}
			}
			else
			{
				$_SESSION['alert'] = "The old password you provided is wrong.";
				return FALSE;
			}
		}
		else
		{
			$_SESSION['alert'] = "Please provide and confirm a new password";
			return FALSE;
		}
	}

	//set new values in DB;
	foreach ($_POST as $key => $value) {
		if ($key != 'submit' && $key != 'old_pw' && $key != 'new_pw1' && $key != 'new_pw2' && $key != 'login' && !empty($value))
		{
			$_SESSION['user']->modif($key, $value);
			$_SESSION['message'] .=  $key. ", ";
		}
	}
	$_SESSION['message'] =  "Values for " . $_SESSION['message'] . "has been modified.";
	return TRUE;
}

?>