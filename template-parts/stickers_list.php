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
$dir = $_SERVER['DOCUMENT_ROOT'] . "/camagru/stickers/";
$sticks = glob($dir . "*.png");
foreach ($sticks as $s) {
	$s = "/camagru/stickers/" . basename($s);
	echo "<li>"
	. "<img onclick=\"select_stick(this)\" class=\"sticks\" src=\"$s\"/>"
	. "</li>";
}
?>
</ul>