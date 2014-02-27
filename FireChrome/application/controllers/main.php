<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 */
	public function index() {
		if ($this->session->userdata('is_logged_in')) {
			$data['isLoggedIn'] = $this->session->userdata('is_logged_in');

			$this->load->view('header', $data);
		}
		else {
			$this->load->view('header');
		}
		$this->load->view('home');
		$this->load->view('footer');
	}

	public function settings() {
		$this->load->view('settings');
	}

	/**
	 * Logout function
	 */
	public function logout() {
		$this->session->sess_destroy();

		redirect('main', 'refresh');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */