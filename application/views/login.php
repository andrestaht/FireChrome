	<?php
		echo validation_errors();

	if(!empty($msg)){
			echo "<div id='login-msg'>".$msg."</div>";}
		
		echo form_open('login/login_validation', array('id' => 'login-form'));
	
		echo "<p>E-mail: ";
		echo form_input('email', $this->input->post('email'));
		echo "</p>";
	
		echo "<p>Parool: ";
		echo form_password('password');
		echo "</p>";
	
		echo "<p>";
		echo form_submit('login-submit-btn', 'Logi Sisse');
		?>
		<a href="<?php echo base_url() . "login/facebook_login" ?>">Facebook</a>
		<?php
		echo "</p>";
	
		echo "<p>Pole kasutajat? registreeri <a href='" . base_url() . "register" . "'>siin</a>!</p>";
		echo "<p>Unustasid <a href='" . base_url() . "login/forgot_password" . "'>parooli</a>?</p>";
	
		echo form_close();
	?>