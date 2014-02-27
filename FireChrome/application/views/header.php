<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>FireChrome</title>
	</head>
	<body>
		<p>See on header.</p>
		<?php if (empty($isLoggedIn)) { ?>
		<a id="login" href="<?php echo base_url() . "login" ?>">Logi Sisse</a>
		<a id="register" href="<?php echo base_url() . "register" ?>">Registreeri</a>
		<?php } else { ?>
		<a id="logout" href="<?php echo base_url() . "main/settings" ?>">Seaded</a>
		<a id="logout" href="<?php echo base_url() . "main/logout" ?>">Logi välja</a>
		<?php } ?>