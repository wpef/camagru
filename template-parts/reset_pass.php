<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<?php
if ($_GET['act'] == 'confirm') :
	$log = $_GET['login'];
	$token = $_GET['token'];

	if (isset($_SESSION['user']))
		unset($_SESSION['user']);
	$_SESSION['user'] = new User($log);

if (isset($_SESSION['user']) && $token === $_SESSION['user']->token()) : ?>
	<p id='message'> You are resetting the password for <?php echo $log ?>.</p>
	<form name="reset" method="post" action="<?php echo WEBROOT . 'mods/reset_pass.php?act=reset'?>">
	New Password : <input type="password" name="new_pw" required/><br>
	Confirm Password  : <input type="password" name="new_pw1" required/><br>
	<input type="submit" name="submit" value="Reset password" /><br>
	</form>
<?php endif; ?>

<?php else : ?>
	<form name="reset_pass" method="post" action="<?php echo WEBROOT . 'mods/reset_pass.php?act=send'?>">
	Login : <input type="text" name="login" required/><br>
	Mail  : <input type="text" name="mail" required /><br>
	<input type="submit" name="submit" value="Send reset link" /><br>
	</form>
<?php endif; ?>