<?php
include_once 'head.php';
?>
<header>
	<a href = "/">
		<img src = "/img/logo.png" id='logo'/>
	</a>
	<div id="account">
		<?php 
		if ($_SESSION['log'])
			include ($_SERVER['DOCUMENT_ROOT'] . '/template-parts/myaccount.php');
		else
			include ($_SERVER['DOCUMENT_ROOT'] . '/template-parts/login.php');
		?>
	</div>
	<nav id="main_nav">
		<?php // include ($_SERVER['DOCUMENT_ROOT'] . '/template-parts/nav.php'); ?>
	</nav>
</header>