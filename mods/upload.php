<?php
include_once('../config/inc.php');

define('DIR', ROOT . "photos/");

$imgb64 = $_POST["pic"];

if (empty($_POST))
	$_SESSION['alert'] = 'ERROR : No data received!';

// foreach ($_POST as $post) {
// 	foreach ($post as $key => $value) {
// 		$_SESSION['alert'] .= "$key => $val";
// 	}
// }


$imgb64 = str_replace(' ','+',$imgb64); //JS to PHP decode
$imgb64 = substr($imgb64,strpos($imgb64,",")+1); //remove data:img/png ...
$img = base64_decode($imgb64); //decode string
$img_name = get_photo_name();
$img_src = DIR . $img_name;

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
