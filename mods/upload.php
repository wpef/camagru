<?php
include_once('../config/inc.php');

define('DIR', WEBROOT . "photos/");
if (!empty($_FILES)){
	if (!move_uploaded_file('photo', DIR . "photo.png"))
		$_SESSION['alert'] = "An error occured while uploading file";
}
else {
	$_SESSION['alert'] = "File not found."; 
}
exit();
?>