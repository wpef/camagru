<?php
if (!defined('access')) {
	$_SESSION['alert'] = 'Direct access not permitted';
	header('Location: ../');
}

//SET IMAGES LIST
if (empty($_GET) OR empty($_SESSION['user']))
	$_GET['type'] = 'guest';

$login = $_SESSION['user']->login;

$p_query = "SELECT like_pic FROM likes WHERE like_author = '$login';";
$liked_pic = getDatas($p_query, "");

if ($_GET['type'] == 'user')
	$images_id = $_SESSION['user']->getImages();
else if ($_GET['type'] == 'guest')
{
	 	$p_query = "SELECT pic_id FROM pictures ORDER BY added_on DESC;";
 		$images_id = getDatas($p_query, "");
}
else if ($_GET['type'] == 'liked')
{
	foreach ($liked_pic as $pic)
		$images_id[]['pic_id'] = $pic['like_pic'];
}
else if (isset($_GET['user']))
{
	$user = new User (array('login' => $_GET['user']));
	$images_id = $user->getImages();
}

//CHECK if pictures;
if (!$_SESSION['log'])
{
	echo "<p id='alert' onclick='hide_mess(this)'>You are seeing this page as guest, you must be logged in to interact with users pictures.</p>";
}


//display
echo "<div class='grid-wrapper'>";

if (empty($images_id))
		echo "<p class='alert'>No images found.</p>";
else
	displayPictureArticle($images_id, $_SESSION['log'], $liked_pic);
echo "</div>";

function displayPictureArticle($images_id, $buttons, $liked_pic)
{
	foreach ($images_id as $i)
	{
		if (!is_array($liked_pic))
			$liked_pic[0]['pic_id'] = $liked_pic;

		$user = $_SESSION['user'];
		$pict = new Picture(array('id' => $i['pic_id']));
		echo $pict->toArticleHTML($user, FALSE);
		foreach ($liked_pic as $i)
		{
			if ($i['like_pic'] == $pict->id)
			{
				$liked = 1;
				break;
			}
			else
				$liked = 0;
		}
	 	if ($buttons)
				displayPictureButtons($pict, $user, $liked);
		echo "</article>";
	}
}

function displayPictureButtons($pict, $user, $liked)
{
 	echo "<section class='user_actions'>";
 	//likes
	 	if ($liked)
			echo "<span class='pic_likes liked $user->login'>";
		else
			echo "<span class='pic_likes $user->login'>";
		echo "<span id='likes_count'>$pict->likes</span> like(s)</span>";
	//coments
		echo "<span class='pic_com $user->login'>";
		echo "Show comments</span>";
	echo "</section>";
}

?>

<script type="text/javascript" src="<?php echo WEBROOT . 'script/grid_ui.js' ?>"></script>

<script>
//setting nice height for articles
var img = document.querySelectorAll("section.image img");
var height = 0;

for (i = 0; i < img.length; i++)
{
	if (img[i].height > height)
		height = img[i].height;
}

for (i = 0; i < img.length; i++)
{
    if (img[i].height < height)
    	img[i].style.padding = ((height - img[i].height)/2) + "px 0px";
}

//assigning functions to buttons
var like = document.getElementsByClassName('pic_likes');
var i = 0;
while (i < like.length)
	like[i++].addEventListener("click", like_pict, false); 

var del = document.getElementsByClassName('del');
var i = 0;
while (i < del.length)
	del[i++].addEventListener("click", delete_pict, false); 

var com = document.getElementsByClassName('pic_com');
var i = 0;
while (i < com.length)
	com[i++].addEventListener("click", init_comments, false);


var title = document.querySelectorAll('input.pic_name');
var i = 0;
while (i < title.length)
{
	title[i].addEventListener("click", edit_pict, false);
	title[i].onfocus = function () {
		this.className = "pic_name editing";
	}
	i++;
}

</script>