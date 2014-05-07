<h1>Seaded</h1>
<?php if (!empty($msg)) {
	echo "<div id='settings-msg'>".$msg."</div>";
} ?>
<?php if ($wants_newsletter) { ?>
	<a class="change-newletter-link" href="<?php echo base_url() . 'user_control/remove_newsletter_subscription/' . $session_data['user_id'] ?>">Loodun uudiskirjast</a>
<?php } else { ?>
	<a class="change-newletter-link" href="<?php echo base_url() . 'user_control/add_newsletter_subscription/' . $session_data['user_id'] ?>">Liitun uudiskirjaga</a>
<?php } ?>
<?php if ($session_data['level'] > 5) { ?>
	<a id="usercontrol" href="<?php echo base_url() . "user_control" ?>">Halda Kasutajaid</a>
<?php } ?>
<a id="change-password-link" href="javascript:void(0);">Muuda parooli</a>
<?php
	echo validation_errors ();

	echo form_open('user_control/change_password_validation', array('id' => 'change-password-form'));

	echo "<p>Praegune parool: ";
	echo form_password('password');
	echo "</p>";

	echo "<p>Uus parool: ";
	echo form_password('npassword');
	echo "</p>";

	echo "<p>Uus parool uuesti: ";
	echo form_password('anpassword');
	echo "</p>";

	echo "<p>";
	echo form_submit('change_password_submit', 'Muuda parool');
	echo "</p>";

	echo form_close();
?>