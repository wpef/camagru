<?php

require_once('database.php');
require_once('manage_db.php');
require_once($_SERVER['DOCUMENT_ROOT']  . "/class/User.class.php");

$create_db = "CREATE DATABASE IF NOT EXISTS " . $DB_NAME . ";";

//Connect to MySql (db not created yet) and get the PDO object;
$db = connect_db(TRUE);

//Create DB
$db->exec($create_db) or die (print_r($db->errorInfo(), true));

//Create table user;
$user_a = array (
		'ID'		=>	'SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
		'login' 	=>	'varchar(15) NOT NULL',
		'pass'		=>	'varchar(99) NOT NULL',
		'mail'		=>	'varchar(30) NOT NULL',
		'f_name'	=>	'varchar(99)',
		'l_name'	=>	'varchar(99)',
		'isadmin'	=>	"bool DEFAULT 0"
	);

$admin_a = array (
	'login' => 'admin',
	'pass' => hash('whirlpool','admin'),
	'mail' => 'f.demoncade@gmail.com',
	'f_name' => 'admin',
	'l_name' => 'admin',
	'isadmin' => TRUE
	);

$db->exec("USE " . $DB_NAME);
$db->exec(create_table('users', $user_a));
User::$verbose = TRUE;
new User ($admin_a);

// Load database files (DUMMY CONTENT);

?>
