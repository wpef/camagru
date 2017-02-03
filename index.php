<?php

//REQUIRED
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/setup.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/class/User.class.php');
session_start();

//REDIRECTION IF NEEDED
if (!$_SESSION['log'])
{
	$_SESSION['alert'] = 'You must be logged in to access this page, please log in or create an account !';
	exit(header('Location: /pages/login.php'));
}

//HEADER HTML
include_once($_SERVER['DOCUMENT_ROOT'] . '/template-parts/header.php');

//ALERT
if (!empty($_SESSION['message']) || !empty($_SESSION['alert']))
{
	if (!empty($_SESSION['message']))
		echo "<p class='message'>" . $_SESSION['message'] . '</p>';
	if (!empty($_SESSION['alert']))
		echo "<p class='alert'>" . $_SESSION['alert'] . '</p>';
	unset($_SESSION['message']); unset($_SESSION['alert']); 
}

//CONTENT

//FOOTER
include_once($_SERVER['DOCUMENT_ROOT'] . '/template-parts/footer.php');

?>