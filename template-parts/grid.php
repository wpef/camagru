<?php
if ($_GET['type'] == 'user')
	$images = $_SESSION['user']->getImages();

else if ($_GET['type'] == 'guest')
{
	 	$p_query = "SELECT pic_src, pic_name, pic_owner, added_on FROM pictures ORDER BY added_on DESC;";
 		$images_datas = getDatas($p_query, "");
 		$images = getImagesTab($images_datas);
}

foreach ($images as $i)
	echo $i->toImgHTML();
?>