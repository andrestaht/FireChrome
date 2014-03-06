<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	/**
	 * Register Page for this controller.
	 */
	public function index() {
		$this->register();
	}

	public function register() {
		$this->load->view('header');
		$this->load->view('register');
		$this->load->view('footer');
	}

	public function registerValidation() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Kasutajanimi', 'required|trim|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Parool', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'Parool uuesti', 'required|trim|matches[password]');

// 		EI TOIMI HETKEL NII NAGU PEAKS
// 		$this->form_validation->set_message('is_unique[users.username]', 'Selline kasutajanimi juba eksisteerib!');
// 		$this->form_validation->set_message('is_unique[users.email]', 'Selline e-mail juba eksisteerib!');

		if ($this->form_validation->run()) {
			$this->load->model('tempUsersModel');

			$this->load->library('email', array('mailtype' => 'html'));

			// generate random key
			$key = md5(uniqid());

			// email send data
			$this->email->from($this->config->item('email'), 'FireChrome');
			$this->email->to($this->input->post('email'));
			$this->email->subject('Kinnitage oma kasutaja');

			// email message
			$message = "<p>Aitäh registreerimast!</p>";
			$message .= "<p>Teie kasutajanimi on: " . $this->input->post('username') . "</p>";
			$message .= "<p>Teie parool on: " . $this->input->post('password') . "</p>";
			$message .= "<p><a href='" . base_url() . "register/registrationConfirmation/" . $key . "'>Vajutage siia</a>, et kasutaja aktiveerida!</p>";

			// send email message and key to user
			$this->email->message($message);
			
			if ($this->tempUsersModel->addUser($key)) {
				if ($this->email->send()) {
					echo "E-mail saadetud!";
				}
				else {
					echo "E-maili saatmine ebaõnnestus!";
				}
			}
			else {
				echo "Ei lisatud andmebaasi kasutajat";
			}
			redirect('main');
		}
		$this->register();
	}

	public function registrationConfirmation($key) {
		$this->load->model('usersModel');
		$this->load->model('tempUsersModel');

		if ($this->tempUsersModel->isKeyValid($key)) {
			if ($newUser = $this->usersModel->addUser($key)) {
				$data = array(
					'username' => $newUser['username'],
					'email' => $newUser['email'],
					'is_logged_in' => 1,
				);
				$this->session->set_userdata($data);
			}
			else {
				echo "Kasutaja pole aktiveeritud!";
			}
			redirect('main');
		}
		else {
			echo "Aktiveerimis võti on vale!";
		}
	}
}

/* End of file register.php */
/* Location: ./application/controllers/register.php */