<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<div class="form">
	<h2>Sign up</h2>
<form name="signup" action="<?php echo WEBROOT . 'mods/signup.php?action=create'?>" method="post" />
	<fieldset>
		<legend>Required Informations :</legend>
		<input type="text" name="login" placeholder="Login" required /> <br>
		<p class='details'>Login must be 15 char. max.</p>
		<input type="password" name="pass" placeholder="Password" required />
		<p class='details'>Password must be minimum 6 chars., containing at least 1 number, 1 uppercase and 1 lowercase char.</p>
		<input type="email" name="mail" placeholder="Mail" required /> <br>
	</fieldset>
	<fieldset>
		<legend>Optional Informations :</legend>
		<input type="text" name="f_name" placeholder= "First Name" ><br>
		<input type="text" name="l_name" placeholder= "Last Name" ><br>
	</fieldset>
	<input type="submit" value="Sign Up !">
</form>
<a href = "<?php echo WEBROOT . 'pages/login.php?action=signin' ?>">I already have an account !</a>
</div>
<script type="text/javascript" src="<?php echo WEBROOT . 'script/form.js'?>"></script>