<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>FireChrome</title>
		<link href="<?php echo base_url() . "assets/css/reset.css" ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url() . "assets/css/style.css" ?>" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url() . "assets/js/jquery.min.js" ?>" type="text/javascript" ></script>
	</head>
	<body>
		<div id="wrap">
			<div id="header">
			<p>See on header.</p>
				<?php if (empty($isLoggedIn)) { ?>
				<a id="login" href="<?php echo base_url() . "login" ?>">Logi Sisse</a>
				<a id="register" href="<?php echo base_url() . "register" ?>">Registreeri</a>
				<?php } else { ?>
				<a id="settings" href="<?php echo base_url() . "main/settings" ?>">Seaded</a>
				<a id="logout" href="<?php echo base_url() . "main/logout" ?>">Logi välja</a>
				<?php } ?>
				<a href="<?php echo base_url() ?>"><span id="logo"></span></a>
			</div>
			<div id="content">