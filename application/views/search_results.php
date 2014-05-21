<?php
	if (!empty($search_string)) {
		if (!empty($data)) {
			foreach ($data as $row) {
				if (!empty($row['is_visible']) || $session_data['level'] > 1) {
					echo '<div class="news"><div class="category">' . $row['category_name'] . '</div><a href="' . base_url() . 'news/index/' . $row['id'] . '">';
					echo '<img src="' . $row['img_url'] . '" alt="' . $row['title'] . '" width="250" height="250" />';
					echo '<span class="news-title">' . $row['title'] . '</span>';
					echo '<span class="news-content">' . substr($row['content'], 0, 200) . '...</span></a>';

					if (empty($row['is_visible'])) {
						echo '<span class="news-is-invisible">Uudis pole nähtav</span>';
					}
					echo '</div>';
				}
			}
		}
		else {
			echo "<p class='no-results'>Teie otsingule ei vasta ühtegi tulemust</p>";
		}
	}
	else {
		echo "<p class='no-results'>Te ei sisestanud midagi</p>";
	}
?>