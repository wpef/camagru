<?php
include_once('../config/inc.php');

define('DIR', WEBROOT . "photos/");
static $i = 0;


$imgb64 = $_POST['pic'];
if (empty($imgb64))
	exit();

$imgb64 = str_replace(' ','+',$imgb64); //JS to PHP decode
$imgb64 = substr($data,strpos($data,",")+1); //remove data:img/png ...
$img = base64_decode($imgb64); //decode string

file_put_contents(WEBROOT . 'photo'.$i++.'.png', $img);

?>
