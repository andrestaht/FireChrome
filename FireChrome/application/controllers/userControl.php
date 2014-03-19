<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );


class userControl extends CI_Controller {
	
	private $sessionData = array();
	
	public function index() {
		$this->sessionData = array(
				'user_id' => $this->session->userdata('user_id'),
				'username' => $this->session->userdata('username'),
				'email' => $this->session->userdata('email'),
				'level' => $this->session->userdata('level'),
				'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);
		
		$this->load->model ( "UsersModel" );
		$data ["users"] = $this->UsersModel->getAllUsers ();
		$data ["confirmation"] = "";
		$this->load->view('header', $this->sessionData);
		$this->load->view ( "UserControl", $data );
		$this->load->view ( "footer");
	}
	public function updateUsers() {
		$this->sessionData = array(
				'user_id' => $this->session->userdata('user_id'),
				'username' => $this->session->userdata('username'),
				'email' => $this->session->userdata('email'),
				'level' => $this->session->userdata('level'),
				'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);

		$this->load->model ( "UsersModel" );
		
		$newArray = array ();
		
		foreach ( $_POST as $username => $level ) {
			$newArray [] = array (
					'username' => $username,
					'level' => $level 
			);
		}
		$this->UsersModel->updateLevels ( $newArray );

		
		
		$this->load->model ( "UsersModel" );
		
		$data ["users"] = $this->UsersModel->getAllUsers ();
		$data ["confirmation"] = "Andmed muudetud";
		;
		$this->load->view('header', $this->sessionData);
		$this->load->view ( "UserControl", $data );
		$this->load->view ( "footer");
	}
}
