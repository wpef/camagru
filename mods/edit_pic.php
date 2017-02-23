<?php 

/////// INCLUDES
include_once('../config/inc.php');

///////// ERROR HANDLING
if (empty($_POST))
{
	echo "A PROBLEM OCCURED";
	return FALSE;
}

///////// STD VARS
$pic_id = $_POST['pic_id'];


/////// PARSING
if ($_GET['act'] == 'like')
{
	$user = $_POST['login'];
	if (like_pic($pic_id, $user) !== TRUE)
		return FALSE;
}

if ($_GET['act'] == 'rename')
{
	$newName = $_POST['newName'];
	//proceed newName
	if (rename_pic($pic_id, $newName) !== TRUE)
		return FALSE;
	echo $newName;
}


////////////////// FUNCTIONS

function like_pic($pic_id, $user)
{
	$pict = new Picture(array('id' => $pic_id));
	if ($pict->like($user))
		return TRUE;
	return FALSE;
}

function rename_pic($pic_id, $newName)
{
	$pict = new Picture(array('id' => $pic_id));
	if ($pict->modify(array('pic_name' => $newName)))
		return TRUE;
	return FALSE;
}

?>