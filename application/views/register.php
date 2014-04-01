<?php
	echo validation_errors();
	echo $captchaerror;

	echo form_open('register/register_validation', array('id' => 'register-form'));

	echo "<p>Kasutajanimi: ";
	echo form_input('username', $this->input->post('username'));
	echo "</p>";

	echo "<p>E-mail: ";
	echo form_input('email', $this->input->post('email'));
	echo "</p>";

	echo "<p>Parool: ";
	echo form_password('password');
	echo "</p>";

	echo "<p>Parool uuesti: ";
	echo form_password('cpassword');
	echo "</p>";
	
	require_once(APPPATH.'libraries/recaptcha-php-1.11/recaptchalib.php');
	$publickey = Recaptcha_public; // you got this from the signup page
	echo recaptcha_get_html($publickey);

	echo "<p>";
	echo form_submit('register-submit-btn', 'Registreeri');
	echo "</p>";

	echo form_close();
?>