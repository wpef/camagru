<?php

//REQUIRED
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/config/setup.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/class/User.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/pages/functions.php');
session_start();

//REDIRECTION IF NEEDED
if (!isset($_GET['action']) && !$_SESSION['log'])
{
	$_SESSION['alert'] = 'You must be logged in to access this page, please log in or create an account !';
	exit(header('Location: /camagru/pages/login.php'));
}

if ($_GET['action'] == 'logout')
{
	$_SESSION['message'] = "You were successfully logout.";
	header('Location: /camagru/pages/login.php'); //refresh
}

//HEADER HTML
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/video.php');

//FOOTER
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/footer.php');

?>