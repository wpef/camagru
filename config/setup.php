<?php

require_once('database.php');

echo YOYO;
$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
var_dump($db);
?>
