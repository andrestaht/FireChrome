<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="et">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<title>FireChrome</title>
		<link href="<?php echo base_url() . "assets/css/reset.css" ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url() . "assets/css/style.css" ?>" rel="stylesheet" type="text/css">
		<script src="<?php echo base_url() . "assets/js/jquery.min.js" ?>" type="text/javascript" ></script>
		<script src="<?php echo base_url() . "assets/js/global.js" ?>" type="text/javascript" ></script>
	</head>
	<body>
		<div id="wrap">
			<div id="header">
				<a href="<?php echo base_url() ?>"><span id="logo"></span></a>
				<?php if (empty($is_logged_in)) { ?>
				<a id="login" href="<?php echo base_url() . "login" ?>">Logi Sisse</a>
				<a id="register" href="<?php echo base_url() . "register" ?>">Registreeri</a>
				<?php } else { ?>
				<h1>Tere <?php echo $username; ?>!</h1>
				<a id="settings" href="<?php echo base_url() . "main/settings" ?>">Seaded</a>
				<a id="logout" href="<?php echo base_url() . "main/logout" ?>">Logi välja</a>
				<?php } ?>
				<div id="current-time">
				</div>
			</div>
			<div id="content">