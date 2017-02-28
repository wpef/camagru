//////// BUTTONS METHODS
function like_pict()
{
	if (typeof this == 'undefined')
		return;

	this.removeEventListener("click", like_pict, false); 
	
	//set vars
	var pic_id = this.parentNode.parentNode.id.substr(3);
	var user = this.className.split(" ");
		user = user[user.length - 1];
	var dis = this;

	var str = "pic_id=" + pic_id + "&login=" + user ;
	var text = document.querySelector('article#pic' + pic_id + ' .pic_likes');
	var number = text.querySelector('#likes_count').innerHTML;

	//send ajax
	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=like", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);
	
	//callback
	xhr.addEventListener('readystatechange', function() { 
		if (this.readyState == 4 && this.status == 200)
		{
			if (xhr.responseText == "liked")
			{
				number++;
				dis.className = "pic_likes likable liked " + user;
			}
			else if (xhr.responseText == "unliked")
			{
				number--;
				dis.className = "pic_likes likable " + user;
			}

			text.querySelector('#likes_count').innerHTML = number;
			
			pop_notif(xhr.responseText, pic_id, text);
			setTimeout(function(){
				dis.addEventListener("click", like_pict, false);
				}, 500);
		}
	});
}

function edit_pict()
{
	this.removeEventListener("click", edit_pict, false); 

	var id = this.parentNode.id;
	var pic_id = id.substr(3);

	//Hide title
	var title = document.querySelector('article#' + id).querySelector('input.pic_name');
	title.removeAttribute('readonly');

	title.onkeypress = function(e) {
		var key = e.charCode || e.keyCode || 0;
		if (key == 13)
		{
			//esquive submit
			e.preventDefault();

			//setting vars
			var newName = this.value;
			var str = "pic_id=" + pic_id + "&newName=" + newName;

			//send AJAX
			var xhr = new XMLHttpRequest();
			xhr.open('POST', "../mods/edit_pic.php?act=rename", true);	
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send(str);

			//Callback func
			xhr.addEventListener('readystatechange', function() {
				//display newname
				if (this.readyState == 4 && this.status == 200)
				{	
					title.innerHTML = xhr.responseText;
					title.setAttribute('readonly', true);

					//POP NOTIF IMAGE OR GREEN SUBLINE
					pop_notif("EDITED !", pic_id, title);
				}
			});
		}
	};
	this.addEventListener("click", edit_pict, false);
}

function delete_pict()
{
	var id = this.parentNode.parentNode.id;
	var pic_id = id.substr(3);

	if (confirm("Are you sure you want to delete this picture ?") !== true)
		return;

	//send ajax
	var str = "pic_id=" + pic_id;

	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=delete", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);

	//Callback func
	xhr.addEventListener('readystatechange', function() {
		//hide card
		if (this.readyState == 4 && this.status == 200)
		{	
			var picture = document.querySelector('article#pic' + pic_id);
			picture.parentNode.removeChild(picture);
		}	
	});
}

function display_comments()
{
	this.removeEventListener("click", display_comments, false);
	
	var dis = this;
	var pic_id = this.parentNode.parentNode.id.substr(3)
	var user = this.className.split(" ");
		user = user[user.length - 1];
	var article = document.querySelector("#pic" + pic_id);

	//create new elems
	var comments = document.createElement('section');
		comments.className = 'comments';
	
	var load = document.createElement('div');
		load.className = 'load_button';
		load.innerHTML = 'Show more...';
		console.log('1');
		load.addEventListener('click', load_coms(pic_id), false);

	var input = document.createElement('input');
		input.type = 'text';
		input.name = 'comment';
		input.onkeypress = function(e) {
			var key = e.charCode || e.keyCode || 0;
			if (key == 13)
			{
				e.preventDefault(); //esquive submit
				add_com(pic_id, user, this.value);
			}
	}

	//add elements to div
	article.appendChild(comments);
	article.appendChild(load);
	article.appendChild(input);

	//get first 3 comments;
	load_coms(pic_id);

//	dis.addEventListener("click", hide_comments(pic_id), false);
}

///LIB 
function add_com(pic_id, user, content)
{
	var article = document.querySelector('article#pic' + pic_id);

	var str = "pic_id=" + pic_id + "&user=" + user + "&content=" + content;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=add_com", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);

	xhr.addEventListener('readystatechange', function()
	{
		if (this.readyState == 4 && this.status == 200)
			article.querySelector('.comments') += xhr.responseText;
	});
}

function hide_comments(pic_id)
{
	var art = document.querySelector('#pic' + pic_id)
	var sect = art.querySelector('.comments');
	
	sect.innerHTML = '';
}

function load_coms(pic_id)
{
	var article = document.querySelector("#pic" + pic_id);
	var comments = article.querySelector('.comments');
	//NEED TO count already displayed coms;

	//send ajax
	var str = "pic_id=" + pic_id;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=load_coms", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);

	//Callback func
	xhr.addEventListener('readystatechange', function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			console.log('1');
			comments.innerHTML += xhr.responseText;
		}
	});
}

function pop_notif(mess, pic_id, target)
{
	var stock = target.innerHTML;

	target.innerHTML = mess;
	setTimeout(function()
	{
		if (target.innerHTML = stock);
	}, 500);
}