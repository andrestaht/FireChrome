<?php
class TempUser_model extends CI_Model {

	private $name = 'temp_user';

	public function add_user($key) {
		$data = array(
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'email' => $this->input->post('email'),
			'key' => $key,
			'wants_newsletter' => $this->input->post('wants_newsletter') !== false ? 1 : null,
		);
		$this->db->cache_off();
		$query = $this->db->insert($this->name, $data);

		if ($query) {
			return true;
		}
		return false;
	}

	public function is_key_valid($key) {
		$this->db->where('key', $key);

		$this->db->cache_off();
		$query = $this->db->get($this->name);
		
		if ($query->num_rows() == 1) {
			return true;
		}
		return false;
	}
}