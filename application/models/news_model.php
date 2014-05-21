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

		$this->db->where('id', $id);
		$this->db->update($this->name, array('view_count' => $data->view_count + 1));

		return array(
			'id' => $id,
			'category_id' => $data->category_id,
			'title' => $data->title,
			'author' => $data->username,
			'date' => $data->date,
			'content' => $data->content,
			'imgUrl' => $data->img_url,
			'view_count' => $data->view_count,
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
	 * @param int $category_id
	 * @return array $data
	 */
	public function get_news($category_id) {
		$this->db->select($this->name . '.*, category.id AS category_id, category.name AS category_name');

		if ($category_id != null) {
			if ($category_id == MOST_VIEWED_ID) {
				$this->db->order_by('view_count desc, ' . $this->name . '.id desc');
			}
			elseif ($category_id != MAIN_PAGE_ID) {
				$this->db->order_by($this->name . '.id', 'desc');
				$this->db->where('category_id', $category_id);
			}
			else {
				$this->db->order_by($this->name . '.id', 'desc');
			}
		}
		$this->db->join('category', 'category.id = ' . $this->name . '.category_id');
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

	/**
	 * Gets news author by id
	 *
	 * @param int $id
	 * @param array $data
	 */
	public function get_author($id) {
		$this->db->select('username');
		$this->db->from($this->name);

		$this->db->join('user', 'user.id = ' . $this->name . '.user_id');
		$this->db->where($this->name . 'id', $id);

		$query = $this->db->get();
	
		return $query->row();
	}

	/**
	 * Funktsioon, mis otsib andmebaasist etteantud sõne järgi tulemusi.
	 * Tagastab uudise id ja pealkirjade listi.
	 */
	public function search_news($string) {
		if (!empty($string)) {
			$this->db->select($this->name . '.*, category.id AS category_id, category.name AS category_name');
			$this->db->from($this->name);
			$this->db->like('title', $string);
			$this->db->or_like('content', $string);
			$this->db->join('category', 'category.id = ' . $this->name . '.category_id');

			$query = $this->db->get();
			$results = $query->result();

			$ret = array();

			foreach ($results as $row) {
				$ret[] = array(
					'id' => $row->id,
					'title' => $row->title,
					'img_url' => $row->img_url,
					'category_name' => $row->category_name,
					'content' => $row->content,
					'is_visible' => $row->is_visible,
				);
			}
			return $ret;
		}
	}
}
