<?php 

/////// INCLUDES
include_once('../config/inc.php');

///////// ERROR HANDLING
if (empty($_POST))
{
	echo "AN ERROR OCCURED";
	return FALSE;
}

///////// STD VARS
$pic_id = $_POST['pic_id'];
$com_error = "<p class='com_error'>AN ERROR OCCURED</p>";

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
		$offset = $_POST['offset']; //vars checked
		if (load_coms($pic_id, $offset) !== TRUE)
			return FALSE;
		break;

	case 'add_com' :
		$user = $_SESSION['user']->login;
		$content = $_POST['content'];
		$com = add_com($pic_id, $user, $content);
		if ( $com == FALSE)
		{
			echo $com_error;
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

function load_coms($pic_id, $offset)
{
	$pict = new Picture(array('id' => $pic_id));
	$coms = $pict->getComments(3, intval($offset)); //comms = bool(FALSE);
	if (!is_array($coms))
		echo "<p class='com_error'>No more comments to display</p>";
	else
	{
		foreach ($coms as $com)
			display_comment($com);
	}
	if (count($coms) < 3)
		echo "<p class='com_error'>No more comments to display</p>";
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
		echo $com_error;
		return FALSE;
	}

	$author = $com['com_author'];
		$href = WEBROOT . '/pages/grid.php?user=$author';
		$author = "<a class='com_author' href='$href'>$author</a>";
	
	$date = $com['com_date'];
		$date = "<span class='com_date'>$date</span>";
	
	$cont = $com['com_cont'];

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