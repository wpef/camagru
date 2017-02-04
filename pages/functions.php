<?php

function display_alerts()
{
	if (!empty($_SESSION['message']) || !empty($_SESSION['alert']))
	{
		if (!empty($_SESSION['message']))
			echo "<p id='message'>" . $_SESSION['message'] . '</p>';
		if (!empty($_SESSION['alert']))
			echo "<p id='alert'>" . $_SESSION['alert'] . '</p>';
		unset($_SESSION['message']); unset($_SESSION['alert']); 
	}
}

?>