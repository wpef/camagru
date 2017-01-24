<?php

function create_table($name, $values) {
//create_table returns a formated SQL string creating a table of name $name and columns such as referenced in $values ('name' => 'type') where $key must be a key entry of $values and wille be set as the table primary key;
//create_table was created to use withe PDO->exec() function;
	$create = "CREATE TABLE IF NOT EXISTS " . $name . " (";
	$col = "";
	$skey =  "primary key (". $key . ")";
	$end = ");";
	
	if (!isset($values))
		return ($create . $end);

	foreach ($values as $vname => $type)
	{
		$col = $col . $vname . " " . $type . ",";
		$i++;
	}
	return $create . $col . $skey . $end;
}
?>
