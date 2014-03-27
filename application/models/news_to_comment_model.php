<?php
class News_to_comment_model extends CI_Model {

	private $name = 'news_to_comment';

	function __construct() {
		parent::__construct();
	}

	/**
	 * Add comment and news id function, which adds comment_id and news_id into database
	 * 
	 * @param array $data
	 * @return int $id
	 */
	public function insert(array $data) {
		$this->db->insert($this->name, $data);

		return $this->db->insert_id();
	}
}