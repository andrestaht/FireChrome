<div id="comments">
	<div id="add-comment">
		<textarea name="comment-content" id="comment-content" cols="80" rows="10"></textarea>
		<?php if ($level > 1) { ?>
			<a id="add-comment-btn" href="javascript:void(0);" onclick="addComment()">Lisa kommentaar</a>
		<?php } else { ?>
			<a class="login-btn" href="<?php echo base_url() . "login" ?>">Kommenteerimiseks logi sisse siit!</a>
		<?php } ?>
	</div>
	<div id="comments-feed">
		<div class="comment"></div>
	</div>
</div>