<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>

<ul id="stickers-list">
<?php
$dir = ROOT . 'stickers/';
$sticks = glob($dir . "*.png");
foreach ($sticks as $s) {
	$s = WEBROOT . "stickers/" . basename($s);
	echo "<li>"
	. "<img onclick=\"select_stick(this)\" class=\"sticks\" src=\"$s\"/>"
	. "</li>";
}
?>
</ul>