<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {

	private $sessionData = array();

	/**
	 * Index Page for news controller.
	 */
	public function index($id) {
		$this->sessionData = array(
			'user_id' => $this->session->userdata('user_id'),
			'username' => $this->session->userdata('username'),
			'email' => $this->session->userdata('email'),
			'level' => $this->session->userdata('level'),
			'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);
		$this->load->model('newsModel');

		$this->load->view('header', $this->sessionData);
		$this->load->view('news', $this->newsModel->getNewsById($id));
		$this->load->view('footer');
	}

	/**
	 * Add news function.
	 * 
	 * @param int $id
	 */
	public function addNews() {
		$this->sessionData = array(
			'user_id' => $this->session->userdata('user_id'),
			'username' => $this->session->userdata('username'),
			'email' => $this->session->userdata('email'),
			'level' => $this->session->userdata('level'),
			'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);
		$this->load->view('header', $this->sessionData);
		$this->load->view('addNews');
		$this->load->view('footer');
	}

	/**
	 * Added news validation function.
	 */
	public function addNewsValidation() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('title', 'Pealkiri', 'required|trim|is_unique[news.title]');
		$this->form_validation->set_rules('content', 'Sisu', 'required|trim');
		$this->form_validation->set_rules('image', 'Pilt');
		$this->form_validation->set_rules('isVisible', 'Avalik');

		if ($this->form_validation->run()) {
			$this->load->model('newsModel');

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
				$id = $this->newsModel->addNews($data);

				if (!empty($id)) {
					redirect('news/index/' . $id);
				}
			}
		}
		$this->addNews();
	}

	/**
	 * Delete news by id function.
	 * 
	 * @param int $id
	 */
	public function deleteNews($id) {
		$this->load->model('newsModel');

		$this->newsModel->deleteNewsById($id);

		redirect('main');
	}

	/**
	 * Modify news function.
	 * 
	 * @param int $id
	 */
	public function modifyNews($id) {
		$this->sessionData = array(
			'user_id' => $this->session->userdata('user_id'),
			'username' => $this->session->userdata('username'),
			'email' => $this->session->userdata('email'),
			'level' => $this->session->userdata('level'),
			'isLoggedIn' => $this->session->userdata('is_logged_in'),
		);
		$this->load->model('newsModel');

		$this->load->view('header', $this->sessionData);
		$this->load->view('modifyNews', $this->newsModel->getNewsById($id));
		$this->load->view('footer');
	}

	/**
	 * Modified news validation function.
	 */
	public function modifyNewsValidation($id) {
		$this->load->library('form_validation');
	
		$this->form_validation->set_rules('title', 'Pealkiri', 'required|trim|is_unique[news.title]');
		$this->form_validation->set_rules('content', 'Sisu', 'required|trim');
		$this->form_validation->set_rules('image', 'Pilt');
		$this->form_validation->set_rules('isVisible', 'Avalik');
	
		if ($this->form_validation->run()) {
			$this->load->model('newsModel');
	
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
				if ($this->newsModel->modifyNewsById($id, $data)) {
					redirect('news/index/' . $id);
				}
			}
		}
		$this->modifyNews();
	}
}

/* End of file main.php */
/* Location: ./application/controllers/news.php */