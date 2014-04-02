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
	
	public function get_comments_for_news_by_id($id){
		$this->db->select("comment.id,date,content,username");
		$this->db->from($this->name);
		$this->db->where('news_id',$id);
		$this->db->join('user', 'user.id = ' . $this->name . '.user_id');
		$this->db->order_by('date','asc');
		$query = $this->db->get();
		
		return $query->result();
		
	}
	
	public function delete_comment_by_id($id){
		$this->db->delete($this->name,array('id' => $id));
	}
}