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
switch ($_GET['act']) { 
	case 'like' :
		$user = $_SESSION['user']->login;
		if (like_pic($pic_id, $user) !== TRUE)
			return FALSE;
		break;

	case 'rename' :
		$newName = $_POST['newName'];
		if (rename_pic($pic_id, $newName) !== TRUE)
			return FALSE;
		echo $newName;
		break;

	case 'delete' :
		if (delete_pic($pic_id) !== TRUE)
			return FALSE;
		echo "deleted";
		break;

	case 'load_coms' :
		if (load_coms($pic_id) !== TRUE)
			return FALSE;
		break;

	case 'add_com' :
		$user = $_SESSION['user']->login;
		$content = $_POST['content'];
		if ($com = add_com($pic_id, $user, $content) !== FALSE)
			display_comment($com);
		else
		{
			echo "AN ERROR OCCURED";
			return FALSE;
		}
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

function rename_pic($pic_id, $newName)
{
	$pict = new Picture(array('id' => $pic_id));
	//proceed newName
	if ($pict->modify(array('pic_name' => $newName)))
		return TRUE;
	return FALSE;
}

function delete_pic($pic_id)
{
	sendQuery("DELETE FROM pictures WHERE pic_id = $pic_id;");
	sendQuery("DELETE FROM likes WHERE like_pic = $pic_id;");
	return TRUE;
}

function load_coms($pic_id)
{
	$pict = new Picture(array('id' => $pic_id));
	$coms = $pict->getComments(3, '');
	if (empty($coms))
		echo "<p class='com_error'>No comments to display</p>";
	else
	{
		foreach ($coms as $com)
			display_comment($com);
	}
	return TRUE;
}

function add_com($pic_id, $user, $content)
{
	if (empty($content))
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
		echo "<p class='com_error'>An error occured</p>";
		return FALSE;
	}

	$author = $com['com_author'];
		$href = WEBROOT . '/pages/grid.php?user=$author';
		$author = "<a class='com_author' href='$href'>$author</a>";
	$date = $com['com_date'];
		$date = "<span class='com_date'>$date</span>";
	$cont = $com['content'];

	echo "<div class='com'>";
	echo 	"<p class='com_content'>";
	echo	$cont;
	echo	"</p>";
	echo	"<p class='com_details'>";
	echo 		"by&nbsp $author";
	echo 	"&nbsp;on&nbsp; $date</p>"; 
	echo "</div>";
}

?>