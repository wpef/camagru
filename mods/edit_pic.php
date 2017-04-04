<?php 

/////// INCLUDES
include_once('../config/inc.php');

///////// ERROR HANDLING
unset($_SESSION['alert']);

if (empty($_POST))
	$_SESSION['alert'] = "AN ERROR OCCURED";
else if (!isset($_SESSION['user']))
	$_SESSION['alert'] = "You must be logged in to interact";
else if (!userExists($_SESSION['user']->login))
	$_SESSION['alert'] = "An error occured";
else if (isset($_POST['pic_id']) && !is_numeric($_POST['pic_id']))
	$_SESSION['alert'] = "An error occured";

if (isset($_SESSION['alert']))
	header('Location: ' . WEBROOT);

///////// STD VARS
$pic_id = $_POST['pic_id'];
$com_error = "<p class='com_error'>AN ERROR OCCURED</p>##";
$user = $_SESSION['user'];

/////// PARSING
switch ($_GET['act']) { 
	case 'like' :
		if (like_pic($pic_id, $user->login) !== TRUE)
			return FALSE;
		break;

	case 'rename' :
		$newName = $_POST['newName'];
		if (rename_pic($pic_id, $user, $newName) !== TRUE)
			return FALSE;
		break;

	case 'delete' :
		if (delete_pic($pic_id, $user) !== TRUE)
			return FALSE;
		break;

	case 'load_coms' :
		$offset = $_POST['offset'];
		if (!is_numeric($offset) OR load_coms($pic_id, $offset) !== TRUE)
			return FALSE;
		break;

	case 'add_com' :
		$content = $_POST['content'];
		$com = add_com($pic_id, $user->login, $content);
		if ( $com == FALSE)
		{
			echo "com_error##";
			return FALSE;
		}
		else
			display_comment($com);
		break;
}
////////////////// FUNCTIONS

function like_pic($pic_id, $user)
{
	$pict = new Picture(array('id' => $pic_id));
	if (userExists($user))
	{
		if ($pict->like($user))
			return TRUE;
	}
	else
		echo "$user is not a valid member";
	return FALSE;
}

function rename_pic($pic_id, $user, $newName)
{
	$pict = new Picture(array('id' => $pic_id));
	if ($pict->owner != $user->login AND !$user->isadmin)
		return FALSE;
	if ($pict->modify(array('pic_name' => $newName)))
	{
		echo $pict->name;
		return TRUE;
	}
	return FALSE;
}

function delete_pic($pic_id, $user)
{
	$pict = new Picture(array('id' => $pic_id));
	if ($pict->owner == $user->login OR $user->isadmin)
	{
		sendQuery("DELETE FROM pictures WHERE pic_id = $pic_id;");
		sendQuery("DELETE FROM likes WHERE like_pic = $pic_id;");
	}
	else
	{
		$_SESSION['alert'] = "You cannot delete other users' pictures";
		return FALSE;
	}
	return TRUE;
}

function load_coms($pic_id, $offset)
{
	$pict = new Picture(array('id' => $pic_id));
	$coms = $pict->getComments(3, intval($offset));
	if (!is_array($coms))
		echo "com_error##";
	else
	{
		foreach ($coms as $com)
			display_comment($com);
	}
	if (count($coms) < 3)
		echo "com_error##";
	return TRUE;
}

function add_com($pic_id, $user, $content)
{
	if (!isset($content))
		return FALSE;
	if (!userExists($user))
		return FALSE;

	$pict = new Picture (array('id' => $pic_id));
	$com = $pict->addComment($user, $content);
	
	if (!empty($com))
		return $com;
	else
		return FALSE;
}

function display_comment($com)
{
	if (!is_array($com))
	{
		echo "com_error##";
		return FALSE;
	}

	$author = $com['com_author'];
		$href = WEBROOT . "/pages/gallery.php?user=$author";
	$author = "<a class='com_author' href='$href'>$author</a>";
	
	$date = date_ago($com['com_date'], 1); //to modif
		$date = "<span class='com_date'>$date</span>";
	
	$cont = $com['com_cont'];

	echo	"<p class='com_details'> $author $date </p>"; 
	echo 	"<p class='com_content'> $cont </p>";
	echo	"##";
}

?>