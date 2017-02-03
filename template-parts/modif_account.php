<form name='modif' action='/mods/modif_account.php' method='post' />
	Login (cannot be modify):
	<input type='text' name='login' value='<?php echo $_SESSION['user']->login ?>' readonly/><br>
	Mail :
	<input type='text' name='mail' value='<?php echo $_SESSION['user']->mail ?>' /><br>
	Password :<br>
	Old password : <input type='text' name='old_pw' /><br>
	New password : <input type='text' name='new_pw1'/><br>
	Confirm new password : <input type="text" name="new_pw2"/><br>
	First name :
	<input type='text' name='f_name' value='<?php echo $_SESSION['user']->f_name ?>' /><br>
	Last Name :
	<input type='text' name='l_name' value='<?php echo $_SESSION['user']->l_name ?>' /><br>
	<br>
	<input type="submit" name="submit" value="Apply modifications">
</form>