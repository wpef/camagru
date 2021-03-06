(function() {

//setting vars
var		streaming	= false,
		upload		= false,
		body		= document.querySelector('.body'),
		vDiv		= document.querySelector('#video-div'),
		video       = document.querySelector('#video'),
		cover       = document.querySelector('#cover'),
		canvas      = document.querySelector('#canvas'),
		stickers	= document.getElementsByClassName('sticks'),
		sList		= document.querySelector('#stickers-list'),
		startbutton = document.querySelector('#startbutton'),
		stick_on	= false,
		width		= (window.innerWidth * 80) / 100,
		height		= 0,
		upload_form	= document.querySelector('#uploadForm');

if (width > 650)
	width = 650;

upload_form.style.display 	= 'none';
startbutton.style.display   = 'none';
sList.style.display = 'none';

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

function activeVideo () {
	sList.style.display = 'block';
	activeStickers();
	video.addEventListener('canplay', function(ev) {
		if (!streaming) {
				height = video.videoHeight / (video.videoWidth/width);
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
	}, false);

	startbutton.addEventListener('click', function(ev) {
		takepicture(video);
		ev.preventDefault();
	}, false);
}

function displayUploadForm() {
	upload_form.style.display	= '';
	upload_form.querySelector("input").onchange = function (event) {
		//INSERT check file here
		var prev = document.createElement("img");
			prev.src = URL.createObjectURL(event.target.files[0]);
			prev.id = "upload_prev";
			prev.onload = function () {
				upload_form.style.display = 'none';
				sList.style.display = 'block';
				vDiv.replaceChild(prev, video);

				cover.setAttribute('width', document.querySelector('#upload_prev').width);
				cover.setAttribute('height', document.querySelector('#upload_prev').height);
				cover.style.backgroundImage = "url('" + prev.src + "')";
				vDiv.removeChild(prev);

				activeStickers();
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
	
	var data = canvas.toDataURL('image/png');
	var page = WEBROOT;
	var stickName = stick.src.split('/');
		stickName = stickName[stickName.length - 1];

	var str = "pic=" + data + "&stick=" + stickName;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', page + "mods/upload.php" , true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(str);
    xhr.addEventListener('readystatechange', function() { 
		if (this.readyState == 4 && this.status == 200)
		{
			var section = document.querySelector('#preview');
			if (!section)
			{
				section = document.createElement('div');
				section.id = 'preview';
				var main = document.querySelector('#main');
					main.style.width = '70%';
				main.parentNode.insertBefore(section, main.nextSibling);
			}
			var uploaded = document.createElement('div');
				uploaded.className = 'new_picture';
				uploaded.innerHTML = xhr.responseText;
			if (section.firstChild)
				section.insertBefore(uploaded, section.firstChild);
			else
				section.appendChild(uploaded);
			activeButtons();
		}
	});
}

function activeButtons () {
	var del = document.querySelectorAll('.del');
	for (i = 0; i < del.length; i++)
		del[i].addEventListener("click", delete_pict, false);

	var title = document.querySelectorAll('input.pic_name');
	for (i = 0; i < title.length; i++)
	{
		title[i].addEventListener("click", edit_pict, false);
		title[i].onfocus = function () {
			this.className = "pic_name editing";
		}
	}
}

function activeStickers () {
	for (var i = 0; i < stickers.length; i++) {
		stickers[i].addEventListener("click", function() {
			if (streaming) {
				cover.setAttribute('width', video.width);
				cover.setAttribute('height', video.height);
				cover.style.height = video.height + 'px';
				cover.style.width = video.width + 'px';
			}
			if (stick_on && cover)
				cover.getContext('2d').clearRect(0, 0, cover.width, cover.height);
			if (cover)
				cover.getContext('2d').drawImage(this, 0, 0, cover.width, cover.height);
			stick_on = true;
			startbutton.style.display = 'block';
		}, false);
	}
}

})();