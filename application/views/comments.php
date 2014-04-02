<div id="comments">
	<div id="add-comment">
		<?php if (!empty($is_logged_in)) { ?>
			<a id="add-comment-btn" href="javascript:void(0);" onclick="addComment()">Lisa kommentaar</a>
		<?php } else { ?>
			<a class="login-btn" href="<?php echo base_url() . "login" ?>">Kommenteerimiseks logi sisse siit!</a>
		<?php } ?>
		<textarea name="comment-content" id="comment-content" cols="80" rows="10"></textarea>
		<?php if (!empty($is_logged_in)) {
			require_once(APPPATH . 'libraries/Recaptchalib.php');
			echo recaptcha_get_html(RECAPTCHA_PUBLIC_KEY);
		} ?>
	</div>
	<div id="comments-feed">
	<?php foreach ($comments as $comment){
		echo "<div class='comment'>";
			echo "<h1 class='comment-author'>Autor: ". $comment->username . " - " . $comment->date . "</h1>";
			echo "<p class='comment-content'>" . $comment->content . "</p>";
			if ($level > 1){
				echo "<a class='delete-comment-btn' href='javascript:void(0);' onclick='deleteComment(". $comment->id .", this)'>Kustuta</a>";}
		echo "</div>";} ?>
	</div>
</div>