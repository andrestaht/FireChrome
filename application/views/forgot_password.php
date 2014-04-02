<?php
	require_once(APPPATH . 'libraries/Recaptchalib.php');

	echo validation_errors();

	echo form_open('login/reset_password', array('id' => 'forgot-password-form'));

	echo "<p>E-mail: ";
	echo form_input('email');
	echo "</p>";
	
	echo recaptcha_get_html(RECAPTCHA_PUBLIC_KEY);

	echo "<p>";
	echo form_submit('send-new-password-btn', 'Saada uus parool');
	echo "</p>";

	echo "<p>Logi sisse <a href='" . base_url() . "login" . "'>siit</a>!</p>";

	echo form_close();
?>