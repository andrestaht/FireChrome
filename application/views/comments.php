<div id="comments">
	<div id="comments-feed">
	<?php foreach ($comments as $comment) {
		echo "<div class='comment'>";
			if ($level > 1) {
				echo "<p class='user-actions'><a class='delete-button' href='javascript:void(0);' onclick='deleteComment(". $comment->id .", this)' title='Kustuta'></a></p>";
			}
			echo "<p class='comment-author'>" . $comment->username . "<span>" . date('d.m.Y H:i', strtotime(str_replace('-', '/', $comment->date))) . "</span></p>";
			echo "<p class='comment-content'>" . $comment->content . "</p>";
		echo "</div>";
	} ?>
	</div>
	<div id="add-comment">
		<textarea name="comment-content" id="comment-content" cols="0" rows="5"></textarea>
		<?php if (!empty($session_data['is_logged_in'])) { ?>
			<a class="button" id="add-comment-btn" href="javascript:void(0);" onclick="addComment()">Lisa kommentaar</a>
		<?php } else { ?>
			<a class="login-btn" href="<?php echo base_url() . "login" ?>">Kommenteerimiseks logi sisse siit!</a>
		<?php } ?>
		<?php if (!empty($session_data['is_logged_in'])) {
			require_once(APPPATH . 'libraries/Recaptchalib.php');
			echo recaptcha_get_html(RECAPTCHA_PUBLIC_KEY);
		} ?>
	</div>
</div>