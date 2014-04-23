<?php
class Category_model extends CI_Model {

	private $name = 'category';

	function __construct() {
		parent::__construct();
	}

	public function get_all_categories() {
		$this->db->select('id, name');
		$this->db->from($this->name);

		$query = $this->db->get();
		
		return $query->result();
	}

	public function get_gategories_for_select() {
		$this->db->select('id, name');
		$this->db->from($this->name);
		$this->db->where('id != ', MAIN_PAGE_ID);
		$this->db->where('id != ', MOST_VIEWED_ID);

		$this->db->cache_off();
		$query = $this->db->get();
		$results = $query->result();

		$ret = array();

		foreach ($results as $row) {
			$ret[$row->id] = $row->name;
		}
		return $ret;
	}
}