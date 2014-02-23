<?php
class User extends CI_Model {

	private $name = 'users';

	private $validfields = array('id', 'username', 'password', 'email', 'level');

	function __construct() {
		parent::__construct();
	}

	function login($username, $password) {
		$this->db->select($this->validfields);
		$this->db->from($this->name);
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		$this->db->limit(1);

		$query = $this->db->get();

		if($query->num_rows() == 1) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	function register($username, $password, $email) {
		$this->db->insert(
			$this->name,
			array(
				'username' => $username,
				'password' => $password,
				'email' => $email,
				'level' => '1',
			)
		);
	}
}