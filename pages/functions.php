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

function date_ago($date, $level = 7)
{
    $now = new DateTime;
    $ago = new DateTime($date);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k)
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        else
            unset($string[$k]);
    }

    $string = array_slice($string, 0, $level);

    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

?>