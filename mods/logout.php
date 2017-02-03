<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . "/class/User.class.php");
session_start();

if ($_SESSION['user'])
{
	$_SESSION['user']->logout();
}
else
	session_destroy();

$_SESSION['message'] = "You were successfully logout.";
header('Location: /camagru/index.php?action=logout');
?>