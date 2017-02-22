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

	$html =	"<button class='pic_button edit' name='edit' ";
	$html .= "value='$pict->id'> ";
	$html .= "<img class='editimg' src='$edit' alt='edit'/>";
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
	var val = this.value.split(" ");
	var pic_id = val[0];
	var user = val[1];
	
	var str = "pic_id=" + pic_id + "&login=" + user ;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=like", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);
	xhr.addEventListener('readystatechange', function() {
		var notifDiv = document.createElement('div');
		notifDiv.className += 'like_notif';
		notifDiv.innerHTML = xhr.responseText;
		var fig = document.getElementById('pic' + pic_id);
	
		if (this.readyState == 4 && this.status == 200)
		{	
			fig.appendChild(notifDiv);
			var capt = fig.childNodes[1].getElementsByClassName('pic_likes')[0];
			var number = capt.innerHTML;
			if (xhr.responseText == "liked")
				number++;
			else if (xhr.responseText == "unliked")
				number--;
			capt.innerHTML = number;
			setTimeout(function(){
				fig.removeChild(notifDiv);}, 500);
		}
	});
}

function edit_pict()
{
	var pic_id = this.value;

	//display form
	var form = document.getElementById('edit_img' + pic_id);
	form.removeAttribute('style');

	//watch input change
	var input = form.getElementsByTagName('input')['newName'];
	input.addEventListener('change', function() {
		var newName = this.value;
		//send to AJAX
//=====>	sendAjax(?,?,?); //ici
		//
	}, false);
}

</script>