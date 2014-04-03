<?php

echo "<p>";
echo "Otsingu tulemused sisestatud sõnale:";
echo "</p>";

foreach ($news_info as $row) {
    echo "<p>";
    ?>
    <a href="<?php echo base_url() . "news/index/" . $row['id']?>"><?php echo $row['title'] ?></a>
    <?php
    echo "</p>"; 
}
?>