<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

	function __construct() {
		parent::__construct();

		parse_str($_SERVER['QUERY_STRING'], $_REQUEST);

		$CI = & get_instance();
		$CI->config->load('facebook', TRUE);

		$this->load->library('Facebook', $CI->config->item('facebook'));
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
		$this->load->model("user_model");
		$this->load->model('category_model');

		$this->session->set_userdata('url_before_login', $_SERVER['HTTP_REFERER']);

		$session_data = $this->get_session_data();
		
		$data = array(
			'session_data' => $session_data,
			'menu_data' => $this->category_model->get_all_categories(),
			'wants_newsletter' => $this->user_model->check_if_user_wants_newsletter($session_data['user_id']),
		);
		$flashdata["msg"]=$this->session->flashdata("msg");
		
		$this->load->view('header', $data);
		$this->load->view('login', $flashdata);
		$this->load->view('footer');
	}

	/**
	 *Login function for Facebook.
	 */
	public function facebook_login() {
		$userId = $this->facebook->getUser();

		if ($userId == 0) {
			redirect($this->facebook->getLoginUrl(array('scope'=>'email')));
		}
		else {
			$user = $this->facebook->api('/me');

			$userdata = array(
				'user_id' => $user['id'],
				'username' => $user['name'],
				'email' => $user['email'],
				'is_logged_in' => 1,
				'level' => 1,
				'is_facebook_account' => 1,
			);
			$this->session->set_userdata($userdata);
		}
		$this->load->model('user_model');

		$temp = $this->user_model->get_all_users();
		$bool = false;

		foreach ($temp as $row) {
			if ($row->facebook_id == $userdata['user_id']) {
				$bool = true;
				break;
			}
		}
		if ($bool == false) {
			$data = array(
				'username' => $user['name'],
				'password' => 'test',
				'email' => $user['email'],
				'password' => 555,
				'facebook_id' => $user['id'],
			);
			$this->db->insert('user', $data);
		}
		$temp = $this->user_model->get_all_users();
		$uid = 0;

		foreach ($temp as $row) {
			if ($row->facebook_id == $userdata['user_id']) {
				$uid = $row->id;
			}
		}
		$userdata = array(
			'user_id' => $uid,
		);
		$this->session->set_userdata($userdata);

		$url = $this->session->userdata('url_before_login');
		$this->session->unset_userdata('url_before_login');

		redirect($url, 'refresh');
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

			$url = $this->session->userdata('url_before_login');
			$this->session->unset_userdata('url_before_login');

			redirect($url, 'refresh');
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
		$this->load->model("user_model");
		$this->load->model('category_model');

		$session_data = $this->get_session_data();
		
		$data = array(
			'session_data' => $session_data,
			'menu_data' => $this->category_model->get_all_categories(),
			'wants_newsletter' => $this->user_model->check_if_user_wants_newsletter($session_data['user_id']),
		);
		$flashdata["msg"] = $this->session->flashdata("msg");
		
		$this->load->view('header', $data);
		$this->load->view('forgot_password', $flashdata);
		$this->load->view('footer');
	}

	public function reset_password() {
		require_once(APPPATH . 'libraries/Recaptchalib.php');

		$password = substr(hash('sha512', rand()), 0, 12);
		$email = $this->input->post('email');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|xss_clean');

		$response = recaptcha_check_answer(RECAPTCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

		$data["captchaerror"] = "";

		if (!$response->is_valid) {
			$data["captchaerror"] = "The reCAPTCHA wasn't entered correctly. Go back and try it again.";
		}
		if ($this->form_validation->run() && $response->is_valid) {
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
						$this->session->set_flashdata('msg', 'E-mail saadetud');
					}
					else {
						$this->session->set_flashdata('msg', 'E-maili saatmine ebaõnnestus. Proovige uuesti.');
					}
					redirect('login');
				}
				else {
					$this->session->set_flashdata('msg', 'Parooli ei uudendatud');
					redirect('login/forgot_password');
				}
			}
			else {
				$this->session->set_flashdata('msg', 'Sellist E-maili ei leidu.');
				redirect('login/forgot_password');
			}
		}
		else {
			$this->forgot_password();
		}
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */