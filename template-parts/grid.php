<?php
if ($_GET['type'] == 'user')
{
	$images = $_SESSION['user']->getImages();
	foreach ($images as $i) {
		echo ($i->toImgHTML());
	}
}
?>