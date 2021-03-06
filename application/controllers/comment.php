<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends MY_Controller {

	/**
	 * Index Page for news controller.
	 */
	public function index($id) {
		$this->load->model("user_model");
		$this->load->model('news_model');
		$this->load->model('category_model');

		$session_data = $this->get_session_data();
		
		$data = array(
			'session_data' => $session_data,
			'menu_data' => $this->category_model->get_all_categories(),
			'wants_newsletter' => $this->user_model->check_if_user_wants_newsletter($session_data['user_id']),
		);
		$this->load->view('header', $data);
		$this->load->view('news', $this->news_model->get_news_by_id($id));
		$this->load->view('comments', $this->get_session_data());
		$this->load->view('footer');
	}

	public function add_comment($content, $news_id, $recaptcha_challenge_field, $recaptcha_response_field) {
		require_once(APPPATH . 'libraries/Recaptchalib.php');

		$this->load->model('comment_model');
		$this->load->model('news_model');
		$this->load->helper("date");

		$response = recaptcha_check_answer(RECAPTCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $recaptcha_challenge_field, $recaptcha_response_field);

		if ($response->is_valid) {
			$session_data = $this->get_session_data();
	
			$comment_data = array(
				'user_id' => $session_data['user_id'],
				'news_id' => $news_id,
				'content' => $content,
			);
			$this->comment_model->insert($comment_data);
			echo "Kommentaar lisatud.";
		}
		else{
			echo "Captcha vale.";
		}
	}
	
	public function load_comments($id) {
		$this->load->model('comment_model');

		$comments = $this->comment_model->get_comments_for_news_by_id($id);

		foreach ($comments as $comment) {
			echo "<div class='comment'>";
			echo "<span class='comment-author'>Autor: " . $comment->username . " - " . $comment->date . "</span>";
			echo "<p class='comment-content'>" . $comment->content . "</p>";

			if ($this->user_has_access(5)) {
				echo "<a class='delete-comment-btn' href='javascript:void(0);' onclick='deleteComment(". $comment->id . ", this)'>Kustuta</a>";
			}
			echo "</div>";
		}
	}
	
	public function delete_comment($id) {
		$this->load->model('comment_model');

		$this->comment_model->delete_comment_by_id($id);

		echo "kommentaar kustutatud";
	}
}