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
	public function getVisibleNews($start = null) {
		$this->load->model('usersModel');

		$this->db->where('is_visible', true);
		$this->db->order_by('date', 'DESC');

		if ($start != null) {
			$this->db->where('date < ', $start);
		}
		$this->db->limit('1');

		$newsQuery = $this->db->get($this->name);
		$rows = $newsQuery->result();

		$data = array();

		foreach ($rows as $row) {
			$data[] = array(
				'id' => $row->id,
				'title' => $row->title,
				'author' => $this->usersModel->getAuthorById($row->user_id),
				'date' => $row->date,
				'content' => $row->content,
				'imgUrl' => $row->img_url,
				'isVisible' => $row->is_visible,
			);
		}
		return $data;
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

	/**
	 * Modifies news row by id
	 *
	 * @param int $id
	 * @param array $data
	 */
	public function modifyNewsById($id, $data) {
		$this->db->where('id', $id);
		$this->db->update($this->name, $data);

		return true;
	}
}