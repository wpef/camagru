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
	$pict = new Picture(array('id' => $i['pic_id']));
	echo $pict->toImgHTML();
	if ($pict->owner == $_SESSION['user']->login)
		displayOwnerMenu($pict);
	else
		displayPictureMenu($pict);
}

function displayOwnerMenu($pict)
{
	$edit = WEBROOT . "img/assets/edit.png";
	$del = WEBROOT . "img/assets/del.png";

	$html =	"<button class='pic_button edit' name='edit' ";
	$html .= "value='$pict->id'> ";
	$html .= "<img class='editimg' src='$edit' alt='edit'/>";
	$html .= "</button>";
	$html =	"<button class='pic_button del' name='delete' ";
	$html .= "value='$pict->id'> ";
	$html .= "<img class='delimg' src='$del' alt='delete'/>";
	$html .= "</button>";
	$html .= "<form id='edit_img$pict->id' style='display:none' >Rename picture : <input type='text' name='newName' value='$pict->name'> </form>";

	echo $html;
}

function displayPictureMenu($pict)
{
	$user = $_SESSION['user']->login;
	$like = WEBROOT . "img/assets/like.png";
	
	$html =	"<button class='pic_button like' name='like' ";
	$html .= "value='$pict->id $user'> ";
	$html .= "<img class='likeimg' src='$like' alt='like'/>";
	$html .= "</button>";

	echo $html;
}

?>

<script>

var like = document.getElementsByClassName('like');
var i = 0;
while (i < like.length)
	like[i++].addEventListener("click", like_pict, false); 

var edit = document.getElementsByClassName('edit');
var i = 0;
while (i < edit.length)
	edit[i++].addEventListener("click", edit_pict, false); 


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
			var capt = document.querySelector('#pic' + pic_id).querySelector('figcaption').querySelector('.pic_likes');
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
	var pic_id = this.value;

	//display form
	var form = document.getElementById('edit_img' + pic_id);
	form.removeAttribute('style');

	//send on RET
	var input = form.getElementsByTagName('input')['newName'];
	input.onkeypress = function(e) {
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
				//hide field
				form.style.display = 'none';

				//display newname
				if (this.readyState == 4 && this.status == 200)
				{	
					var picture = document.getElementById('pic' + pic_id);
					picture = picture.querySelector('figcaption');
					var pic_name = picture.querySelector('.pic_name');
					pic_name.innerHTML = xhr.responseText;
					pop_notif("edited", pic_id);
				}
	});
		}
	};
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
		fig.removeChild(notifDiv);}, 500);
}

function sendAjax(str, file, callback())
{
	var xhr = new XMLHttpRequest();
	xhr.open('POST', file, true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);

	xhr.addEventListener('readystatechange', callback());
}


</script>