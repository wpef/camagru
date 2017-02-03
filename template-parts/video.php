<video id="video"></video>
<button id="startbutton">Prendre une photo</button>
<ul id="stickers">
	<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . 'template-parts/sitckers_list.php') ?>
	<!--  Foreach ($query_res as filtre) { echo <li onclick='select_sticker()'> . IMAGE . </li>} -->
	<!-- function select_sticker() {onclick setAttribute(id, 'select')} -->
</ul>
<canvas id="canvas" style="display: none"></canvas>
<img style="display: none" src="http://placekitten.com/g/320/261" id="photo" alt="photo">

<script>
(function() {

//setting vars
var		streaming = false,
		video        = document.querySelector('#video'),
		cover        = document.querySelector('#cover'),
		canvas       = document.querySelector('#canvas'),
		photo        = document.querySelector('#photo'),
		startbutton  = document.querySelector('#startbutton'),
		width = 520,
		height = 0;

navigator.getMedia = (	navigator.getUserMedia ||
						navigator.webkitGetUserMedia ||
						navigator.mozGetUserMedia ||
						navigator.msGetUserMedia);
navigator.getMedia(
	{
		video: true,
		audio: false
	},
	function(stream) {
		var vendorURL = window.URL || window.webkitURL;
		video.src = vendorURL.createObjectURL(stream);
		video.play();
	},
	function(err) {
		console.log("An error occured! " + err);
		//ici upload manuel;
	}
);

video.addEventListener('canplay', function(ev){
	if (!streaming) {
		height = video.videoHeight / (video.videoWidth/width);
		video.setAttribute('width', width);
		video.setAttribute('height', height);
		canvas.setAttribute('width', width);
		canvas.setAttribute('height', height);
		streaming = true;
	}
	}, false);

function takepicture() {
	canvas.width = width;
	canvas.height = height;
	canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	//RE-DRAW avec le png
	// aide (https://openclassrooms.com/forum/sujet/enregistrer-sur-dossier-du-serveur-un-canvas)  ==> toDataURL() renvoie une image encodée en base64), en ajax ou via un formulaire.
	var data = canvas.toDataURL('image/png');
	photo.setAttribute('src', data);
	photo.setAttribute('style', ' ');
}

startbutton.addEventListener(
	'click',
	function(ev){
		takepicture();
		ev.preventDefault();
	}, false);

})();

</script>