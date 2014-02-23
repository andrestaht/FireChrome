<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	/**
	 * Register Page for this controller.
	 */
	public function index() {
		$this->load->helper(
			array('form')
		);
		$this->load->view('register');
	}
}

/* End of file register.php */
/* Location: ./application/controllers/register.php */