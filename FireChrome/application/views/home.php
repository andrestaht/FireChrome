<?php if ($level > 1) { ?>
<a id="add-news-btn" href="<?php echo base_url() . "news/addNews" ?>">Lisa uudis</a>
<?php } ?>
<div id="news-feed">
	<?php foreach ($news as $k => $rows) { ?>
	<div class="news">
		<a href="<?php echo base_url() . "news/index/" . $rows['id'] ?>">
			<img src="<?php echo $rows['imgUrl'] ?>" alt="<?php echo $rows['title'] ?>" width="200px" height="200px" />
			<span class="news-title"><?php echo $rows['title'] ?></span>
		</a>
	</div>
	<div class="loading"></div>
	<?php } ?>
</div>
<input id="last-loaded-date" type="hidden" value="<?php echo $rows['date']; ?>" />
<input id="load-news-btn" type="button" onclick="loadNews('<?php echo base_url(); ?>', 'news/loadNews/');" value="Lae veel uudiseid" />