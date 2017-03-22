(function() {

//setting vars
var		streaming	= false,
		upload		= false,
		video       = document.querySelector('#video'),
		cover       = document.querySelector('#cover'),
		canvas      = document.querySelector('#canvas'),
		stickers	= document.getElementsByClassName('sticks'),
		startbutton = document.querySelector('#startbutton'),
		stick_on	= false,
		width		= (window.innerWidth * 80) / 100,
		height		= 0,
		upload_form	= document.querySelector('#uploadForm');

if (width > 650)
	width = 650;

upload_form.style.display 	= 'none';
startbutton.style.display   = 'none';

for (var i = 0; i < stickers.length; i++) {
	stickers[i].addEventListener("click", function() {
		if (stick_on)
			cover.getContext('2d').clearRect(0, 0, cover.width, cover.height);
		cover.getContext('2d').drawImage(this, 0, 0, cover.width, cover.height);
		stick_on = true;
		startbutton.style.display   = 'initial';
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
		activeVideo();
	},
	function(err) {
		displayUploadForm();
	}
);

function activeVideo () { //to test
	video.addEventListener('canplay', function(ev) {
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

	startbutton.addEventListener('click', function(ev) {
		takepicture(video);
		ev.preventDefault();
	}, false);
}

function displayUploadForm() {
	upload_form.style.display	= 'initial';
	upload_form.querySelector("input").onchange = function (event) {
		//check file
		var prev = document.createElement("img");
			prev.src = URL.createObjectURL(event.target.files[0]);
			prev.id = "upload_prev";
		video.parentNode.replaceChild(prev, video);
		event.target.parentNode.style.display = "none";
		prev.onload = function () {
			cover.setAttribute('width', prev.width);
			cover.setAttribute('height', prev.height);
			startbutton.addEventListener('click', function(ev) {
				takepicture(prev);
				ev.preventDefault();
			}, false);
		};
	};
}

function takepicture(img) {
	var stick = document.querySelector('#selected');
	canvas.width = cover.width;
	canvas.height = cover.height;
	
	canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);
	canvas.getContext('2d').drawImage(stick, 0, 0, canvas.width, canvas.height);
	
	var data = canvas.toDataURL('image/png');
	var page = WEBROOT;
	var str = "pic=" + data;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', page + "mods/upload.php" , true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(str);
    xhr.addEventListener('readystatechange', function() { 
		if (this.readyState == 4 && this.status == 200)
		{
			var uploaded = document.createElement('div');
				uploaded.className = 'new_picture';
				uploaded.innerHTML = xhr.responseText;
			document.querySelector('.body').replaceChild(uploaded, startbutton);
		}
	});
}

})();