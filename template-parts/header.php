<?php include_once 'head.php'; ?>

<header>
	<a href = "<?php echo WEBROOT . 'pages/gallery.php' ?>">Gallery</a>
	<a href = "<?php echo WEBROOT ?>" id="logo">Camagru</a>

<?php if (!$_SESSION['log']) : ?>
	<a href = "<?php echo WEBROOT . 'pages/login.php?action=signin' ?>">Login</a>

<?php else : ?>
	<div id="h_account">
	<a href = "<?php echo WEBROOT . 'pages/account_settings.php' ?>">Account</a>
	<a href = "<?php echo WEBROOT . '/mods/logout.php';?>">Logout</a>
	</div>

	<ul id="myaccount">
	<li><a href = "<?php echo WEBROOT . 'pages/gallery.php?type=user'; ?>">My pictures</li>
	<li><a href = "<?php echo WEBROOT . 'pages/gallery.php?type=liked'; ?>">Liked pictures</li>
	<li><a href = "<?php echo WEBROOT . 'pages/account_settings.php'; ?>">Edit account</a></li>
	</ul>

<?php endif; ?>

</header>