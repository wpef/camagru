<?php
if ($_GET['type'] == 'user')
{
	$_SESSION['user']->getImages(FALSE);
}
?>