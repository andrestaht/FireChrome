<?php
	echo validation_errors();

	echo form_open('register/registerValidation');

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

	echo "<p>";
	echo form_submit('register_submit', 'Registreeri');
	echo "</p>";

	echo form_close();
?>