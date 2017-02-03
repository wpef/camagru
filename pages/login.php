<?php 

//REQUIRED
include_once ($_SERVER['DOCUMENT_ROOT'] . "/class/User.class.php");
session_start();

//REDIRECTION IF NEEDED
if ($_SESSION['log'])
	exit(header('Location: /index.php'));

//HEADER
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
if ($_GET['action'] == 'signin')
	include($_SERVER['DOCUMENT_ROOT'] . '/template-parts/signin.php');
else
	include($_SERVER['DOCUMENT_ROOT'] . '/template-parts/signup.php');


//FOOTER
include_once($_SERVER['DOCUMENT_ROOT'] . '/template-parts/footer.php');

?>