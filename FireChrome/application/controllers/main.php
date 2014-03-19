<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	private $sessionData = array();

	/**
	 * Index page for main controller.
	 */
	public function index() {
		$this->sessionData = array(
			'user_id' => $this->session->userdata('user_id'),
			'username' => $this->session->userdata('username'),
			'email' => $this->session->userdata('email'),
			'level' => $this->session->userdata('level'),
			'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);
		$this->load->model('newsModel');

		$this->load->view('header', $this->sessionData);
		$this->load->view('home', array('news' => $this->newsModel->getVisibleNews()));
		$this->load->view('footer');
	}

	/**
	 * Settings page for main controller.
	 */
	public function settings() {
		$this->sessionData = array(
			'user_id' => $this->session->userdata('user_id'),
			'username' => $this->session->userdata('username'),
			'email' => $this->session->userdata('email'),
			'level' => $this->session->userdata('level'),
			'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);
		$this->load->view('header', $this->sessionData);

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

		$this->form_validation->set_rules('password', 'Praegune parool', 'required|trim|xss_clean');
		$this->form_validation->set_rules('npassword', 'Uus parool', 'required|trim|xss_clean');
		$this->form_validation->set_rules('anpassword', 'Uus parool uuesti', 'required|trim|matches[npassword]|xss_clean');

		if ($this->form_validation->run()) {
			$this->load->model('usersModel');
			$email = $this->session->userdata('email');

			if ($this->usersModel->isPasswordCorrectByEmail($email, $this->input->post('password'))) {
				if ($this->usersModel->changePasswordByEmail($email, $this->input->post('npassword'))) {
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