<?php

echo validation_errors();

echo form_open_multipart('news/addNewsValidation', array('id' => 'add-news-form'));

echo "<p>Pealkiri: ";
echo form_input('title');
echo "</p>";

echo "<p>Sisu: ";
echo form_textarea('content');
echo "</p>";

echo "<p>Pilt: ";
echo form_upload('image');
echo "</p>";

echo "<p>Avalik: ";
echo form_checkbox('isVisible');
echo "</p>";

echo "<p>";
echo form_submit('add-news-submit-btn', 'Lisa uudis');
echo "</p>";

echo form_close();

?>