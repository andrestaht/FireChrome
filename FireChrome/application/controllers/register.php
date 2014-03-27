<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Register extends MY_Controller {

	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * Register Page for this controller.
	 */
	public function index() {
		$msg['error'] = "";
		$msg["captchaerror"] = "";

		$this->register($msg);
	}

	public function register($data) {
		$this->load->view('header');
		$this->load->view('register', $data);
		$this->load->view('footer');
	}

	public function register_validation() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Kasutajanimi', 'required|trim|is_unique[user.username]|xss_clean');
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|is_unique[user.email]|xss_clean');
		$this->form_validation->set_rules('password', 'Parool', 'required|trim|xss_clean');
		$this->form_validation->set_rules('cpassword', 'Parool uuesti', 'required|trim|matches[password]|xss_clean');

		require_once (APPPATH . 'libraries/recaptcha-php-1.11/recaptchalib.php');

		$privatekey = "6Lcaz-8SAAAAADvOBApdQbLtAhIcb2_RBTSw2HDC";

		$resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

		$msg['error'] = "";
		$msg["captchaerror"] = "";

		if (!$resp->is_valid) {
			$msg["captchaerror"] = "The reCAPTCHA wasn't entered correctly. Go back and try it again.";
		}
		if ($this->form_validation->run () && $resp->is_valid) {
			$this->load->model('tempuser_model');

			$this->load->library(
				'email',
				array(
					'mailtype' => 'html',
				)
			);

			// generate random key
			$key = md5(uniqid());

			// email send data
			$this->email->from($this->config->item('email'),'FireChrome');
			$this->email->to($this->input->post('email'));
			$this->email->subject('Kinnitage oma kasutaja');

			// email message
			$message = "<p>Aitäh registreerimast!</p>";
			$message .= "<p>Teie kasutajanimi on: " . $this->input->post ( 'username' ) . "</p>";
			$message .= "<p>Teie parool on: " . $this->input->post ( 'password' ) . "</p>";
			$message .= "<p><a href='" . base_url () . "register/register_confirmation/" . $key . "'>Vajutage siia</a>, et kasutaja aktiveerida!</p>";

			// send email message and key to user
			$this->email->message($message);

			if ($this->tempuser_model->add_user($key)) {
				if ($this->email->send()) {
					$msg['error'] = "E-mail saadetud!";
				}
				else {
					$msg['error'] = "E-maili saatmine ebaõnnestus!";
				}
			}
			else {
				$msg['error'] = "Ei lisatud andmebaasi kasutajat";
			}
			redirect('main');
		}
		$this->register($msg);
	}

	public function register_confirmation($key) {
		$this->load->model('user_model');
		$this->load->model('tempuser_model');

		if ($this->tempuser_model->is_key_valid($key)) {
			if ($newUser = $this->user_model->add_user($key)) {
				$data = array (
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
			echo "Aktiveerimisvõti on vale!";
		}
	}
}

/* End of file register.php */
/* Location: ./application/controllers/register.php */