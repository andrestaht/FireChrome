<h1>Seaded</h1>
<ul>
	<li><a id="change-password-link" href="javascript:void(0);">Muuda
			parooli</a></li>

<?php
echo validation_errors ();

echo form_open ( 'main/changePasswordValidation', array (
		'id' => 'change-password-form' 
) );

echo "<p>Praegune parool: ";
echo form_password ( 'password' );
echo "</p>";

echo "<p>Uus parool: ";
echo form_password ( 'npassword' );
echo "</p>";

echo "<p>Uus parool uuesti: ";
echo form_password ( 'anpassword' );
echo "</p>";

echo "<p>";
echo form_submit ( 'change_password_submit', 'Muuda parool' );
echo "</p>";

echo form_close ();
if ($level > 5) {
	?>
<li><a id="usercontrol" href="<?php echo base_url() . "UserControl" ?>">Halda
			Kasutajaid</a></li>
<?php } ?>
</ul>