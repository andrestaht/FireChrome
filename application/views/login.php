
<div id="login_popup" >
	<?php
		echo validation_errors();
		
		echo "<a href='javascript:void(0)' id='close_login_popup'>X</a>";
	
		echo form_open('login/login_validation', array('id' => 'login-form'));
	
		echo "<p>E-mail: ";
		echo form_input('email', $this->input->post('email'));
		echo "</p>";
	
		echo "<p>Parool: ";
		echo form_password('password');
		echo "</p>";
	
		echo "<p>";
		echo form_submit('login-submit-btn', 'Logi Sisse');
		echo "</p>";
	
		echo "<p>Pole kasutajat? registreeri <a href='" . base_url() . "register" . "'>siin</a>!</p>";
		echo "<p>Unustasid <a href='" . base_url() . "login/forgot_password" . "'>parooli</a>?</p>";
	
		echo form_close();
	?>
	</div>