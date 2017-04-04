<?php
if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ../');}
include_once 'head.php';
?>

<header>
	<a href = "<?php echo WEBROOT ?>"><i class="fa fa-camera-retro fa-2x"></i></a>
	<a href = "<?php echo WEBROOT . 'pages/gallery.php' ?>" id="logo">Camagru</a>

<?php if (!$_SESSION['log']) : ?>
	<a href = "<?php echo WEBROOT . 'pages/login.php?action=signin' ?>"><i class="fa fa-user fa-2x"></i></a>

<?php else : ?>
	<a id='account' onclick="disp_menu()" href="#"> <i class="fa fa-user fa-2x"></i> </a>
		<ul id="account_menu">
			<li><a href = "<?php echo WEBROOT . 'pages/gallery.php?type=user'; ?>">My pictures</li>
			<li><a href = "<?php echo WEBROOT . 'pages/gallery.php?type=liked'; ?>">Liked pictures</li>
			<li><a href = "<?php echo WEBROOT . 'pages/account_settings.php'; ?>">Edit account</a></li>
			<li><a href = "<?php echo WEBROOT . '/mods/logout.php';?>">Logout</a></li>
		</ul>
	<a id='logout' href="<?php echo WEBROOT . '/mods/logout.php';?>"> <i class="fa fa-sign-out fa-2x"></i> </a>
	</div>

<?php endif; ?>

</header> <div class='body'>