<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<div class="form">
	<h2>Sign in</h2>
	<form name="signin" action="<?php echo WEBROOT . '/mods/signin.php'?>" method="post" />
		<input type="text" name="login" placeholder="login" required /> <br>
		<input type="password" name="pass" placeholder="password" required /> <br>
		<input type="submit" name="submit" value="Sign in">
	</form>
	<a href = "<?php echo WEBROOT . 'pages/login.php?action=reset&act=getinfos'?>">I have forgotten my password</a>
<a href = "<?php echo WEBROOT . 'pages/login.php?action=sigup' ?>">I need an account !</a>
</div>