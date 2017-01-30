<header>
	<a href = "/">
		<img src="/img/logo.png" id='logo'/>
	</a>
	<div id="account">
		<?php 
		if ($_SESSION['log'])
			include ('/template-parts/account_nav.php');
		else
			include ('template-parts/login.php');
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