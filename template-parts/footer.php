<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<script type="text/javascript" src="<?php echo WEBROOT . 'script/script.js'?>"></script>
</div>
<footer>
	<ul>
		<li><a href="<?php echo WEBROOT;?>">Take a picture</a></li>
		<li><a href="<?php echo WBROOT . "/pages/gallery.php"?>">Gallery</a></li>
		<li><a href="<?php echo WBROOT . "/pages/login.php"?>">Sign in / Login</a></li>
	</ul>
	<p id='logo'> Camagru.fr </p>
	<p id='copyright'>Created by <a id='mysite' target="_blank" href="http://fdemoncade.com">fdemoncade</a> for 42.</p>
</footer>
</body>
</html>