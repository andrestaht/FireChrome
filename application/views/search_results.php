<?php
	if (!empty($search_string)) {
		echo "<p>Sisestasite: " . $search_string . "</p>";
	
		foreach ($data as $row) {
			if (!empty($row['is_visible']) || $session_data['level'] > 1) {
				echo '<div class="news"><a href="' . base_url() . 'news/index/' .  $row['id'] . '">';
				echo '<img src="' . $row['img_url'] . '" alt="' . $row['title'] . '" width="250" height="250" />';
				echo '<h1 class="news-title">' . $row['title'] . '</h1></a>';
			
				if (empty($row['is_visible'])) {
					echo '<h1 class="news-is-invisible">Uudis pole nähtav</h1>';
				}
				echo '</div>';
			}
		}
	}
	else {
		echo "<p>Te ei sisestanud midagi</p>";
	}
?>