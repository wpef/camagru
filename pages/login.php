<?php 

//REQUIRED
include_once ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . "/class/User.class.php");
include_once ('functions.php');
session_start();

//REDIRECTION IF NEEDED
if ($_SESSION['log'])
	exit(header('Location: /camagru/index.php'));

//HEADER
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
if ($_GET['action'] == 'signin')
	include($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/signin.php');
else if ($_GET['action'] == 'reset')
	include($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/reset_pass.php');
else
	include($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/signup.php');


//FOOTER
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/footer.php');

?>