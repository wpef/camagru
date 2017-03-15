var pass = document.querySelector("input[type='password']");

pass.addEventListener('focusout', function () {
	upp = new RegExp("[A-Z]+");
	low = new RegExp("[a-z]+");
	nbr = new RegExp("[0-9]+");
	spe = new RegExp("[ ;=.\'\"/\\!@#$,%^&*<~`>?(|:){}\\-[\]_+]+");
	if	(
			(upp.test(this.value) && low.test(this.value) && nbr.test(this.value)) 
			&& (this.value.length >= 6) && spe.test(this.value) == false
	) {
		return true;
	}
	else {
		var det = document.querySelector("input[type='password'] + p.details");
		
		this.value = "";
		this.className = "wrong";
		det.style.color = "red";
	}
}
);

var inputs = document.querySelectorAll('input');
var button = document.querySelector("form input[type='submit']");
button.disabled = true;

for (i = 0; i < inputs.length; i++) {
	inputs[i].addEventListener('onchange', function () {
		for (j = 0; j < inputs.length; j++)
		{
			if (!inputs[j].value)
				return false;
		}
		button.disabled = false;
	});
}