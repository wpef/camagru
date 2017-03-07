<?php
if(!defined('access')) { die('Direct access not permitted'); }
include_once 'head.php';
?>

<header>
	<a href = "<?php echo WEBROOT . 'pages/gallery.php' ?>">Gallery</a>
	<a href = "<?php echo WEBROOT ?>" id="logo">Camagru</a>

<?php if (!$_SESSION['log']) : ?>
	<a href = "<?php echo WEBROOT . 'pages/login.php?action=signin' ?>">Login</a>

<?php else : ?>
	<a id='account' onclick="disp_menu()" href="#"> Account </a>
		<ul id="account_menu">
			<li><a href = "<?php echo WEBROOT . 'pages/gallery.php?type=user'; ?>">My pictures</li>
			<li><a href = "<?php echo WEBROOT . 'pages/gallery.php?type=liked'; ?>">Liked pictures</li>
			<li><a href = "<?php echo WEBROOT . 'pages/account_settings.php'; ?>">Edit account</a></li>
			<li><a href = "<?php echo WEBROOT . '/mods/logout.php';?>">Logout</a></li>
		</ul>
	</div>

<?php endif; ?>

</header> <div class='body'>