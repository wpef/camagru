<?php 

//WORKS

if (empty($_POST))
{
	echo "A PROBLEM OCCURED";
}
else 
{
	foreach ($_POST as $k => $v)
	{
		echo "$k => $v <br>";
	}
}

?>