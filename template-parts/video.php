<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<?php include(ROOT . 'template-parts/stickers_list.php') ?>
<!-- VIDEO -->
<canvas id="cover" style='position:absolute'></canvas>
<video id="video"></video>
<button id="startbutton">Prendre une photo</button>
<canvas id="canvas" style="display: none"></canvas>
<div id="preview"></div>


<!-- Upload -->
<p id="uploadForm" align="center"><br/>
	<label>
		File: <input name="uploaded_file" type="file" size="30" />
	</label>
</p>
<script type="text/javascript" src="<?php echo WEBROOT . 'script/video.js'?>"></script>
<script type="text/javascript" src="<?php echo WEBROOT . 'script/grid_ui.js'?>"></script>