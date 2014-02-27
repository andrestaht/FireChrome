<?php
	echo validation_errors();

	echo form_open('login/resetPassword');

	echo "<p>E-mail: ";
	echo form_input('email');
	echo "</p>";

	echo "<p>";
	echo form_submit('send_new_password', 'Saada uus parool');
	echo "</p>";

	echo "<a href='" . base_url() . "login" . "'>Logi Sisse!</a>";

	echo form_close();
?>