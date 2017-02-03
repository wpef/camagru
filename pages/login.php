<?php 

//REQUIRED
include_once ($_SERVER['DOCUMENT_ROOT'] . "/class/User.class.php");
include_once ('functions.php');
session_start();

//REDIRECTION IF NEEDED
if ($_SESSION['log'])
	exit(header('Location: /index.php'));

//HEADER
include_once($_SERVER['DOCUMENT_ROOT'] . '/template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
if ($_GET['action'] == 'signin')
	include($_SERVER['DOCUMENT_ROOT'] . '/template-parts/signin.php');
else
	include($_SERVER['DOCUMENT_ROOT'] . '/template-parts/signup.php');


//FOOTER
include_once($_SERVER['DOCUMENT_ROOT'] . '/template-parts/footer.php');

?>