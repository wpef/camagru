<form name="signin" action="<?php echo WEBROOT . '/mods/signin.php'?>" method="post" />
		Login : <br>  <!-- or email -->
		<input type="text" name="login" required /> <br>
		Password : <br>
		<input type="password" name="pass" required /> <br>
		<input type="submit" name="submit" value="Sign In !">
</form>
<a href = "<?php echo WEBROOT . 'pages/login.php?action=reset&act=getinfos'?>">I have forgotten my password</a>
<a href = "<?php echo WEBROOT . 'pages/login.php?action=sigup' ?>">I need an account !</a>