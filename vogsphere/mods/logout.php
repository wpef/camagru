<?php
include_once ('../config/inc.php');

if ($_SESSION['user'])
	$_SESSION['user']->logout();
else
	session_destroy();

$_SESSION['message'] = "You were successfully logout.";
header('Location: '. WEBROOT . 'index.php?action=logout');

?>