<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class User_control extends MY_Controller {

	public function index() {
		$this->load->model("user_model");

		$data = array();

		$data["users"] = $this->user_model->get_all_users();
		$data["confirmation"] = "";

		$this->load->view('header', $this->get_session_data());

		if ($this->session->userdata('is_logged_in') && $this->user_has_access($this->admin)) {
			$this->load->view("user_control", $data);
		}
		else {
			$this->load->view('no_access');
		}
		$this->load->view("footer");
	}

	public function update_users() {
		$this->load->model("user_model");

		$post = array();
		$data = array();

		foreach ($this->input->post() as $id => $level) {
			$post[] = array(
				'id' => $id,
				'level' => $level,
			);
		}
		$this->user_model->update_user_levels_by_ids($post);

		$data["users"] = $this->user_model->get_all_users();
		$data["confirmation"] = "Andmed muudetud";

		$this->load->view('header', $this->get_session_data());
		$this->load->view("user_control", $data);
		$this->load->view("footer");
	}
	
	public function delete_user($id) {
		$this->load->model("user_model");
		
		$this->user_model->delete_user_by_id($id);
		
		redirect('user_control', 'refresh');
	}
}

/* End of file user_control.php */
/* Location: ./application/controllers/user_control.php */
