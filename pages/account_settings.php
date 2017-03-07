<?php

//REQUIRED
define('access', true);
include_once ('../config/inc.php');

//REDIRECTION IF NEEDED
if (!$_SESSION['log'])
	exit(header('Location: ' . WEBROOT . 'pages/login.php'));

//HEADER
include_once(ROOT . '/template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
include_once(ROOT . 'template-parts/modif_account.php');
//FOOTER
include_once(ROOT . 'template-parts/footer.php');

?>