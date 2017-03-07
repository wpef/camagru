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
		if ($new === TRUE)
			$db = new PDO('mysql:host=localhost', $DB_USER, $DB_PASSWORD);
		else
		{
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->exec("USE " . $DB_NAME);
		}
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}
	catch (PDOexcpetion $e) {
		die ('DB CONNECTION ERROR: ' . $e->getMessage());
	}

}

function insertDatas ($table, $datas)
{
//This function return a formated SQL string to insert datas to the database.table. $table is the name of the table to be update and $datas is an array where $keys correspond to table entry and $values to their values to be set; 

		//connect
		$db = connect_db(FALSE);
		
		//prepare query
		$start = "insert into " . $table;
		$keys = "(";
		$vals = "VALUES (";

		$i = 0;
		foreach ($datas as $key => $val) {
			$keys .= $key;
			$vals .= '?';
			if ($i < count($datas) - 1)
			{
				$keys .= ", ";
				$vals .= ", ";
			}
			else
			{
				$keys .= ") ";
				$vals .= ") ";
			}
			$i++;
		}
		$p_query = $start . $keys . $vals . ";";
		//return ($p_query); ==> function setting p_query
		$query = $p_query;
		
		try { $p_query = $db->prepare($p_query); }
		catch (PDOexcpetion $e) {
		die ("ERROR PREPARING QUERY : $query :" . $e->getMessage());
		}

		//set vars
		$i = 1;
		foreach ($datas as $key => $value) {
		if ( $p_query->bindValue($i, $value) === FALSE )
			die ("ERROR BINDING VALUE : $key -> $value");
		$i++;
		}

		//exec
		try { $p_query->execute(); }
		catch (PDOexcpetion $e) {
		die ("ERROR EXECUTING QUERY : $query :" . $e->getMessage());
		}
}

function insertDatas2($p_query, $datas)
{
	$db = connect_db(FALSE);
	
	if (empty($datas)) {
		$db->exec($p_query);
		return;
	}

	try { $q = $db->prepare($p_query);
	} catch (PDOexcpetion $e) {
		die ("ERROR PREPARING QUERY : $p_query :" . $e->getMessage());
	}

	//set vars
	if (!is_array($datas))
		$datas = array($datas);

	//bind params

	//exec
	try { $q->execute($datas) ;
	} catch (PDOexcpetion $e) {
		die ("ERROR EXECUTING QUERY : $query :" . $e->getMessage());
	}
}

function sendQuery($p_query)
{
	insertDatas2($p_query, "");
}

function getDatas($p_query, $datas)
{
//This function returns an array where each entry is a result

		//connect
		$db = connect_db(FALSE);

		if (empty($datas)) {
			try { $obj = $db->query($p_query);}
			catch (PDOexcpetion $e) {
				die ("ERROR QUERY : $p_query :" . $e->getMessage());
			}
		}
		
		else {
			//prepare
			try { $obj = $db->prepare($p_query); }
			catch (PDOexcpetion $e) {
				die ("ERROR PREPARING QUERY : $p_query :" . $e->getMessage());
			}

			//set vars
			if (!is_array($datas))
				$datas = array($datas);

			//exec
			try { $obj->execute($datas) ; }
			catch (PDOexcpetion $e) {
				die ("ERROR EXECUTING QUERY : $query :" . $e->getMessage());
			}
		}

		//read
		$res = $obj->fetchAll();
		$obj->closeCursor();
		return ($res);
}

function userExists ($log)
{
	if (is_array($log))
		$login = $log['login'];
	else
		$login = $log;
	
	$p_query = "SELECT login FROM users WHERE login = ?;";
	$res = getDatas($p_query, $login);

	if (count($res) == 1)
		return TRUE;
	
	return FALSE;
}

?>
