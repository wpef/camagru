<?php

//REQUIRED
define('access', true);
include_once ('../config/inc.php');

//REDIRECTION IF NEEDED

//HEADER
include_once(ROOT . '/template-parts/header.php');

//ALERT
display_alerts();

//CONTENT
include_once(ROOT . 'template-parts/grid.php');

//FOOTER
include_once(ROOT . 'template-parts/footer.php');

?>