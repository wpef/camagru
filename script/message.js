var mess = document.querySelector('#message');
mess.addEventListener("click", hide);

function hide() {
	console.log(mess);
	mess.setAttribute('style', 'display:none');
}