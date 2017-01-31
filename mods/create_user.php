<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . "/class/User.class.php");

$new_user = array (
	'login' => $_POST['login'],
	'pass' => hash('whirlpool', $_POST['pass']),
	'mail' => $_POST['mail'],
	'l_name' => $_POST['l_name'],
	'f_name' => $_POST['f_name']
	);

$current_user = new User($new_user);

$_SESSION['log'] = TRUE;
$_SESSION['user'] = $current_user;

header('Location: /index.php');

?>