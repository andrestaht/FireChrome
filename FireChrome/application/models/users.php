<?php
class Users extends CI_Model {

	private $name = 'users';

	private $validfields = array('id', 'username', 'password', 'email', 'level');

	public function canLogIn() {
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));

		$query = $this->db->get($this->name);

		if ($query->num_rows() == 1) {
			return true;
		}
		else {
			return false;
		}
	}

	public function addUser($key) {
		$this->db->where('key', $key);
		$tempUsersQuery = $this->db->get('temp_users');

		if ($tempUsersQuery) {
			$row = $tempUsersQuery->row();
			
			$data = array(
				'username' => $row->username,
				'email' => $row->email,
				'password' => $row->password,
				'level' => 1,
			);
			$usersQuery = $this->db->insert($this->name, $data);
		}
		if ($usersQuery) {
			$this->db->where('key', $key);
			$this->db->delete('temp_users');

			return $data;
		}
		else {
			return false;
		}
	}

	public function resetPasswordByEmail($email, $password) {
		$this->db->where('email', $email);
		$this->db->update(
			$this->name,
			array(
				'password' => md5($password),
			)
		);
		return true;
	}
}