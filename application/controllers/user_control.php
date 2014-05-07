<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class User_control extends MY_Controller {

	public function index() {
		$this->load->model("user_model");
		$this->load->model('category_model');

		$data = array(
			'users' => $this->user_model->get_all_users(),
			'confirmation' => "",
		);

		$header_data = array(
			'session_data' => $this->get_session_data(),
			'menu_data' => $this->category_model->get_all_categories(),
		);
		$this->load->view('header', $header_data);

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
		$this->load->model('category_model');

		$post = array();

		foreach ($this->input->post() as $id => $post_data) {
			if (preg_match("/\d+/", $id)) {
				$post[] = array(
					'id' => $id,
					'level' => $post_data['level'],
					'wants_newsletter' => $post_data['wants_newsletter'],
				);
			}
		}
		$this->user_model->update_user_levels_by_ids($post);

		$data = array(
			'users' => $this->user_model->get_all_users(),
			'confirmation' => "Andmed muudetud",
		);
		$header_data = array(
			'session_data' => $this->get_session_data(),
			'menu_data' => $this->category_model->get_all_categories(),
		);
		$this->load->view('header', $header_data);
		$this->load->view("user_control", $data);
		$this->load->view("footer");
	}

	public function delete_user($id) {
		$this->load->model("user_model");

		$this->user_model->delete_user_by_id($id);

		redirect('user_control', 'refresh');
	}

	public function remove_newsletter_subscription($user_id) {
		$this->load->model("user_model");

		$this->user_model->update_newsletter_subscription($user_id, null);

		redirect('main/settings', 'refresh');
	}

	public function add_newsletter_subscription($user_id) {
		$this->load->model("user_model");

		$this->user_model->update_newsletter_subscription($user_id, true);

		redirect('main/settings', 'refresh');
	}

	/**
	 * Changed password validation function.
	 */
	public function change_password_validation() {
		$this->load->library('form_validation');
	
		$this->form_validation->set_rules('password', 'Praegune parool', 'required|trim|xss_clean');
		$this->form_validation->set_rules('npassword', 'Uus parool', 'required|trim|xss_clean');
		$this->form_validation->set_rules('anpassword', 'Uus parool uuesti', 'required|trim|matches[npassword]|xss_clean');
	
		if ($this->form_validation->run()) {
			$this->load->model('user_model');
			$email = $this->session->userdata('email');
	
			if ($this->user_model->is_password_correct_by_email($email, $this->input->post('password'))) {
				if ($this->user_model->change_password_by_email($email, $this->input->post('npassword'))) {
					$this->session->set_flashdata('msg', 'Parool edukalt muudetud');
				}
				else {
					$this->session->set_flashdata('msg', 'Parooli ei muudetud');
				}
			}
			else {
				$this->session->set_flashdata('msg', 'Olemasolev parool oli sisestatud valesti');
			}
		}
		else{
			$this->session->set_flashdata('msg', 'Paroolid ei ühti');
		}
		redirect('main/settings', 'refresh');
	}
}

/* End of file user_control.php */
/* Location: ./application/controllers/user_control.php */
