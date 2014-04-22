<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_results extends MY_Controller {

	public function index() {
		$this->load->model('news_model');
		$this->load->model('category_model');

		$data = array(
			'session_data' => $this->get_session_data(),
			'menu_data' => $this->category_model->get_all_categories(),
		);
		$search_string = $this->input->post('s_result');

		$this->load->view('header', $data);
		$this->load->view('search_results', array('search_string' => $search_string, 'data' => $this->news_model->search_news($search_string)));
		$this->load->view('footer');
	}
}