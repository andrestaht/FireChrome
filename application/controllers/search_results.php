<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_results extends MY_Controller {
    
    public function index() {
        
        $this->load->view('header', $this->get_session_data());
        
        $this->load->model('search_results_model');
        $result_id = $this->search_results_model->search_news($this->input->post('s_result'));
        
        $this->load->model('news_model');
        $news_info = array();
        foreach ($result_id as $row) {
            array_push($news_info, $this->news_model->get_news_by_id($row));   
        }
        
		$this->load->view('search_results',  array('news_info' => $news_info));
        $this->load->view('footer');
	}
}