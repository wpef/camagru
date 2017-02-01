<?php
define ('_ROOT_', getenv('HTTP_HOST'));
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/setup.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/class/User.class.php');
session_start();

if ($_SESSION) {
	if ($_SESSION['user']->isadmin)
		echo "<h1> WELCOME ADMIN " . $_SESSION['user']->name . "</h1>";
}
?>