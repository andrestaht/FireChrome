<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyRegister extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user', '', true);
	}

	function index() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');

		if ($this->form_validation->run() == false) {
			//Field validation failed.  User redirected to login page
			$this->load->view('register');
		}
		else {
			//Go to private area
			redirect('main', 'refresh');
		}
	}

	function check_database($password) {
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');
		$email = $this->input->post('email');

		$this->user->register($username, $password, $email);
	}
}

?>
