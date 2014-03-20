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
		$this->db->where('id', $id);

		$newsQuery = $this->db->get($this->name);
		$newsData = $newsQuery->row();

		$this->db->where('id', $newsData->user_id);

		$usersQuery = $this->db->get('user');
		$userData = $usersQuery->row();

		return array(
			'id' => $id,
			'title' => $newsData->title,
			'author' => $userData->username,
			'date' => $newsData->date,
			'content' => $newsData->content,
			'imgUrl' => $newsData->img_url,
			'isVisible' => $newsData->is_visible,
		);
	}

	/**
	 * Gets all news for home page
	 *
	 * @return array $data
	 */
	public function get_all_visible_news() {
		$this->db->where('is_visible', true);

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
}