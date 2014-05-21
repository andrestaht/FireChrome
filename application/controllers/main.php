<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {

	/**
	 * Index page for main controller.
	 */
	public function index($category_id = null) {
		$this->load->model("user_model");
		$this->load->model('category_model');
		$this->load->model('news_model');

		$session_data = $this->get_session_data();
		
		$data = array(
			'session_data' => $session_data,
			'menu_data' => $this->category_model->get_all_categories(),
			'news_data' => $this->news_model->get_news($category_id),
			'wants_newsletter' => $this->user_model->check_if_user_wants_newsletter($session_data['user_id']),
		);

		$flashmsg["msg"] = $this->session->flashdata("msg");
		$this->load->view('header', $data);
		$this->load->view('home', $flashmsg);
		$this->load->view('footer');
	}

	public function write_newsletter() {
		$this->load->model("user_model");
		$this->load->model('news_model');
		$this->load->model('category_model');

		$session_data = $this->get_session_data();
		
		$data = array(
			'session_data' => $session_data,
			'menu_data' => $this->category_model->get_all_categories(),
			'wants_newsletter' => $this->user_model->check_if_user_wants_newsletter($session_data['user_id']),
		);
		$flashmsg["msg"] = $this->session->flashdata("msg");

		$this->load->view('header', $data);
		$this->load->view('newsletter', $flashmsg);
		$this->load->view('footer');
	}

	public function send_newsletter() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Pealkiri', 'required|trim|xss_clean');
		$this->form_validation->set_rules('content', 'Sisu', 'required|trim|xss_clean');

		if ($this->form_validation->run()) {
			$this->load->model('user_model');

			$this->load->library(
				'email',
				array(
					'mailtype' => 'html',
				)
			);
			$users = $this->user_model->get_all_users_with_newsletter_subscription();

			if (!empty($users)) {
				foreach ($users as $user) {
					// email send data
					$this->email->from($this->config->item('email'), 'FireChrome');
					$this->email->to($user->email);
					$this->email->subject($this->input->post('title'));
				
					// send email message and key to user
					$this->email->message($this->input->post('content'));
				
					if ($this->email->send()) {
						$this->session->set_flashdata("msg", "Kasutajatele uudiskiri saadetud!");
					}
					else {
						$this->session->set_flashdata("msg", "Kasutajatele uudiskirja ei saadetud!");
					}
				}
			}
			else {
				$this->session->set_flashdata("msg", "Ükski kasutaja ei soovi uudiskirju!");
			}
		}
		else {
			$this->session->set_flashdata("msg", "Täitke väljad!");
		}
		redirect('main/write_newsletter');
	}

	/**
	 * Logout function
	 */
	public function logout() {
		require_once( 'application/libraries/Facebook.php');

		$this->session->sess_destroy();

		if (!empty($is_facebook_account)) {
			$this->load->library('Facebook', $config);

			parse_str($_SERVER['QUERY_STRING'], $_REQUEST);

			$CI = &get_instance();
			$CI->config->load('facebook', TRUE);

			$config = $CI->config->item('facebook');

			$args['next'] = base_url();

			$this->facebook->destroySession();

			redirect($this->facebook->getLogoutUrl($args));
		}
		redirect('main/index/1', 'refresh');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */