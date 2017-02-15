<?php

require_once('inc.php');

$create_db = "CREATE DATABASE IF NOT EXISTS " . $DB_NAME . ";";

//Connect to MySql (db not created yet) and get the PDO object;
$db = connect_db(TRUE);

//Create DB
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

?>
