<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	private $sessionData = array();
	protected $user=1;
	protected $editor=5;
	protected $admin=10;

	function __construct() {
		parent::__construct();
		$this->sessionData = array(
				'user_id' => $this->session->userdata('user_id'),
				'username' => $this->session->userdata('username'),
				'email' => $this->session->userdata('email'),
				'level' => $this->session->userdata('level'),
				'isLoggedIn' => $this->session->userdata('is_logged_in'),);
	}
	public function get_session_data(){
		return $this->sessionData;
	}
	public function user_has_access($level){
		return $this->sessionData['level']>=$level;
	
	}
	
// 	public function get_user_id() {
// 		return $this->sessionData['user_id'];
// 	}
// 	public function get_username(){
// 		return $this->sessionData['username'];
// 	}
// 	public function get_email(){
// 		return $this->sessionData['email'];
// 	}
// 	public function get_level(){
// 		return $this->sessionData['level'];
// 	}
// 	public function is_logged_in(){
// 		return $this->sessionData['isLoggedIn'];
// 	}

}

/* End of file MY_controller.php */
/* Location: ./application/libraries/MY_controller.php */