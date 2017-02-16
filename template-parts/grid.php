<?php
if ($_GET['type'] == 'user')
	$images = $_SESSION['user']->getImages();

else if ($_GET['type'] == 'guest')
{
	 	$p_query = "SELECT pic_src, pic_name, pic_owner FROM pictures ORDER BY added_on DESC;";
 		$images_datas = getDatas($p_query, "");
 		$images = array();
 		foreach ($images_datas as $i)
 		{
 			$array = array(
 				'src' => $i['pic_src'],
 				'name' => $i['pic_name'],
 				'owner' => $i['pic_owner']
 				);
 			$images[] = new Picture ($array);
 		}
}

foreach ($images as $i)
{
	echo $i->toImgHTML();
}
?>