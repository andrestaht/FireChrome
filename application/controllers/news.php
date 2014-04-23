<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MY_Controller {

	/**
	 * Index Page for news controller.
	 */
	public function index($id) {
		$this->load->model('news_model');
		$this->load->model('comment_model');
		$this->load->model('category_model');

		$data = array(
			'session_data' => $this->get_session_data(),
			'menu_data' => $this->category_model->get_all_categories(),
		);
		$this->load->view('header', $data);
		$this->load->view('news', $this->news_model->get_news_by_id($id));
		
		$data["comments"] = $this->comment_model->get_comments_for_news_by_id($id);
		$this->load->view('comments', array_merge($this->get_session_data(), $data));
		
		$this->load->view('footer');
	}

	/**
	 * Add news function.
	 * 
	 * @param int $id
	 */
	public function add_news() {
		$this->load->model('category_model');

		$data = array(
			'session_data' => $this->get_session_data(),
			'menu_data' => $this->category_model->get_all_categories(),
		);
		$this->load->view('header', $data);

		if ($this->session->userdata('is_logged_in') && $this->user_has_access($this->editor)) {
			$this->load->view('add_news', array('category_options' => $this->category_model->get_gategories_for_select()));
		}
		else {
			$this->load->view('no_access');
		}
		$this->load->view('footer');
	}

	/**
	 * Added news validation function.
	 */
	public function add_news_validation() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Pealkiri', 'required|trim|is_unique[news.title]|xss_clean');
		$this->form_validation->set_rules('content', 'Sisu', 'required|trim|xss_clean');
		$this->form_validation->set_rules('image', 'Pilt');
		$this->form_validation->set_rules('isVisible', 'Avalik');

		if ($this->form_validation->run()) {
			$this->load->model('news_model');

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite'] = true;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('image')) {
				echo "Faili ei suudetud üles laadida!";
			}
			else {
				$uploadData = $this->upload->data();
				$uploadPath = preg_replace("/[^\w]+/", "", $config['upload_path']);

				$data = array(
					'user_id' => $this->session->userdata('user_id'),
					'category_id' => $this->input->post('category_id'),
					'title' => $this->input->post('title'),
					'content' => $this->input->post('content'),
					'img_url' => base_url() . $uploadPath . "/" . $uploadData['orig_name'],
					'is_visible' => $this->input->post('isVisible') !== false ? 1 : null,
				);
				$id = $this->news_model->add_news($data);

				if (!empty($id)) {
					$this->db->cache_delete_all();

					redirect('news/index/' . $id);
				}
			}
		}
		$this->add_news();
	}

	/**
	 * Delete news by id function.
	 * 
	 * @param int $id
	 */
	public function delete_news($id) {
		if ($this->session->userdata('is_logged_in') && $this->user_has_access($this->editor)) {
			$this->load->model('news_model');
			$this->news_model->delete_news_by_id($id);

			$this->db->cache_delete_all();

			redirect('main');
		}
		else {
			$this->load->model('category_model');

			$data = array(
				'session_data' => $this->get_session_data(),
				'menu_data' => $this->category_model->get_all_categories(),
			);
			$this->load->view('header', $data);
			$this->load->view('no_access');
			$this->load->view('footer');
		}
	}

	/**
	 * Modify news function.
	 * 
	 * @param int $id
	 */
	public function modify_news($id) {
		$this->load->model('news_model');
		$this->load->model('category_model');

		$data = array(
			'session_data' => $this->get_session_data(),
			'menu_data' => $this->category_model->get_all_categories(),
		);
		$this->load->view('header', $data);

		if ($this->session->userdata('is_logged_in') && $this->user_has_access($this->editor)) {
			$this->load->view('modify_news', array_merge($this->news_model->get_news_by_id($id), array('category_options' => $this->category_model->get_gategories_for_select())));
		}
		else {
			$this->load->view('no_access');
		}
		$this->load->view('footer');
	}

	/**
	 * Modified news validation function.
	 */
	public function modify_news_validation($id) {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Pealkiri', 'required|trim|xss_clean');
		$this->form_validation->set_rules('content', 'Sisu', 'required|trim|xss_clean');
		$this->form_validation->set_rules('image', 'Pilt');
		$this->form_validation->set_rules('isVisible', 'Avalik');

		if ($this->form_validation->run()) {
			$this->load->model('news_model');

			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['overwrite'] = true;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('image')) {
				echo "Faili ei suudetud üles laadida!";
			}
			else {
				$uploadData = $this->upload->data();
				$uploadPath = preg_replace("/[^\w]+/", "", $config['upload_path']);

				$data = array(
					'user_id' => $this->session->userdata('user_id'),
					'title' => $this->input->post('title'),
					'content' => $this->input->post('content'),
					'img_url' => base_url() . $uploadPath . "/" . $uploadData['orig_name'],
					'is_visible' => $this->input->post('isVisible') !== false ? 1 : null,
				);
				if ($this->news_model->modify_news_by_id($id, $data)) {
					$this->db->cache_delete_all();

					redirect('news/index/' . $id);
				}
			}
		}
		$this->modify_news($id);
	}

	/**
	 * Gets news for main page
	 */
	public function get_news($position, $limit, $category = null) {
		$this->load->model('news_model');

		$results = $this->news_model->get_news($position, $limit, $category);
		$session_data = $this->get_session_data();

		if (!empty($results)) {
			foreach ($results as $result) {
				if (!empty($result->is_visible) || $session_data['level'] > 1) {
					echo '<div class="news"><a href="' . base_url() . 'news/index/' . $result->id . '">';
					echo '<img src="' . $result->img_url . '" alt="' . $result->title . '" width="250" height="250" />';
					echo '<h1 class="news-title">' . $result->title . '</h1></a>';

					if (empty($result->is_visible)) {
						echo '<h1 class="news-is-invisible">Uudis pole nähtav</h1>';
					}
					echo '</div>';
				}
			}
		}
	}
}

/* End of file main.php */
/* Location: ./application/controllers/news.php */