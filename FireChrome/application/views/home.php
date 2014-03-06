<?php if ($level > 1) { ?>
<a id="add-news-btn" href="<?php echo base_url() . "news/addNews" ?>">Lisa uudis</a>
<?php } ?>
<?php foreach ($news as $rows) { ?>
<a class="news" href="<?php echo base_url() . "news/index/" . $rows->id ?>"><?php echo $rows->title ?></a>
<?php } ?>