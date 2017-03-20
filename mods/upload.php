<?php
include_once('../config/inc.php');

define('DIR', ROOT . "photos/");

//PARSING

if (!empty($_POST['pic']))
	$imgb64 = $_POST["pic"];
else
{
	$_SESSION['alert'] = 'ERROR : No files found';
	exit();
}


//TRAITING
if (!empty($imgb64)) {
	$pict = new Picture(array('data' => $imgb64));
	if (!empty($pict->error))
	{
		$_SESSION['alert'] = $pict->error;
		die();
	}
}

?>