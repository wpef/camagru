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

function init_comments()
{
	this.removeEventListener("click", init_comments, false);
	this.onclick = function () { hide_comments(pic_id); };

	var pic_id = this.parentNode.parentNode.id.substr(3)
	display_comMenu(pic_id);
}

function display_comMenu (pic_id)
{
	console.log('displayed ' + pic_id);
	var article = document.querySelector("#pic" + pic_id);
	
	//create new elems
	var comments = document.createElement('section');
		comments.className = 'comments';

	var load = document.createElement('div');
		load.className = 'load_button';
		load.innerHTML = 'Show more...';
		load.onclick = function () { load_coms(pic_id); };
		comments.appendChild(load);

	var input = document.createElement('input');
		input.type = 'text';
		input.name = 'comment';
		input.onkeypress = function(e) {
			var key = e.charCode || e.keyCode || 0;
			if (key == 13)
			{
				e.preventDefault(); //esquive submit
				add_com(pic_id, this.value);
				this.value = "";
			}
		}
		comments.appendChild(input);


	//add elements to div
	article.appendChild(comments);

	//get first 3 comments;
	load_coms(pic_id);
}

///LIB 
function add_com(pic_id, content)
{
	var str = "pic_id=" + pic_id + "&content=" + content;
	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=add_com", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);

	xhr.addEventListener('readystatechange', function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			var section = document.querySelector("#pic" + pic_id + " .comments")
			var wrapper = section.querySelector(".comment_wrapper")
			if (!wrapper)
			{
				var wrapper = document.createElement('div');
					wrapper.className = 'comment_wrapper';
			}
			appendComments(section, wrapper, xhr, true);
		}
	});
}

function hide_comments(pic_id)
{
//	console.log('hidden ' + pic_id);
	var art = document.querySelector('#pic' + pic_id)
	var sect = art.querySelector('.comments');
	
	sect.parentNode.removeChild(sect);

	art.querySelector('.pic_com').onclick = function () { display_comMenu(pic_id) };
}

function load_coms(pic_id)
{
//	console.log('load ' + pic_id);
	var article = document.querySelector("#pic" + pic_id);
	var section = article.querySelector('.comments');
	var count = section.querySelectorAll('.com').length;
	console.log(count + " comments already displayed");

	//set hide (change innerHTML) 
	article.querySelector('.pic_com').onclick = function () { hide_comments(pic_id) };
	
	//send ajax
	var str = "pic_id=" + pic_id + "&offset=" + count; //checked
	var xhr = new XMLHttpRequest();
	xhr.open('POST', "../mods/edit_pic.php?act=load_coms", true);	
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(str);

	xhr.addEventListener('readystatechange', function() {
		if (this.readyState == 4 && this.status == 200)
		{
			if (count == 0) {
				var wrapper = document.createElement('div');
					wrapper.className = "comment_wrapper";
				appendComments(section, wrapper, xhr);
				section.insertBefore(wrapper, section.firstChild);
			}
			else 
			{
				var wrapper = document.querySelector('#pic' + pic_id + " .comment_wrapper");
				appendComments(section, wrapper, xhr);
			}
		}
	});
}

function appendComments(section, wrapper, xhr, appendFirst)
{
	var coms = xhr.responseText.split("##");
	for (var i = 0; i < coms.length - 1 ; i++)
	{
		if (coms[i] == "") { continue; }
		var com = document.createElement('div');
			com.className = 'com';
			com.innerHTML = coms[i];
		if (com.innerHTML.indexOf("com_error") > -1)
		{
			com.className = 'com_error';
			var finished = 1;
		}
		if (appendFirst)
			wrapper.insertBefore(com, wrapper.firstChild);
		else
			wrapper.appendChild(com);
	}

	if (finished)
		last_comment(section, wrapper);		
}

function last_comment(section, wrapper)
{
	var count = wrapper.querySelectorAll('.com').length;

	var load = section.querySelector('.load_button');
	if (load)
		load.parentNode.removeChild(load);

	var mess = wrapper.querySelector('div.com_error');
	if (count == 0)
		mess.innerHTML = "No comments.";
	else
		mess.innerHTML = "No more comments."; 
	
	wrapper.appendChild(mess);
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