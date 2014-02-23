<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('user', '', true);
	}

	function index() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

		if ($this->form_validation->run() == false) {
			//Field validation failed.  User redirected to login page
			$this->load->view('login');
		}
		else {
			//Go to private area
			session_start();
			redirect('main', 'refresh');
		}
	}

	function check_database($password) {
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username');

		//query the database
		$result = $this->user->login($username, $password);

		if ($result) {
			$sessionArray = array();

			foreach ($result as $row) {
				$sessionArray = array(
					'id' => $row->id,
					'username' => $row->username
				);
				$this->session->set_userdata('logged_in', $sessionArray);
			}
			return true;
		}
		else {
			$this->form_validation->set_message('check_database', 'Vale kasutajanimi või parool!');

			return false;
		}
	}
}

?>
