<?php 

//REQUIRED
define('access', true);
include_once ('../config/inc.php');

//REDIRECTION IF NEEDED
if ($_SESSION['log'])
	exit(header('Location: ../index.php'));

//HEADER
include_once('../template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
if ($_GET['action'] == 'signin')
	include('../template-parts/signin.php');
else if ($_GET['action'] == 'reset')
	include('../template-parts/reset_pass.php');
else
	include('../template-parts/signup.php');


//FOOTER
echo "<script type=\"text/javascript\" src=\"" . WEBROOT . "script/form.js\"></script>";
include_once('../template-parts/footer.php');

?>