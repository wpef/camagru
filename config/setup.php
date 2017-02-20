<?php

require_once('inc.php');

$drop_db = "DROP DATABASE IF EXISTS " . $DB_NAME . ";";
$create_db = "CREATE DATABASE IF NOT EXISTS " . $DB_NAME . ";";

//Connect to MySql (db not created yet) and get the PDO object;
$db = connect_db(TRUE);

//Create DB
$db->exec($drop_db) or die (print_r($db->errorInfo(), true));
$db->exec($create_db) or die (print_r($db->errorInfo(), true));

//Create tables var;
include_once('tables.php');

//push tables + admin to DB; (need other tables)
try {
		$db->exec("USE " . $DB_NAME);
		foreach ($tables as $name => $v) {
			$db->exec(create_table($name, $v));
		}
		new User ($admin_user);
		get_sample_images();
	}
catch (PDOexcpetion $e) {
die ('DB ERROR: ' . $e->getMessage());
}

echo "<p class='message'>THE SITE IS SET UP</p>
<a href='../index.php'>Visit</a>";

// Load database files (DUMMY CONTENT);
function get_sample_images() {
	//add all already taken images in photos/dir (might to the same for /sample);
	$dir = ROOT . 'photos/';
	$photos = glob($dir . "*.png");

	date_default_timezone_set('Europe/Paris');
	$p_query = "INSERT INTO pictures (pic_src, pic_owner, pic_name, added_on) ";
	$p_query .= "VALUES (?, ?, ?, ?);";

	$db = connect_db(FALSE);

	$q = $db->prepare($p_query);

	foreach ($photos as $p) {
		$a = array( WEBROOT . 'photos/' . basename($p), 'admin', 
			basename($p), date('Y-m-d H:i:s', time()));
		$q->execute($a);
	}
}
?>
