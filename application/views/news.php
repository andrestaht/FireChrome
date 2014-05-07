<?php if ($session_data['level'] > 1) { ?>
<a id="delete-news-btn" href="<?php echo base_url() . "news/delete_news/" . $id ?>">Kustuta uudis</a>
<a id="modify-news-btn" href="<?php echo base_url() . "news/modify_news/" . $id ?>">Muuda uudist</a>
<?php } ?>
<div id="news">
	<span id="news-title"><?php echo $title ?></span>
	<div id="news-image">
		<img src="<?php echo $imgUrl ?>" alt="<?php echo $title ?>" width="400" height="400" />
	</div>
	<p id="news-author">Postitas <?php echo $author ?> - <?php echo $date ?></p>
	<div id="news-content">
		<p><?php echo $content ?></p>
	</div>
</div>