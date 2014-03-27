<?php

echo validation_errors();

echo form_open_multipart('news/modify_news_validation/' . $id, array('id' => 'modify-news-form'));

echo "<p>Pealkiri: ";
echo form_input('title', $title);
echo "</p>";

echo "<p>Sisu: ";
echo form_textarea('content', $content);
echo "</p>";

echo "<p>Pilt: ";
echo form_upload('image');
echo "</p>";

echo "<p>Avalik: ";
echo form_checkbox('isVisible', $isVisible);
echo "</p>";

echo "<p>";
echo form_submit('modify-news-submit-btn', 'Muuda uudist');
echo "</p>";

echo form_close();

?>