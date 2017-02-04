<?php


//TABLES

	//user
$user_a = array (
		'ID'		=>	'SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
		'login' 	=>	'varchar(15) NOT NULL',
		'pass'		=>	'varchar(199) NOT NULL',
		'mail'		=>	'varchar(30) NOT NULL',
		'f_name'	=>	'varchar(99)',
		'l_name'	=>	'varchar(99)',
		'isadmin'	=>	'bool DEFAULT 0',
		'confirmed'	=>	'bool DEFAULT 0'
	);

	//image


//ADMIN USER
$admin_user = array (
	'login' => 'admin',
	'pass' => hash('whirlpool','admin'),
	'mail' => 'f.demoncade@gmail.com',
	'f_name' => 'admin',
	'l_name' => 'admin',
	'isadmin' => TRUE,
	'confirmed' => TRUE
	);

?>