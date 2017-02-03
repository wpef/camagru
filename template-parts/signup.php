<form name="signup" action="/mods/signup.php?action=create" method="post" />
	<fieldset>
		<legend>Required Informations :</legend>
		Login : <br>
		<input type="text" name="login" required /> <br>
		Password : <br>
		<input type="text" name="pass" required /> <br>
		Mail : <br>
		<input type="text" name="mail" required /> <br>
	</fieldset>
	<fieldset>
		<legend>Optional Informations :</legend>
		First name:<br>
		<input type="text" name="f_name" ><br>
		Last name:<br>
		<input type="text" name="l_name" ><br>
	</fieldset>
	<input type="submit" value="Sign Up !">
</form>
<a href = "/pages/login.php?action=signin">I already have an account !</a>