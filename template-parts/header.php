<header>
	<a href = "<?php echo _ROOT_;?>">
		<img src = "<?php echo _ROOT_ . "/img/logo.png"; ?>" id='logo'/>
	</a>
	<div id="account">
		<?php 
		if ($_SESSION['log'])
			include (_ROOT_ . '/template-parts/account_nav.php');
		else
			include (_ROOT_ . '/template-parts/login.php');
		?>
	</div>
	<nav id="main_nav">
		<ul>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		</ul>
	</nav>
</header>