<div id="news-feed">
	<?php
		if(!empty($msg)){
		echo "<div id='home-msg'>".$msg."</div>";}
		if (!empty($news_data)) {
			foreach ($news_data as $news) {
				if (!empty($news->is_visible) || $session_data['level'] > 1) {
					echo '<div class="news"><a href="' . base_url() . 'news/index/' . $news->id . '">';
					echo '<img src="' . $news->img_url . '" alt="' . $news->title . '" width="250" height="250" />';
					echo '<h1 class="news-title">' . $news->title . '</h1></a>';

					if (empty($news->is_visible)) {
						echo '<h1 class="news-is-invisible">Uudis pole nähtav</h1>';
					}
					echo '</div>';
				}
			}
		}
	?>
</div>