<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/news
	 *	- or -  
	 * 		http://example.com/index.php/news/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		$sessionData = array(
			'username' => $this->session->userdata('username'),
			'email' => $this->session->userdata('email'),
			'level' => $this->session->userdata('level'),
			'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);
		$this->load->view('header', $sessionData);
		$this->load->view('news');
		$this->load->view('footer');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/news.php */