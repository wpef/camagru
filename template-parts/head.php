<?php if(!defined('access')) { $_SESSION['alert'] = 'Direct access not permitted'; header('Location: ..?error=direct_access');} ?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Camagru</title>
	<link rel="stylesheet" href= "<?php echo WEBROOT . 'style/style.css';?>"/>
	<link rel="stylesheet" href="<?php echo WEBROOT . 'style/f_aw/css/font-awesome.min.css';?>"/>
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
	<script type="text/javascript"> var WEBROOT = "<?php echo WEBROOT ?>"; </script>
</head>
<body>