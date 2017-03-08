<?php

//REQUIRED
define('access', true);
include_once ('config/inc.php');

//REDIRECTION IF NEEDED
if (!$_SESSION['log'])
	exit(header('Location: pages/gallery.php'));
if ($_GET['error'] == 'direct_access')
	$_SESSION['alert'] = 'Direct access not permitted';

//HEADER HTML
include_once('template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
include_once('template-parts/video.php');

//FOOTER
include_once('template-parts/footer.php');

?>