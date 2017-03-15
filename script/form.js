var pass = document.querySelector("input[type='password']");
var title = document.querySelector('h2').innerHTML;

if (title != 'Sign In' && pass) { 
	pass.addEventListener('focusout', function () {
		upp = new RegExp("[A-Z]+");
		low = new RegExp("[a-z]+");
		nbr = new RegExp("[0-9]+");
		if	((upp.test(this.value) && low.test(this.value) && nbr.test(this.value)) 
				&& (this.value.length >= 6))
			return true;
		else
		{
			var det = document.querySelector("input[type='password'] + p.details");
		
			this.value = "";
			this.className = "wrong";
			this.onfocus = function(){
				this.className = "";
				if (det)
					det.style.color = "initial"; 
			};
			if (det)
				det.style.color = "red";
		}
	});
}

var inputs = document.querySelectorAll('input');
var button = document.querySelector("form input[type='submit']");
button.disabled = true;

for (i = 0; i < inputs.length; i++) {
	if (inputs[i].required) {
		inputs[i].onkeyup = function () {
			for (j = 0; j < inputs.length; j++)
			{
				if (inputs[j].required && !inputs[j].value)
					return false;
			}
			button.disabled = false;
		};
	}
}