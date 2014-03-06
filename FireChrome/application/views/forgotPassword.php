<?php
	echo validation_errors();

	echo form_open('login/resetPassword', array('id' => 'forgot-password-form'));

	echo "<p>E-mail: ";
	echo form_input('email');
	echo "</p>";

	echo "<p>";
	echo form_submit('send-new-password-btn', 'Saada uus parool');
	echo "</p>";

	echo "<p>Logi sisse <a href='" . base_url() . "login" . "'>siit</a>!</p>";

	echo form_close();
?>