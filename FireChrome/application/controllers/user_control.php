<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );


class User_control extends CI_Controller {
	
	private $sessionData = array();
	
	public function index() {
		$this->sessionData = array(
				'user_id' => $this->session->userdata('user_id'),
				'username' => $this->session->userdata('username'),
				'email' => $this->session->userdata('email'),
				'level' => $this->session->userdata('level'),
				'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);
		
		$this->load->model ( "user_model" );
		$data ["users"] = $this->user_model->get_all_users ();
		$data ["confirmation"] = "";
		$this->load->view('header', $this->sessionData);
		$this->load->view ( "user_control", $data );
		$this->load->view ( "footer");
	}
	public function update_users() {
		$this->sessionData = array(
				'user_id' => $this->session->userdata('user_id'),
				'username' => $this->session->userdata('username'),
				'email' => $this->session->userdata('email'),
				'level' => $this->session->userdata('level'),
				'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);

		$this->load->model ( "user_model" );
		
		$newArray = array ();
		
		foreach ( $_POST as $username => $level ) {
			$newArray [] = array (
					'username' => $username,
					'level' => $level 
			);
		}
		$this->user_model->update_user_levels ( $newArray );

		
		
		$this->load->model ( "user_model" );
		
		$data ["users"] = $this->user_model->get_all_users ();
		$data ["confirmation"] = "Andmed muudetud";
		;
		$this->load->view('header', $this->sessionData);
		$this->load->view ( "user_control", $data );
		$this->load->view ( "footer");
	}
}

/* End of file user_control.php */
/* Location: ./application/controllers/user_control.php */
