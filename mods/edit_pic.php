<?php 
include_once('../config/inc.php');
//WORKS

if (empty($_POST))
{
	echo "A PROBLEM OCCURED";
	return FALSE;
}

if ($_GET['act'] == 'like')
{
	$pic_id = $_POST['pic_id'];
	$user = $_POST['login'];
	if (like_pic($pic_id, $user) !== TRUE)
		return FALSE;
}

function like_pic($pic_id, $user)
{
	$pict = new Picture(array('id' => $pic_id));
	if ($pict->like($user))
		return TRUE;
	return FALSE;
}

?>