<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . "/class/User.class.php");

session_start(); //for debug
header('Refresh: 3; URL=/index.php');

$_SESSION['user']->logout();


?>