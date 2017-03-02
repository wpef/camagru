<?php

if (empty($_GET))
	$_GET['type'] = 'guest';

if ($_GET['type'] == 'user')
	$images_id = $_SESSION['user']->getImages();

else if ($_GET['type'] == 'guest')
{
	 	$p_query = "SELECT pic_id FROM pictures ORDER BY added_on DESC;";
 		$images_id = getDatas($p_query, "");
}

echo "<div class='grid-wrapper'>";
foreach ($images_id as $i)
{
	$user = $_SESSION['user'];
	$pict = new Picture(array('id' => $i['pic_id']));

 	echo "<article class='picture' id='pic$pict->id'>";
 		displayPictureHeader($pict, $user);
		echo $pict->toImgHTML();
		displayPictureButtons($pict, $user);
	echo "</article>";
//	displayPictureMenu($pict, $pict->owner == $user->login);
//	if ($pict->owner == $user->login or $user->isadmin == 1)
//		displayOwnerMenu($pict);
}
echo "</div>";

function displayPictureHeader($pict, $user)
{
	$edit = WEBROOT . "img/assets/edit.png";
	$del = WEBROOT . "img/assets/del.png";

	$s = 	"<section class='details'>";
	$s .= 	"by&nbsp;<a class='pic_owner' href='WEBROOT . '/pages/grid.php?user=$pict->owner''>$pict->owner</a>";
	$s .= 	"&nbsp;on&nbsp;<span class='pic_date'>$pict->date</span> "; 
	$s .= 	"</section>";

	$del_icon = "<i class=\"del fa fa-times\" aria-hidden=\"true\"></i>";

	echo "<header class='pic_header'>";
	if ($user->isadmin OR $pict->owner == $user->login)
	{
		echo $del_icon;
		if ($pict->owner == $user->login)
		{
			echo "<span class='edit'>";
			echo "<input type='text name='newName' class='pic_name' value='$pict->name' readonly='true'>";
			echo "</span>";
		}
		else
			echo "<h2 class='pic_name'>$pict->name</h2>";
	}
	else
		echo "<h2 class='pic_name'>$pict->name</h2>";
	
	echo $s;
	echo "</header>";
}

function displayPictureButtons($pict, $user)
{
 	echo "<section class='user_actions'>";
 	//likes
		echo "<span class='pic_likes $user->login'>";
		echo "<span id='likes_count'>$pict->likes</span> like(s)</span>";
	//coments
		echo "<span class='pic_com $user->login'>";
		echo "show comments </span>";
	echo "</section>";
}

?>

<script type="text/javascript" src="<?php echo WEBROOT . 'script/grid_ui.js' ?>"></script>

<script>
//assigning functions to buttons
var like = document.getElementsByClassName('pic_likes');
var i = 0;
while (i < like.length)
	like[i++].addEventListener("click", like_pict, false); 

var edit = document.getElementsByClassName('pic_header');
var i = 0;
while (i < edit.length)
	edit[i++].addEventListener("click", edit_pict, false); 

var del = document.getElementsByClassName('del');
var i = 0;
while (i < del.length)
	del[i++].addEventListener("click", delete_pict, false); 

var com = document.getElementsByClassName('pic_com');
var i = 0;
while (i < com.length)
	com[i++].addEventListener("click", init_comments, false);

</script>