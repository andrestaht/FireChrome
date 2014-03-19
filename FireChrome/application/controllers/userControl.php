<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class userControl extends CI_Controller {
	public function index() {
		$this->load->model ( "UsersModel" );
		$data ["users"] = $this->UsersModel->getAllUsers ();
		$data ["confirmation"] = "";
		$this->load->view ( "header", $data );
		$this->load->view ( "UserControl", $data );
		$this->load->view ( "footer", $data );
	}
	public function updateUsers() {
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
		$this->load->view ( "header", $data );
		$this->load->view ( "UserControl", $data );
		$this->load->view ( "footer", $data );
	}
}
