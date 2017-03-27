<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<?php include(ROOT . 'template-parts/stickers_list.php') ?>
<!-- VIDEO -->
<div id="video-div">
	<video id="video"></video>
	<canvas id="canvas" style="display: none"></canvas>
	<canvas id="cover"></canvas>
</div>
<button id="startbutton">Take a picture</button>

<!-- Upload -->
<p id="uploadForm" align="center"><br/>
	<label>
		File: <input name="uploaded_file" type="file" size="30" />
	</label>
</p>

<div id="preview"></div>

<script type="text/javascript" src="<?php echo WEBROOT . 'script/video.js'?>"></script>
<script type="text/javascript" src="<?php echo WEBROOT . 'script/grid_ui.js'?>"></script>