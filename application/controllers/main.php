<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {

	/**
	 * Index page for main controller.
	 */
	public function index() {
		$this->load->view('header', $this->get_session_data());
		$this->load->view('home');
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
        if (empty($is_facebook_account)) {
            $this->session->sess_destroy();
            redirect('main', 'refresh');
        } else {
		  parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		  $CI = & get_instance();
		  require_once( 'application/libraries/Facebook.php');
		  $CI->config->load("facebook",TRUE);
       	    $config = $CI->config->item('facebook');
            $this->load->library('Facebook', $config);
		  $args['next'] = base_url();
		  $logoutUrl = $this->facebook->getLogoutUrl($args);
		  $this->facebook->destroySession();		
		  $this->session->sess_destroy();
		  redirect($logoutUrl);	
        }
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */