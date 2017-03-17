<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<?php include(ROOT . 'template-parts/stickers_list.php') ?>

<!-- VIDEO -->
<canvas id="cover" style='position:absolute'></canvas>
<video id="video"></video>
<button id="startbutton">Prendre une photo</button>
<canvas id="canvas" style="display: none"></canvas>
<img style="display: none" src="#" id="photo" alt="photo">


<!-- Upload -->
<form id="uploadfile" action="upload.php" method="post" enctype="multipart/form-data" target="uploadTarget" onsubmit="startUpload();">
    <p id="uploadForm" align="center"><br/>
        <label>
            File: <input name="myfile" type="file" size="30" />
        </label>
        <label>
            <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
        </label>
    </p>
    <p id="uploadProcess">Uploading...<br/><img src="<?php echo WEBROOT . "img/assets/loader.gif"?>"/><br/></p>
    <iframe id="uploadTarget" name="uploadTarget" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
</form>
<!-- Uploaded file preview -->
<div id="uploadedPrev">
    <embed id="UploadedFile" src="" width="390px" height="160px">
</div>


<script type="text/javascript">
	var WEBROOT = <?php echo WEBROOT ?>;

	function startUpload() {
    	document.querySelector('#uploadProcess').style.display = 'initial';
    	document.querySelector('#uploadForm').style.display = 'none';
    	return true;
	}

	function stopUpload(success,uploadedFile) {
	    var result = '';
	    if (success == 1) 
	    {
	        result = '<span class="sucess-msg">The file was uploaded successfully!<\/span><br/><br/>';
	        //Uploaded file preview
	        var prev = document.querySelector("#UploadedFile");
	        var clone = prev.cloneNode(true);
	        clone.setAttribute('src',uploadedFile);
	        prev.parentNode.replaceChild(clone,prev);
	    }
	    else
	       result = '<span class="error-msg">There was an error during file upload!<\/span><br/><br/>';
		
		document.getElementById('uploadProcess').style.display = 'none';
		document.getElementById('uploadForm').innerHTML = result;
		document.getElementById('uploadForm').style.display = 'initial';
		return true;   
}
</script>
<script type="text/javascript" src="<?php echo WEBROOT . 'script/video.js'?>">
</script>
