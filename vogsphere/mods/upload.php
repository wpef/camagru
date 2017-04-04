<?php
include_once('../config/inc.php');

define('DIR', ROOT . "photos/");

//PARSING
$user = $_SESSION['user'];
$imgb64 = $_POST["pic"];
$stickerName = $_POST['stick'];

if (empty($imgb64) or empty($user))
{
	$_SESSION['alert'] = 'ERROR : No files found';
	die();
}
if (!file_exists(ROOT . "stickers/" . $stickerName))
{
	$_SESSION['alert'] = 'ERROR : $stickerName : This sticker is no longer available';
	die();
}

//TRAITING
$pict = new Picture(array('data' => $imgb64));
if (!empty($pict->error))
{
	$_SESSION['alert'] = $pict->error;
	echo "DEBUG = $pict->error";
}
else
{
	$pict->merge(ROOT . "stickers/" . $stickerName);
	$pict->getId();
	echo $pict->toArticleHTML($user, true);
}

?>