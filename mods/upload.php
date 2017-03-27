<?php
include_once('../config/inc.php');

define('DIR', ROOT . "photos/");

//PARSING

$user = $_SESSION['user'];
$imgb64 = $_POST["pic"];

if (empty($imgb64) or empty($user))
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
	else
	{
		$pict->getId();
		echo $pict->toArticleHTML($user, true);
	}
}

?>