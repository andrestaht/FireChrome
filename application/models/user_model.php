<?php
class User_model extends CI_Model {

	private $name = 'user';

	public function can_log_in() {
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));

		$this->db->cache_off();
		$query = $this->db->get($this->name);

		if ($query->num_rows() == 1) {
			return true;
		}
		return false;
	}

	public function add_user($key) {
		$this->db->where('key', $key);

		$this->db->cache_off();
		$tempUsersQuery = $this->db->get('temp_user');

		if ($tempUsersQuery) {
			$row = $tempUsersQuery->row();

			$data = array(
				'username' => $row->username,
				'email' => $row->email,
				'password' => $row->password,
				'level' => 1,
				'wants_newsletter' => $row->wants_newsletter,
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

		$this->db->cache_off();
		$query = $this->db->get($this->name);

		if ($query->num_rows() == 1) {
			return true;
		}
		return false;
	}

	public function is_password_correct_by_email($email, $password) {
		$this->db->where('email', $email);
		$this->db->where('password', md5($password));

		$this->db->cache_off();
		$query = $this->db->get($this->name);

		if ($query->num_rows() == 1) {
			return true;
		}
		return false;
	}

	public function get_user_data_by_email($email) {
		$this->db->where('email', $email);

		$this->db->cache_off();
		$query = $this->db->get($this->name);

		return $query->row();
	}

	public function get_all_users() {
		$this->db->select("*");

		$this->db->order_by('level', 'desc');
		$this->db->order_by('username', 'asc');

		$this->db->cache_off();
		$query = $this->db->get($this->name);

		return $query->result();
	}

	public function update_user_levels_by_ids($data) {
		$this->db->cache_off();

		foreach ($data as $row) {
			$this->db->where('id', $row['id']);

			$this->db->update(
				$this->name,
				array(
					'level' => $row['level'],
					'wants_newsletter' => $row['wants_newsletter'] == true ? 1 : null,
				)
			);
		}
		return true;
	}

	public function delete_user_by_id($id) {
		$this->db->cache_off();

		$this->db->delete($this->name, array('id' => $id));
	}

	public function check_if_user_wants_newsletter($id) {
		$this->db->select("wants_newsletter");

		$this->db->where('id', $id);

		$this->db->cache_off();
		$query = $this->db->get($this->name);
		$data = $query->row();

		if ($data->wants_newsletter != null) {
			return true;
		}
		return false;
	}

	public function update_newsletter_subscription($id, $value) {
		$this->db->where('id', $id);

		$this->db->update(
			$this->name,
			array(
				'wants_newsletter' => $value,
			)
		);
		return true;
	}

	public function get_all_users_with_newsletter_subscription() {
		$this->db->select("username, email");

		$this->db->where('wants_newsletter IS NOT NULL');

		$this->db->cache_off();
		$query = $this->db->get($this->name);

		return $query->result();
	}
}