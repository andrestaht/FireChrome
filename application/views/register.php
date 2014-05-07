<?php
	require_once(APPPATH . 'libraries/Recaptchalib.php');

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

	echo "<p>Soovin uudiskirja?: ";
	echo form_checkbox('wants_newsletter', $this->input->post('wants_newsletter'));
	echo "</p>";

	echo recaptcha_get_html(RECAPTCHA_PUBLIC_KEY);

	echo "<p>";
	echo form_submit('register-submit-btn', 'Registreeri');
	echo "</p>";

	echo form_close();
?>