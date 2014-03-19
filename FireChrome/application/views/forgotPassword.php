<?php
	echo validation_errors();

	echo form_open('login/resetPassword', array('id' => 'forgot-password-form'));

	echo "<p>E-mail: ";
	echo form_input('email');
	echo "</p>";
	
	require_once(APPPATH.'libraries/recaptcha-php-1.11/recaptchalib.php');
	$publickey = "6Lf2zO8SAAAAAE4y2rx2lIM8nbqry-o5bYmveuJ5"; // you got this from the signup page
	echo recaptcha_get_html($publickey);

	echo "<p>";
	echo form_submit('send-new-password-btn', 'Saada uus parool');
	echo "</p>";

	echo "<p>Logi sisse <a href='" . base_url() . "login" . "'>siit</a>!</p>";

	echo form_close();
?>