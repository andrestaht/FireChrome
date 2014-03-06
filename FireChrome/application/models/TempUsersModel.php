<?php
class TempUsersModel extends CI_Model {

	private $name = 'temp_users';

	public function addUser($key) {
		$data = array(
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'email' => $this->input->post('email'),
			'key' => $key,
		);
		$query = $this->db->insert($this->name, $data);

		if ($query) {
			return true;
		}
		return false;
	}

	public function isKeyValid($key) {
		$this->db->where('key', $key);
		
		$query = $this->db->get($this->name);
		
		if ($query->num_rows() == 1) {
			return true;
		}
		return false;
	}
}