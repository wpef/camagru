<?php

//REQUIRED
include_once ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . "/config/manage_db.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . "/class/User.class.php");
include_once ('functions.php');
session_start();

//REDIRECTION IF NEEDED
if (!$_SESSION['log'])
{
	$_SESSION['alert'] = "You must be logged in to access this page.";
	exit(header('Location: /camagru/index.php'));
}

//HEADER
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . "/template-parts/modif_account.php");

//FOOTER
include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/footer.php');

?>