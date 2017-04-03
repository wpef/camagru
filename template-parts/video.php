<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<h1>Take a picture !</h1>
<div id="main">
	<?php include(ROOT . 'template-parts/stickers_list.php') ?>
	<!-- Upload -->
	<div class='form' id="uploadForm" align="center">
		<h2>Upload a picture</h2>
		<input name="uploaded_file" type="file" size="30" />
	</div>
	<!-- VIDEO -->
	<div id="video-div">
		<video id="video"></video>
		<canvas id="canvas" style="display: none"></canvas>
		<canvas id="cover"></canvas>
	</div>
	<button id="startbutton">Take a picture</button>
</div>

<script type="text/javascript" src="<?php echo WEBROOT . 'script/video.js'?>"></script>
<script type="text/javascript" src="<?php echo WEBROOT . 'script/grid_ui.js'?>"></script>