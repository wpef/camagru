<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<?php include(ROOT . 'template-parts/stickers_list.php') ?>

<canvas id="cover" style='position:absolute'></canvas>
<video id="video"></video>
<button id="startbutton">Prendre une photo</button>
<canvas id="canvas" style="display: none"></canvas>
<img style="display: none" src="#" id="photo" alt="photo">

<script type="text/javascript">
	var WEBROOT = <?php echo WEBROOT ?>;
</script>
<script type="text/javascript" src="<?php echo WEBROOT . 'script/video.js'?>">
</script>
