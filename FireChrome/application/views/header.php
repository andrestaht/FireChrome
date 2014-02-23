<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>FireChrome</title>
	</head>
	<body>
		<p>See on header.</p>
		<?php if (empty($username)) { ?>
		<a id="login" href="<?php echo base_url(); ?>login">Logi Sisse</a>
		<a id="register" href="<?php echo base_url(); ?>register">Registreeri</a>
		<?php } else { ?>
		<h1>Tere <?php echo $username; ?>!</h1>
		<a id="logout" href="<?php echo base_url(); ?>main/logout">Logi välja</a>
		<?php } ?>