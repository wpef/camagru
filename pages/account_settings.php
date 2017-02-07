<?php

//REQUIRED
include_once ('../config/inc.php');

//REDIRECTION IF NEEDED
if (!$_SESSION['log'])
{
	$_SESSION['alert'] = "You must be logged in to access this page.";
	exit(header('Location: ' . WEBHOST . '/index.php'));
}

//HEADER
include_once(ROOT . '/template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
include_once(ROOT . 'template-parts/modif_account.php');

//FOOTER
include_once(ROOT . 'template-parts/footer.php');

?>