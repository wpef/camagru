<?php

function display_alerts()
{
	if (!empty($_SESSION['message']) || !empty($_SESSION['alert']))
	{
		if (!empty($_SESSION['message']))
			echo "<p id='message' onclick='hide_mess(this)'>" . $_SESSION['message'] . '</p>';
		if (!empty($_SESSION['alert']))
			echo "<p id='alert' onclick='hide_mess(this)'>" . $_SESSION['alert'] . '</p>';
		unset($_SESSION['message']); unset($_SESSION['alert']); 
	}
}

?>