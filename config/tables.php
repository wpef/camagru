<?php

if(!defined('access')) { die('Direct access not permitted'); }
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
		'pic_id'		=>	'SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
		'pic_src'		=>	'varchar(199) NOT NULL',
		'pic_owner' 	=>	'varchar(15) NOT NULL',
		'pic_name'		=>	'varchar(30) NOT NULL',
		'pic_likes'		=>	'INT UNSIGNED NOT NULL DEFAULT 0',
		'added_on'		=>	'DATETIME NOT NULL' // ==> other table
	);

$com_a = array (
		'com_pic'		=>	'SMALLINT UNSIGNED NOT NULL',
		'com_cont'		=>	'TEXT NOT NULL',
		'com_date'		=>	'DATETIME NOT NULL',
		'com_author'	=>	'varchar(15) NOT NULL'
	);

$likes_a = array (
		'like_pic'		=>	'SMALLINT UNSIGNED NOT NULL',
		'like_author'	=>	'varchar(15) NOT NULL'
	);



$tables = array (
	'users' => $user_a,
	'pictures' => $pic_a,
	'likes' => $likes_a,
	'comments' => $com_a
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

$guest_user = array (
	'login' => 'guest',
	'pass' => hash('whirlpool','guest'),
	'mail' => 'f.demoncade@gmail.com',
	'f_name' => 'Guest',
	'l_name' => 'Demo',
	'confirmed' => TRUE
	);

?>