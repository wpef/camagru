<?php
define('access', true);
require_once('inc.php');

if ($_POST['submit'] == "ok") :
	$drop_db = "DROP DATABASE IF EXISTS " . $DB_NAME . ";";
	$create_db = "CREATE DATABASE IF NOT EXISTS " . $DB_NAME . ";";
	
	//Connect to MySql (db not created yet) and get the PDO object;
	$db = connect_db(TRUE);
	
	//Create DB
	try { $db->exec($drop_db); }
	catch (PDOexcpetion $e) {;}
	
	try { $db->exec($create_db); }
	catch (PDOexcpetion $e) { die("ERROR CREATING DB : " . $e->getMessage());}
	
	//Create tables var;
	include_once('tables.php');
	
	//push tables + admin to DB;
	try {
			$db->exec("USE " . $DB_NAME);
			foreach ($tables as $name => $v) {
				$db->exec(create_table($name, $v));
			}
			new User ($admin_user);
			
			if (isset($_POST["dummy"]))
			{
				new User ($guest_user);
				get_sample_images();
			}
		}
	catch (PDOexcpetion $e) {
	die ('DB ERROR: ' . $e->getMessage());
	}

	if (!is_dir(ROOT . "photos"))
		mkdir(ROOT . "photos");

	echo "<p class='message'>THE SITE IS SET UP</p>
	<a href='../index.php'>Visit</a>";
else : ?>
<form name="setup" action="<?php echo WEBROOT . 'config/setup.php'; ?>" method="post"/>
	<input type="checkbox" name="dummy" value="1"/> Upload dummy content<br>
	<button type="submit" name="submit" value="ok"> (Re) Generate Database </button>
</form>

<?php endif;

//FUNCTIONS
function get_sample_images() {
	//add all already taken images in photos/dir (might to the same for /sample);
	$dir = ROOT . 'photos/';
	$photos = glob($dir . "*.png");

	date_default_timezone_set('Europe/Paris');
	$p_query = "INSERT INTO pictures (pic_src, pic_owner, pic_name, added_on) ";
	$p_query .= "VALUES (?, ?, ?, ?);";

	$db = connect_db(FALSE);

	$q = $db->prepare($p_query);

	$rand = 0;
	foreach ($photos as $p) {
		$name = explode('.', basename($p));
		$name = $name[0];
		if ($rand % 3)
		{
			$a = array( WEBROOT . 'photos/' . basename($p), 'guest', 
				$name, date('Y-m-d H:i:s', time() - (15 * $rand - 12)));
		}
		else
		{
			$a = array( WEBROOT . 'photos/' . basename($p), 'admin', 
				$name, date('Y-m-d H:i:s', time() - (15 * $rand - 11)));
		}
		$q->execute($a);
		$rand++;
	}
}

function get_sample_comments() {
	$i = 1;
	while ($i <= 5)
	{
		$pict = new Picture (array('id' => $i));
		$pict->addComment('admin', "This is a comment, its the comment number $i");
		$pict->addComment('admin', "This is another comment for number $i");
		$pict->addComment('guest', "I'm onna drop here a last one");
		$pict->addComment('guest', "And even another one to see display for load");
		$i++;
	}
}

?>
