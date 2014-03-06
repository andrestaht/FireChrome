<?php
class NewsModel extends CI_Model {

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
	public function addNews(array $data) {
		$this->db->insert($this->name, $data);

		return $this->db->insert_id();
	}

	/**
	 * Gets news data by id
	 * 
	 * @param int $id
	 * @return array $data
	 */
	public function getNewsById($id) {
		$this->db->where('id', $id);

		$newsQuery = $this->db->get($this->name);
		$newsData = $newsQuery->row();

		$this->db->where('id', $newsData->user_id);

		$usersQuery = $this->db->get('users');
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
	public function getAllVisibleNews() {
		$this->db->where('is_visible', true);

		$newsQuery = $this->db->get($this->name);

		return $newsQuery->result();
	}

	/**
	 * Deletes news row by id
	 *
	 * @param int $id
	 */
	public function deleteNewsById($id) {
		$this->db->where('id', $id);
		$this->db->delete($this->name);
	}
}