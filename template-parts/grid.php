<?php
if ($_GET['type'] == 'user')
	$images_id = $_SESSION['user']->getImages();

else if ($_GET['type'] == 'guest')
{
	 	$p_query = "SELECT pic_id FROM pictures ORDER BY added_on DESC;";
 		$images_id = getDatas($p_query, "");
}

foreach ($images_id as $i)
{
	$user = $_SESSION['user'];
	$pict = new Picture(array('id' => $i['pic_id']));

 	echo "<article class='picture' id='pic$pict->id'>";
 		displayPictureHeader($pict, $user);
		echo $pict->toImgHTML();
	//	displayPictureDetails($pict, $user);
		displayPictureButtons($pict, $user);
	echo "</article>";
//	displayPictureMenu($pict, $pict->owner == $user->login);
//	if ($pict->owner == $user->login or $user->isadmin == 1)
//		displayOwnerMenu($pict);
}

function displayPictureHeader($pict, $user)
{
	$edit = WEBROOT . "img/assets/edit.png";
	$del = WEBROOT . "img/assets/del.png";

	$s = 	"<section class='details'>";
	$s .= 	"by&nbsp;<a class='pic_owner' href='$page$pict->owner'>$pict->owner</a>";
	$s .= 	"&nbsp;on&nbsp;<span class='pic_date'>$pict->date</span> "; 
	$s .= 	"</section>";

	echo "<header class='pic_header'>";
	if ($pict->owner == $user->login)
	{
		$edit_icon = "<i class=\"pic_button edit fa fa-pencil-square-o fa-2x\"></i>";
		echo "<i class=\"pic_button del fa fa-times\" aria-hidden=\"true\"></i>";
		echo "<div class='edit'> $edit_icon";
		echo "<input type='text 'class='pic_name' name='newName' value='$pict->name' readonly='true'>";
		echo "</div>";
		echo $s;
		echo "</header>";
	}
	else
	{
		echo "<h2 class='pic_name'>$pict->name</h2>";
		echo $s;
		echo "</header>";
	}
}

function displayPictureButtons($pict, $user)
{
	$like = WEBROOT . "img/assets/like.png";
 	$com = WEBROOT . "img/assets/com.png";
	
	if ($pict->owner !== $user->login)
	{
		echo "<button class='pic_button like' name='like' ";
 		echo "value='$pict->id $user->login'> ";
 		echo "<img class='likeimg' src='$like' alt='like'/>";
		echo "</button>";
	}
	else
		echo "<img class='likeimg' src='$like' alt='like'/>";
	echo "<span class='pic_likes'>$pict->likes likes</span>";
	echo "<button class='pic_button com' name='com' ";
	echo "value='$pict->id $user->login'> ";
	echo "<img class='comimg' src='$com' alt='Comments'/>";
	echo "</button>";
}

?>

<script>


//assigning functions to buttons
var like = document.getElementsByClassName('like');
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

var com = document.getElementsByClassName('com');
var i = 0;
while (i < com.length)
	com[i++].addEventListener("click", display_comments, false);

//////// BUTTONS METHODS
function like_pict()
{
	//set vars
	var val = this.value.split(" ");
	var pic_id = val[0];
	var user = val[1];
	var str = "pic_id=" + pic_id + "&login=" + user ;

	//send ajax
	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=like", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);

	//display live
	xhr.addEventListener('readystatechange', function() {
		//Callback 
		if (this.readyState == 4 && this.status == 200)
		{	
			pop_notif(xhr.responseText, pic_id);
			var capt = document.querySelector('figure#pic' + pic_id).querySelector('figcaption').querySelector('.pic_likes');
			var number = capt.innerHTML;
			if (xhr.responseText == "liked")
				number++;
			else if (xhr.responseText == "unliked")
				number--;
			capt.innerHTML = number;
		}
	});
}

function edit_pict()
{
	this.removeEventListener("click", edit_pict, false); 

	var id = this.parentNode.id;
	var pic_id = id.substr(3);

	//Hide title
	var title = document.querySelector('article#' + id).querySelector('input.pic_name');
	title.removeAttribute('readonly');
	title.className += ' editing';

	title.onkeypress = function(e) {
		var key = e.charCode || e.keyCode || 0;
		if (key == 13)
		{
			//esquive submit
			e.preventDefault();

			//setting vars
			var newName = this.value;
			var str = "pic_id=" + pic_id + "&newName=" + newName;

			//send AJAX
			var xhr = new XMLHttpRequest();
			xhr.open('POST', "../mods/edit_pic.php?act=rename", true);	
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(str);

			//Callback func
			xhr.addEventListener('readystatechange', function() {
				//display newname
				if (this.readyState == 4 && this.status == 200)
				{	
					title.innerHTML = xhr.responseText;
					title.setAttribute('readonly', true);
					title.className = 'pic_name';
					pop_notif("edited", pic_id);
					this.addEventListener("click", edit_pict, false);
				}
			});
		}
	};
}

function delete_pict()
{
	var pic_id = this.value;

	if (confirm("Are you sure you want to delete this picture ?") !== true)
		return;

	//send ajax
	var str = "pic_id=" + pic_id;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=delete", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);

	//Callback func
	xhr.addEventListener('readystatechange', function() {
		//display newname
		if (this.readyState == 4 && this.status == 200)
		{	
			var picture = document.querySelector('div#pic' + pic_id);
			picture.parentNode.removeChild(picture);
		}	
	});
}

function display_comments()
{
	var pic_id = this.value;
	//add static to hide if not hidden
	
	//send ajax
	var str = "pic_id=" + pic_id;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=dispCom", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);

	//Callback func
	xhr.addEventListener('readystatechange', function() {
		//display newname
		if (this.readyState == 4 && this.status == 200)
		{	
			//callback
			var debug = document.querySelector("#debug");
			debug.innerHTML = xhr.responseText;
			//Create div with response
			//create input for new com
				//on enter send new com
		}	
	});
}

///LIB 
function pop_notif(mess, pic_id)
{
	var fig = document.getElementById('pic' + pic_id);

	var notifDiv = fig.querySelector('.notif') || document.createElement('div');
		notifDiv.className += 'notif';
		notifDiv.innerHTML = mess;
	
	fig.appendChild(notifDiv);
	setTimeout(function(){
		if (fig.removeChild(notifDiv));
	}, 500);
}

</script>