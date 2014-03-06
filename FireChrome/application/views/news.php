<?php if ($level == 5) { ?>
<a id="delete-news-btn" href="<?php echo base_url() . "news/deleteNews/" . $id ?>">Kustuta uudis</a>
<?php } ?>
<h1><?php echo $title ?></h1>
<p>Postitas <?php echo $author ?> - <?php echo $date ?></p>
<p><?php echo $content ?></p>
<img src="<?php echo $imgUrl ?>" alt="<?php echo $title ?>" />