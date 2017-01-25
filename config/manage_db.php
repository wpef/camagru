<?php

require_once('database.php');

function create_table($name, $values) {
//create_table returns a formated SQL string creating a table of name $name and columns such as referenced in $values ('name' => 'type');
//create_table was created to use withe PDO->exec() function;

	$create = "CREATE TABLE IF NOT EXISTS " . $name . " (";
	$col = "";
	$end = ");";
	
	if (!isset($values))
		return ($create . $end);

	$i = 0;
	foreach ($values as $vname => $type)
	{
		$col = $col . $vname . " " . $type;
		if ($i < count($values) - 1)
			$col = $col . ', ';
		$i++;
	}

	return $create . $col . $end;

}

function connect_db($new){
// connect_db try to create a connexion to CAMAGRU DATABASE, and return the PDO object if it worked; $new must be set to TRUE if the databases is to be created and FALSE if it already exists;
	global $DB_USER, $DB_PASSWORD, $DB_DSN, $DB_NAME;


	try {
		if ($new)
			$db = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
		else
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		return $db;
	}
	catch (PDOexcpetion $e) {
		die ('DB CONNECTION ERROR: ' . $e->getMessage());
	}

}

?>
