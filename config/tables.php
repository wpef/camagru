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

	//pictures
$pic_a = array (
		'pic_src'		=>	'varchar(199) NOT NULL',
		'pic_owner' 	=>	'varchar(15) NOT NULL',
		'pic_name'		=>	'varchar(30) NOT NULL',
		'pic_coms'		=>	'SMALLINT UNSIGNED NOT NULL', // ==> other table
		'pic_likes'		=>	'SMALLINT UNSIGNED NOT NULL' // ==> other table
	);

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