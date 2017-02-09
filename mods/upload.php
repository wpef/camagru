<?php
include_once('../config/inc.php');

define('DIR', ROOT . "photos/");

$imgb64 = $_POST["pic"];

 if (empty($_POST) || empty($imgb64) ) {
 	$_SESSION['alert'] = 'ERROR : No data received!';
 	exit();
 }

// $imgb64 = str_replace(' ','+',$imgb64); //JS to PHP decode
// $imgb64 = substr($imgb64,strpos($imgb64,",")+1); //remove data:img/png ...
// $img = base64_decode($imgb64); //decode string
// $img_name = get_photo_name();
// $img_src = DIR . $img_name;

// $new = array(
// 	'src' => $img_src,
// 	'name' => $img_name,
// 	'owner' => $_SESSION['user']->login);

$pict = new Picture(array('data' => $imgb64)); //tested

if (!empty($pict->error))
	echo $pict->error;

?>
