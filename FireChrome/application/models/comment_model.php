<?php
class Comment_model extends CI_Model {

	private $name = 'comment';

	function __construct() {
		parent::__construct();
	}

	/**
	 * Add comment function, which adds new comment into database
	 * 
	 * @param array $data
	 * @return int $id
	 */
	public function insert(array $data) {
		$this->db->insert($this->name, $data);

		return $this->db->insert_id();
	}
}