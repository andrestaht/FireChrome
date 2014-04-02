<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends MY_Controller {

	/**
	 * Index Page for news controller.
	 */
	public function index($id) {
		$this->load->model('news_model');

		$this->load->view('header', $this->get_session_data());
		$this->load->view('news', $this->news_model->get_news_by_id($id));
		$this->load->view('comments', $this->get_session_data());
		$this->load->view('footer');
	}

	public function add_comment($content, $news_id, $recaptcha_challenge_field, $recaptcha_response_field) {
		require_once(APPPATH . 'libraries/Recaptchalib.php');

		$this->load->model('comment_model');
		$this->load->model('news_to_comment_model');

		$response = recaptcha_check_answer(RECAPTCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $recaptcha_challenge_field, $recaptcha_response_field);

		if ($response->is_valid) {
			$session_data = $this->get_session_data();
	
			$comment_data = array(
				'user_id' => $session_data['user_id'],
				'content' => $content,
			);
			$comment_id = $this->comment_model->insert($comment_data);
	
			$news_to_comment_data = array(
				'news_id' => $news_id,
				'comment_id' => $comment_id,
			);
			$news_to_comment_id = $this->news_to_comment_model->insert($news_to_comment_data);
	
			if (!empty($news_to_comment_id)) {
				echo "Kommentaar lisatud!";
			}
			else {
				echo "Kommentaari ei lisatud!";
			}
		}
		else {
			echo "Captcha oli vale!";
		}
	}
}