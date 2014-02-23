<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>FireChrome - Logi Sisse</title>
	</head>
	<body>
		<?php echo validation_errors(); ?>
		<?php echo form_open('verifylogin'); ?>
			<label for="username">Kasutajanimi: </label>
			<input type="text" id="username" name="username" />
			<br/>
			<label for="password">Parool: </label>
			<input type="password" id="password" name="password" />
			<br/>
			<input type="submit" value="Login"/>
		</form>
	</body>
</html>