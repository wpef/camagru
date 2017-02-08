<?php
include_once('../config/inc.php');

define('DIR', ROOT . "photos/");

$imgb64 = $_POST["pic"];

if (empty($_POST)) {
	$_SESSION['alert'] = 'ERROR : No data received!';
	exit();
}

if (empty($imgb64)) {
	$_SESSION['message'] = "Photo fef3fefuploaded.";
	exit();
}


$imgb64 = str_replace(' ','+',$imgb64); //JS to PHP decode
$imgb64 = substr($imgb64,strpos($imgb64,",")+1); //remove data:img/png ...
$img = base64_decode($imgb64); //decode string
$img_name = get_photo_name();
$img_src = DIR . $img_name;

//BUG but array is OK for sure;
// $pict = new Picture(array(
// 	'src' => $img_src,
// 	'name' => $img_name,
// 	'owner' => $_SESSION['user']->login));

//$_SESSION['alert'] = "$pict";


if (file_put_contents($img_src, $img))
	$_SESSION['message'] = "Photo uploaded.";
else
	$_SESSION['alert'] .= "An error occured uploading the file.";

function get_photo_name()
{
	$i = 0;
	do {
		$file = 'photo' . $i . '.png';
		$i++;
		} while (file_exists(DIR . $file));
	return ($file); 
}

?>
