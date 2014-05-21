<div id="news-feed">
	<?php
		if(!empty($msg)){
		echo "<div id='home-msg'>" . $msg . "</div>";}
		if (!empty($news_data)) {
			foreach ($news_data as $news) {
				if (!empty($news->is_visible) || $session_data['level'] > 1) {
					echo '<div class="news"><div class="category">' . $news->category_name . '</div><a href="' . base_url() . 'news/index/' . $news->id . '">';
					echo '<img src="' . $news->img_url . '" alt="' . $news->title . '" width="250" height="250" />';
					echo '<h2 class="news-title">' . $news->title . '</h2>';
					echo '<p class="news-content">' . substr($news->content, 0, 150) .'...</p></a>';

					if (empty($news->is_visible)) {
						echo '<span class="news-is-invisible">Uudis pole nähtav</span>';
					}
					echo '</div>';
				}
			}
		}
	?>
</div>