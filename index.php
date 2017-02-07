<?php

//REQUIRED
include_once ('config/inc.php');

//REDIRECTION IF NEEDED
if (!$_SESSION['log'])
{
	$_SESSION['alert'] = 'You must be logged in to access this page, please log in or create an account !';
	exit(header('Location: pages/login.php?action=signin'));
}

if ($_GET['action'] == 'logout')
{
	$_SESSION['message'] = "You were successfully logout.";
	header('Location: pages/login.php'); //refresh
}

//HEADER HTML
include_once('template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
include_once('template-parts/video.php');

//FOOTER
include_once('template-parts/footer.php');

?>