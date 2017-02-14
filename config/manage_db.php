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
// MUST SET ERROR TYPE !!!!!!
	global $DB_USER, $DB_PASSWORD, $DB_DSN, $DB_NAME;

	try {
		if ($new)
			$db = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
		else
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$db->exec("USE " . $DB_NAME);
		//set error
		return $db;
	}
	catch (PDOexcpetion $e) {
		die ('DB CONNECTION ERROR: ' . $e->getMessage());
	}

}

function insert_datas ($table, $datas)
{
//This function return a formated SQL string to insert datas to the database.table. $table is the name of the table to be update and $datas is an array where $keys correspond to table entry and $values to their values to be set; 
	$start = "insert into " . $table;
	$keys = "(";
	$vals = "VALUES (";

	$i = 0;
	foreach ($datas as $key => $val) {
		$keys = $keys . $key;
		if (!is_numeric($val) and !is_bool($val))
			$val = "'" . $val . "'";
		$vals = $vals . $val;
		if ($i < count($datas) - 1)
		{
			$keys = $keys . ", ";
			$vals = $vals . ", ";
		}
		else
		{
			$keys = $keys . ") ";
			$vals = $vals . ") ";
		}
		$i++;
	}
	return $start . $keys . $vals . ";";
}

function user_exists ($log)
{
	if (is_array($log))
		$login = $log['login'];
	else
		$login = $log;
	$db = connect_db(FALSE);
	$query = "select * from users where login='" . $login . "';";
	$curs = $db->query($query);
	$count = $curs->rowCount();
	$curs->closeCursor();
	if ($count == 1)
		return TRUE;
	return FALSE;
}

?>
