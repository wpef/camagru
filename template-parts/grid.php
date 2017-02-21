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
//	if ($pict->owner === $_SESSION['user']->login)
//		echo $pict->display('userMenu');
//	else
	$user = $_SESSION['user']->login;
	$like = WEBROOT . "img/assets/like.png";
	echo
	"<button class=\"likebutton\"
		name=\"like\"
		value=\"$pict->id $user\">
			<img class=\"likeimg\" src=\"$like\" alt=\"like\"/>
	</button>";
}
?>

<script>

var but = document.getElementsByClassName('likebutton');
var i = 0;
while (i < but.length)
	but[i++].addEventListener("click", like_pict, false); 


function like_pict()
{
	var val = this.value.split(" ");
	var pic_id = val[0];
	var user = val[1];
	
	var str = "pic_id=" + pic_id + "&login=" + user ;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);
	xhr.addEventListener('readystatechange', function() {
		//debug
		document.getElementById('debug').innerHTML=xhr.responseText;
	});
}
</script>