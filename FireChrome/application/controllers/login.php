<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

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
	public function login_validation() {
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|xss_clean|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Parool', 'required|trim|xss_clean|md5');

		if ($this->form_validation->run()) {
			$this->load->model('user_model');

			$userData = $this->user_model->get_user_data_by_email($this->input->post('email'));

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

	public function validate_credentials() {
		$this->load->model('user_model');

		if ($this->user_model->can_log_in()) {
			return true;
		}
		$this->form_validation->set_message('validate_credentials', 'Vale e-mail/parool!');

		return false;
	}

	public function forgot_password() {
		$this->load->view('header', array('isLoggedIn' => $this->session->userdata('is_logged_in')));
		$this->load->view('forgot_password');
		$this->load->view('footer');
	}

	public function reset_password() {
		$password = substr(hash('sha512', rand()), 0, 12);
		$email = $this->input->post('email');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|xss_clean');
		
		require_once (APPPATH . 'libraries/recaptcha-php-1.11/recaptchalib.php');
		$privatekey = "6Lcaz-8SAAAAADvOBApdQbLtAhIcb2_RBTSw2HDC";
		$resp = recaptcha_check_answer ( $privatekey, $_SERVER ["REMOTE_ADDR"], $_POST ["recaptcha_challenge_field"], $_POST ["recaptcha_response_field"] );
		$data ["captchaerror"] = "";
		if (! $resp->is_valid) {
			$data ["captchaerror"] = "The reCAPTCHA wasn't entered correctly. Go back and try it again.";
		}

		if ($this->form_validation->run() & $resp->is_valid) {
			$this->load->model('user_model');
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

			if ($this->user_model->does_email_exists($email)) {
				if ($this->user_model->change_password_by_email($email, $password)) {
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
			$this->forgot_password();
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */