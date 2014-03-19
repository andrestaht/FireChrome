<?php
class UsersModel extends CI_Model {
	private $name = 'users';
	public function canLogIn() {
		$this->db->where ( 'email', $this->input->post ( 'email' ) );
		$this->db->where ( 'password', md5 ( $this->input->post ( 'password' ) ) );
		
		$query = $this->db->get ( $this->name );
		
		if ($query->num_rows () == 1) {
			return true;
		}
		return false;
	}
	public function addUser($key) {
		$this->db->where ( 'key', $key );
		$tempUsersQuery = $this->db->get ( 'temp_users' );
		
		if ($tempUsersQuery) {
			$row = $tempUsersQuery->row ();
			
			$data = array (
					'username' => $row->username,
					'email' => $row->email,
					'password' => $row->password,
					'level' => 1 
			);
			$usersQuery = $this->db->insert ( $this->name, $data );
		}
		if ($usersQuery) {
			$this->db->where ( 'key', $key );
			$this->db->delete ( 'temp_users' );
			
			return $data;
		}
		return false;
	}
	public function changePasswordByEmail($email, $password) {
		$this->db->where ( 'email', $email );
		$this->db->update ( $this->name, array (
				'password' => md5 ( $password ) 
		) );
		return true;
	}
	public function doesEmailExists($email) {
		$this->db->where ( 'email', $email );
		$query = $this->db->get ( $this->name );
		
		if ($query->num_rows () == 1) {
			return true;
		}
		return false;
	}
	public function isPasswordCorrectByEmail($email, $password) {
		$this->db->where ( 'email', $email );
		$this->db->where ( 'password', md5 ( $password ) );
		
		$query = $this->db->get ( $this->name );
		
		if ($query->num_rows () == 1) {
			return true;
		}
		return false;
	}
	public function getUserDataByEmail($email) {
		$this->db->where ( 'email', $email );
		
		$query = $this->db->get ( $this->name );
		
		return $query->row ();
	}
	public function getAllUsers() {
		$query = $this->db->query ( "SELECT * FROM users" );
		return $query->result ();
	}
	public function updateLevels($updatedData) {
		$this->db->update_batch("users",$updatedData,"username");
		}

	}