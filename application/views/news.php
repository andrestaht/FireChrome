<div id="news">
	<h1 id="news-title"><?php echo $title ?></h1>
	<?php if ($session_data['level'] > 1) { ?>
        <p class="user-actions">            
            <a id="modify-news-btn" href="<?php echo base_url() . "news/modify_news/" . $id ?>" title="Muuda uudist"></a>
            <a class="delete-button" href="<?php echo base_url() . "news/delete_news/" . $id ?>" title="Kustuta uudis"></a>
        </p>
    <?php } ?>
	<p id="news-author">Postitas <?php echo $author ?><span><?php echo date('d.m.Y H:i', strtotime(str_replace('-', '/', $date))); ?></span></p>
	<div id="news-content">		
		<div id="news-image">
            <img src="<?php echo $imgUrl ?>" alt="<?php echo $title ?>"/>
        </div>
		<p><?php echo $content ?></p>
	</div>
</div>