<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {

	/**
	 * Index page for main controller.
	 */
	public function index($category_id = null) {
		$this->load->model('category_model');
		$this->load->model('news_model');

		$data = array(
			'session_data' => $this->get_session_data(),
			'menu_data' => $this->category_model->get_all_categories(),
			'news_data' => $this->news_model->get_news($category_id),
		);

		$flashmsg["msg"]=$this->session->flashdata("msg");
		$this->load->view('header', $data);
		$this->load->view('home',$flashmsg);
		$this->load->view('footer');
	}

	/**
	 * Settings page for main controller.
	 */
	public function settings() {
		$this->load->model('category_model');

		$data = array(
			'session_data' => $this->get_session_data(),
			'menu_data' => $this->category_model->get_all_categories(),
		);
		$this->load->view('header', $data);

		if ($this->session->userdata('is_logged_in')) {
			$flashmsg["msg"]= $this->session->flashdata("msg");
			$this->load->view('settings', $flashmsg);
		}
		else {
			$this->load->view('no_access');
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
					$this->session->set_flashdata('msg', 'Parool edukalt muudetud');
				}
				else {
					$this->session->set_flashdata('msg', 'Parooli ei muudetud');
				}
			}
			else {
				$this->session->set_flashdata('msg', 'Olemasolev parool oli sisestatud valesti');
			}
		}
		else{
			$this->session->set_flashdata('msg', 'Paroolid ei ühti');
		}
		redirect('main/settings', 'refresh');
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
		redirect('main', 'refresh');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */