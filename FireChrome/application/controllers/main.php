<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {

	/**
	 * Index page for main controller.
	 */
	public function index() {
		$this->load->model('news_model');

		$this->load->view('header', $this->get_session_data());
		$this->load->view('home', array('news' => $this->news_model->get_all_news()));
		$this->load->view('footer');
	}

	/**
	 * Settings page for main controller.
	 */
	public function settings() {
		$this->load->view('header', $this->get_session_data());

		if ($this->session->userdata('is_logged_in')) {
			$this->load->view('settings');
		}
		else {
			$data["logged_in"]= FALSE;

			$this->load->view('no_access', $data);
		}
		$this->load->view('footer');
	}

	/**
	 * Changed password validation function.
	 */
	public function change_password_validation() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('password', 'Praegune parool', 'required|trim|xss_clean');
		$this->form_validation->set_rules('npassword', 'Uus parool', 'required|trim|xss_clean');
		$this->form_validation->set_rules('anpassword', 'Uus parool uuesti', 'required|trim|matches[npassword]|xss_clean');

		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			$email = $this->session->userdata('email');

			if ($this->user_model->is_password_correct_by_email($email, $this->input->post('password'))) {
				if ($this->user_model->change_password_by_email($email, $this->input->post('npassword'))) {
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