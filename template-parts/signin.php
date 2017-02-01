<?php include_once ($_SERVER['DOCUMENT_ROOT'] . '/template-parts/head.php'); ?>

<form name="signin" action="/mods/signin.php" method="post" />
		Login : <br>  <!-- or email -->
		<input type="text" name="login" required /> <br>
		Password : <br>
		<input type="text" name="pass" required /> <br>
		<input type="submit" name="submit" value="Sign In !">
</form>