<?php
session_start();
define ('_ROOT_', getenv('HTTP_HOST'));
include_once($_SERVER['DOCUMENT_ROOT'] . '/config/setup.php');
?>