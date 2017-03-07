<?php

//REQUIRED
define('access', true);
include_once ('config/inc.php');

//REDIRECTION IF NEEDED
if (!$_SESSION['log'])
	exit(header('Location: pages/gallery.php'));

//HEADER HTML
include_once('template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
include_once('template-parts/video.php');

//FOOTER
include_once('template-parts/footer.php');

?>