<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index page for main controller.
	 */
	public function index() {
		$sessionData = array(
			'username' => $this->session->userdata('username'),
			'email' => $this->session->userdata('email'),
			'level' => $this->session->userdata('level'),
			'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);
		$this->load->view('header', $sessionData);
		$this->load->view('home');
		$this->load->view('footer');
	}

	/**
	 * Settings page for main controller.
	 */
	public function settings() {
		$this->load->view('header', array('isLoggedIn' => $this->session->userdata('is_logged_in')));

		if ($this->session->userdata('is_logged_in')) {
			$this->load->view('settings');
		}
		else {
			$this->load->view('noAccess');
		}
		$this->load->view('footer');
	}

	/**
	 * Changed password validation function.
	 */
	public function changePasswordValidation() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('password', 'Praegune parool', 'required|trim');
		$this->form_validation->set_rules('npassword', 'Uus parool', 'required|trim');
		$this->form_validation->set_rules('anpassword', 'Uus parool uuesti', 'required|trim|matches[npassword]');

		if ($this->form_validation->run()) {
			$this->load->model('users');
			$email = $this->session->userdata('email');

			if ($this->users->isPasswordCorrectByEmail($email, $this->input->post('password'))) {
				if ($this->users->changePasswordByEmail($email, $this->input->post('npassword'))) {
					echo "Parool edukalt muudetud";
				}
				else {
					echo "Parooli ei muudetud";
				}
			}
		}
		$this->settings();
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