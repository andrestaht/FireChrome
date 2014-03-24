<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MY_Controller {

	/**
	 * Index Page for news controller.
	 */
	public function index($id) {
		$this->load->model('news_model');

		$this->load->view('header', $this->get_session_data());
		$this->load->view('news', $this->news_model->get_news_by_id($id));
		$this->load->view('footer');
	}

	/**
	 * Add news function.
	 * 
	 * @param int $id
	 */
	public function add_news() {
		$this->load->view('header', $this->get_session_data());

		if ($this->session->userdata('is_logged_in') && $this->user_has_access(5)) {
			$this->load->view('add_news');
		}
		else {
			$data["logged_in"] = ($this->session->userdata('is_logged_in'));

			$this->load->view('no_access', $data);
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

			$this->load->library('upload', $config);
			$this->upload->overwrite = true;

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
				$id = $this->news_model->add_news($data);

				if (!empty($id)) {
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
		if ($this->session->userdata('is_logged_in') && $this->user_has_access(5)) {
			$this->load->model('news_model');
			$this->news_model->delete_news_by_id($id);

			redirect('main');
		}
		else {
			$data["logged_in"]= ( $this->session->userdata('is_logged_in'));

			$this->load->view('header', $this->get_session_data());
			$this->load->view('no_access', $data);
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

		$this->load->view('header', $this->get_session_data());

		if ($this->session->userdata('is_logged_in') && $this->user_has_access(5)) {
			$this->load->view('modify_news', $this->news_model->get_news_by_id($id));
		}
		else {
			$data["logged_in"] = ($this->session->userdata('is_logged_in'));
			$this->load->view('no_access', $data);
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

			$this->load->library('upload', $config);
			$this->upload->overwrite = true;

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
					redirect('news/index/' . $id);
				}
			}
		}
		$this->modify_news($id);
	}
}

/* End of file main.php */
/* Location: ./application/controllers/news.php */