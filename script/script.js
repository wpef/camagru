var hide_mess = function (mess) {
	mess.setAttribute('style', 'display:none');
};

var select_stick = function(stick) {
	var old = document.getElementById('selected');
	if (old)
		old.removeAttribute('id');
	stick.setAttribute('id', 'selected');
};

var displayPictureMenu = function(pic_id) {
	console.log(pic_id);
};
