(function() {

//setting vars
var		streaming = false,
		video       = document.querySelector('#video'),
		cover       = document.querySelector('#cover'),
		canvas      = document.querySelector('#canvas'),
		photo       = document.querySelector('#photo'),
		stickers	= document.getElementsByClassName('sticks'),
		startbutton = document.querySelector('#startbutton'),
		stick_on	= false,
		width		= (window.innerWidth * 80) / 100,
		height		= 0;

if (width > 650)
	width = 650;

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
		for (var i = 0; i < stickers.length; i++) {
			stickers[i].addEventListener("click", function() {
				if (stick_on)
					cover.getContext('2d').clearRect(0,0,width,height);
				cover.getContext('2d').drawImage(this, 0, 0, width, height);
				stick_on = true;
			}, false);
		};
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
		cover.setAttribute('width', width);
		cover.setAttribute('height', height);
		streaming = true;
	}
	}, false);

function takepicture() {
	var stick = document.querySelector('#selected');
	canvas.width = width;
	canvas.height = height;
	canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	if (stick)
		canvas.getContext('2d').drawImage(stick, 0, 0, width, height);
	var data = canvas.toDataURL('image/png');
	photo.setAttribute('src', data);
	photo.setAttribute('style', ' ');

//	AJAX TRY
	var page = WEBROOT;
	console.log(WEBROOT);

	var formData = new FormData();
	formData.append('pic', data);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', page , true);
	//xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(formData);
}

startbutton.addEventListener(
	'click',
	function(ev){
		takepicture();
		ev.preventDefault();
	}, false);

})();