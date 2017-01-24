<?php

require_once('database.php');
require_once('manage_db.php');

$_SESSION['db_exists'] = true;

$create_db = "CREATE DATABASE IF NOT EXISTS " . $DB_NAME . ";";

//Connect to MySql (db not created yet);
try {
	$db = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOexception $e) {
	die('ERROR CREATING DB :' . $e->getMessage() . '\n' . var_dump($db));
}

//Create DB
$db->exec($create_db) or die (print_r($db->errorInfo(), true));

//Create tables;
$user_a = array (
		'ID'		=>	'SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT',
		'login' 	=>	'varchar(15) NOT NULL',
		'pass'		=>	'varchar(99) NOT NULL',
		'mail'		=>	'varchar(30) NOT NULL',
		'f_name'	=>	'varchar(99)',
		'l_name'	=>	'varchar(99)',
		'pict_id'	=>	'smallint NOT NULL AUTO_INCREMENT',
		'isadmin'	=>	'bool NOT NULL'
	);

$db->exec("USE " . $DB_NAME);
$db->exec(create_table('users', $user_a, 'ID'));

// var_dump($db);

?>
