<?php
class User_model extends CI_Model {

	private $name = 'user';

	public function can_log_in() {
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));

		$query = $this->db->get($this->name);

		if ($query->num_rows() == 1) {
			return true;
		}
		return false;
	}

	public function add_user($key) {
		$this->db->where('key', $key);
		$tempUsersQuery = $this->db->get('temp_user');

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
			$this->db->delete('temp_user');

			return $data;
		}
		return false;
	}

	public function change_password_by_email($email, $password) {
		$this->db->where('email', $email);

		$this->db->update(
			$this->name,
			array(
				'password' => md5($password),
			)
		);
		return true;
	}

	public function does_email_exists($email) {
		$this->db->where('email', $email);
		$query = $this->db->get($this->name);

		if ($query->num_rows() == 1) {
			return true;
		}
		return false;
	}

	public function is_password_correct_by_email($email, $password) {
		$this->db->where('email', $email);
		$this->db->where('password', md5($password));

		$query = $this->db->get($this->name);

		if ($query->num_rows() == 1) {
			return true;
		}
		return false;
	}

	public function get_user_data_by_email($email) {
		$this->db->where('email', $email);

		$query = $this->db->get($this->name);

		return $query->row();
	}

	public function get_all_users() {
		$this->db->select("id,username, email, level");

		$this->db->order_by('level', 'desc');
		$this->db->order_by('username', 'asc');

		$query = $this->db->get($this->name);

		return $query->result();
	}

	public function update_user_levels_by_ids($data) {
 		$this->db->update_batch($this->name, $data, "id");
	}
}