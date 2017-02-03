<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . "/class/User.class.php");
session_start();

if ($_SESSION['user'])
{
	$_SESSION['user']->logout();
}
$_SESSION['message'] = "You were successfully logout.";

header('Location: /index.php');
?>