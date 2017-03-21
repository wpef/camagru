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
		height		= 0,
		upload_form	= document.querySelector('#uploadForm');

if (width > 650)
	width = 650;

upload_form.style.display 	= 'none';

for (var i = 0; i < stickers.length; i++) {
	stickers[i].addEventListener("click", function() {
		if (stick_on)
			cover.getContext('2d').clearRect(0,0,width,height);
		cover.getContext('2d').drawImage(this, 0, 0, width, height);
		stick_on = true; 
	}, false);
};


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
		displayUploadForm();
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

startbutton.addEventListener('click', function(ev){
		takepicture();
		ev.preventDefault();
	}, false);

function displayUploadForm() {
	upload_form.style.display	= 'initial';
	startbutton.style.display 	= 'none';
	upload_form.querySelector("input").onchange = displayPrev;
}

function displayPrev(event)
{
	console.log(event);
		var prev = document.createElement("img");
			prev.src = URL.createObjectURL(event.target.files[0]);
			prev.id = "upload_prev";
		video.parentNode.replaceChild(prev, video);
		event.target.parentNode.style.display = "none";
		activePrev();
}

function takepicture() {
	var stick = document.querySelector('#selected');
	canvas.width = width;
	canvas.height = height;
	canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	if (stick)
		canvas.getContext('2d').drawImage(stick, 0, 0, width, height);
	var data = canvas.toDataURL('image/png');
	//	AJAX TRY
	var page = WEBROOT;
	var str = "pic=" + data;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', page + "mods/upload.php" , true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(str);
    xhr.addEventListener('readystatechange', function() { 
		if (this.readyState == 4 && this.status == 200)
		{
			photo.setAttribute('src', data);
			photo.setAttribute('style', ' ');
		}
	});
}

function activePrev() {
	console.log("YOYOYOYOYOOYYOYO");
	//(MAYBE resize) 
	//active stickers
	//reactive start button changing value
	//push to db if start button clicked
}

})();