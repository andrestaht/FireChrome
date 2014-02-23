<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -  
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		if ($this->session->userdata('logged_in')) {
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];

			$this->load->view('header', $data);
		}
		else {
			$this->load->view('header');
		}
		$this->load->view('home');
		$this->load->view('footer');
	}

	function logout() {
		$this->session->unset_userdata('logged_in');
		session_destroy();

		redirect('main', 'refresh');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */