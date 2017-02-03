<?php
include_once 'head.php';
?>
<header>
	<a href = "/camagru/">
		<img src = "/camagru/img/logo.png" id='logo'/>
	</a>
	<div id="account">
		<?php 
		if ($_SESSION['log']) {
			include ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/account_menu.php');
		}
		else
			include ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/login_menu.php');
		?>
	</div>
	<nav id="main_nav">
		<?php // include ($_SERVER['DOCUMENT_ROOT'] . '/camagru/' . '/template-parts/nav.php'); ?>
	</nav>
</header>