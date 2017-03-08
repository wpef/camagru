<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<ul id='login'>
	<li>
		<a class = "log" href = "<?php echo WEBROOT . 'pages/login.php?action=signin'; ?>"> Sign in </a>
	</li>
	<li>
		<a class = "log" href = "<?php echo WEBROOT . 'pages/login.php?action=signup'; ?>"> Sign Up </a>
	</li>
</ul>