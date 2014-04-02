<?php
class News_model extends CI_Model {

	private $name = 'news';

	function __construct() {
		parent::__construct();
	}

	/**
	 * Add news function, which adds new news into database
	 * 
	 * @param array $data
	 * @return int $id
	 */
	public function add_news(array $data) {
		$this->db->insert($this->name, $data);

		return $this->db->insert_id();
	}

	/**
	 * Gets news data by id
	 * 
	 * @param int $id
	 * @return array $data
	 */
	public function get_news_by_id($id) {
		$this->db->select('*');
		$this->db->from($this->name);
		$this->db->join('user', 'user.id = ' . $this->name . '.user_id');
		$this->db->where($this->name . '.id', $id);

		$query = $this->db->get();
		$data = $query->row();

		return array(
			'id' => $id,
			'title' => $data->title,
			'author' => $data->username,
			'date' => $data->date,
			'content' => $data->content,
			'imgUrl' => $data->img_url,
			'isVisible' => $data->is_visible,
		);
	}

	/**
	 * Gets all news for home page
	 *
	 * @return array $data
	 */
	public function get_all_news() {
		$newsQuery = $this->db->get($this->name);

		return $newsQuery->result();
	}

	/**
	 * Gets news for home page
	 *
	 * @param int $postition
	 * @param int limit
	 * @param int $category
	 * @return array $data
	 */
	public function get_news($position, $limit, $category) {
		$this->db->order_by('id', 'desc');
		$this->db->limit($limit, ($position * $limit));

		if ($category != null) {
			$this->db->where('category', $category);
		}
		$newsQuery = $this->db->get($this->name);
	
		return $newsQuery->result();
	}

	/**
	 * Deletes news row by id
	 *
	 * @param int $id
	 */
	public function delete_news_by_id($id) {
		$this->db->where('id', $id);
		$this->db->delete($this->name);
	}

	/**
	 * Modifies news row by id
	 *
	 * @param int $id
	 * @param array $data
	 */
	public function modify_news_by_id($id, $data) {
		$this->db->where('id', $id);
		$this->db->update($this->name, $data);

		return true;
	}
	
	public function get_author($id){
		$this->db->select("username");
		$this->db->from($this->name);
		$this->db->join('user', 'user.id = ' . $this->name . '.user_id');
		$this->db->where("news.id", $id);
		$query = $this->db->get();
	
		return $query->row();
	}
}
