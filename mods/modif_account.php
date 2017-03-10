<?php
include_once('../config/inc.php');

//verif form
if ($_POST['submit'] != 'Apply modifications' OR $_POST['login'] != $_SESSION['user']->login) {
	$_SESSTION['alert'] = "Please use the form.";
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
					$_SESSION['user']->modif('pass', hash('whirlpool',$_POST['new_pw2']));
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
			if ($value != $_SESSION['user']->$key)
			{
				$_SESSION['user']->modif($key, $value);
				$tab[] = $key;
			}
		}
	}
	$str = implode(", ", $tab);
	if ($str)
		$_SESSION['message'] =  "Value(s) for " . $str . " has been modified.";
	return TRUE;
}
?>