<?php
include_once('../config/inc.php');

define('DIR', ROOT . "photos/");

$imgb64 = $_POST["pic"];

 if (empty($_POST) || empty($imgb64) ) {
 	$_SESSION['alert'] = 'ERROR : No data received!';
 	exit();
 }

$pict = new Picture(array('data' => $imgb64));

if (!empty($pict->error))
	$_SESSION['alert'] = $pict->error;

?>