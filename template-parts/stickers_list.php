<style>
#stickers-list li {
	display: inline-block;
}

.sticks {
	max-width : 110px;
}

#selected {
	border : 1px solid black;
}

</style>

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