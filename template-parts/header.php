<?php include_once 'head.php'; ?>

<header>
	<a href = "<?php echo WEBROOT ?>">
		<img src = "<?php echo WEBROOT . '/img/logo.png'?>" id='logo'/>
	</a>
	<div id="account">
		<?php 
		if ($_SESSION['log']) {
			include ('account_menu.php');
		}
		else
			include ('login_menu.php');
		?>
	</div>
	<nav id="main_nav">
		<?php // include ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/nav.php'); ?>
	</nav>
</header>