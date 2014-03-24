<?php if ($level > 1) { ?>
<a id="add-news-btn" href="<?php echo base_url() . "news/add_news" ?>">Lisa uudis</a>
<?php } ?>
<div id="news-feed">
	<?php foreach ($news as $rows) { ?>
		<?php if ($rows->is_visible || $level > 1) { ?>
			<div class="news">
				<a href="<?php echo base_url() . "news/index/" . $rows->id ?>">
					<img src="<?php echo $rows->img_url ?>" alt="<?php echo $rows->title ?>" />
					<span class="news-title"><?php echo $rows->title ?></span>
				</a>
				<?php if (!$rows->is_visible) { ?>
					<h1>Uudis pole nähtav</h1>
				<?php } ?>
			</div>
		<?php } ?>
	<?php } ?>
</div>