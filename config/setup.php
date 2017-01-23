<?php

require_once('database.php');
require_once('manage_db.php');

$drop = "DROP DATABASE IF EXISTS " . $DB_NAME . ";";
$create_db = "CREATE DATABASE " . $DB_NAME . ";";

//Connect to MySql (db not created yet);
try {
	$db = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOexception $e) {
	die('ERROR CREATING DB :' . $e->getMessage());
}

//Create DB
$db->exec($drop);
$db->exec($create_db) or die (print_r($db->errorInfo(), true));

//Create tables;
$user_a = array (
		'ID'		=>	'varchar(30)',
		'login' 	=>	'varchar(30)',
		'pass'		=>	'varchar(30)',
		'mail'		=>	'varchar(30)',
		'f_name'	=>	'varchar(30)',
		'l_name'	=>	'varchar(30)',
		'pict_id'	=>	'varchar(30)'
	);

$db->exec("USE " . $DB_NAME);
$db->exec(create_table('users', $user_a));

// var_dump($db);

?>
