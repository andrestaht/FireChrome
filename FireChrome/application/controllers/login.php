<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	/**
	 * Login Page index controller.
	 */
	public function index() {
		$this->login();
	}

	/**
	 * Login Page login function.
	 */
	public function login() {
		$this->load->view('header');
		$this->load->view('login');
		$this->load->view('footer');
	}

	/**
	 * Login Page login validation function.
	 */
	public function loginValidation() {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|xss_clean|callback_validateCredentials');
		$this->form_validation->set_rules('password', 'Parool', 'required|trim|xss_clean|md5');

		if ($this->form_validation->run()) {
			$this->load->model('usersModel');

			$userData = $this->usersModel->getUserDataByEmail($this->input->post('email'));

			$data = array(
				'user_id' => $userData->id,
				'username' => $userData->username,
				'email' => $userData->email,
				'level' => $userData->level,
				'is_logged_in' => 1,
			);
			$this->session->set_userdata($data);

			redirect('main', 'refresh');
		}
		$this->login();
	}

	public function validateCredentials() {
		$this->load->model('usersModel');

		if ($this->usersModel->canLogIn()) {
			return true;
		}
		$this->form_validation->set_message('validate_credentials', 'Vale e-mail/parool!');

		return false;
	}

	public function forgotPassword() {
		$this->load->view('header', array('isLoggedIn' => $this->session->userdata('is_logged_in')));
		$this->load->view('forgotPassword');
		$this->load->view('footer');
	}

	public function resetPassword() {
		$password = substr(hash('sha512', rand()), 0, 12);
		$email = $this->input->post('email');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email');

		if ($this->form_validation->run()) {
			$this->load->model('usersModel');
			$this->load->library('email', array('mailtype' => 'html'));

			// email send data
			$this->email->from($this->config->item('email'), 'FireChrome');
			$this->email->to($this->input->post('email'));
			$this->email->subject('Teie parool');

			// email message
			$message = "<p>Teie parool on: " . $password . "</p>";
			$message .= "<p><a href='" . base_url() . "login" . "'>Logi sisse</a></p>";

			// send email message and key to user
			$this->email->message($message);

			if ($this->usersModel->doesEmailExists($email)) {
				if ($this->usersModel->changePasswordByEmail($email, $password)) {
					if ($this->email->send()) {
						echo "E-mail saadetud!";
					}
					else {
						echo "E-maili saatmine ebaõnnestus!";
					}
					redirect('login');
				}
				else {
					echo "Parooli ei uuendatud!";
				}
			}
			else {
				echo "Sellist e-maili ei eksisteeri";
			}
		}
		else {
			$this->forgotPassword();
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */