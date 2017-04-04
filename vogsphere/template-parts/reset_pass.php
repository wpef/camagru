<?php
if (!defined('access')) {
	$_SESSION['alert'] = 'Direct access not permitted';
	header('Location: ..?error=direct_access');
}

if ($_GET['act'] == 'confirm') :
	$log = $_GET['login'];
	$token = $_GET['token'];

if (isset($_SESSION['user']))
	unset($_SESSION['user']);
$_SESSION['user'] = new User($log);

if (isset($_SESSION['user']) && $token === $_SESSION['user']->token()) : ?>

	<div class="form">
    <h2>Reset password for <?php echo $log ?></h2>
	<form name="reset" method="post" action="<?php echo WEBROOT . 'mods/reset_pass.php?act=reset'?>">
	<input type="password" name="new_pw" placeholder="New Password" required/><br>
	<input type="password" name="new_pw1" placeholder="Confirm Password" required/><br>
	<input type="submit" name="submit" value="Reset password" /><br>
	</form>
	</div>

<?php endif; ?> <?php else : ?>
	
	<div class="form">
    <h2>Reset password</h2>
	<form name="reset_pass" method="post" action="<?php echo WEBROOT . 'mods/reset_pass.php?act=send'?>">
	<input type="text" name="login" placeholder="Login" required/><br>
	<input type="text" name="mail" placeholder="Email" required /><br>
	<input type="submit" name="submit" value="Send reset link" /><br>
	</form>
	</div>

<?php endif; ?>