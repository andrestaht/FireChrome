<?php

echo validation_errors();

echo form_open_multipart('news/add_news_validation', array('id' => 'add-news-form'));

echo "<p>Pealkiri: ";
echo form_input('title', $this->input->post('title'));
echo "</p>";

echo "<p>Sisu: ";
echo form_textarea('content', $this->input->post('content'));
echo "</p>";

echo "<p>Kategooria: ";
echo form_dropdown('category_id', $category_options);
echo "</p>";

echo "<p>Pilt: ";
echo form_upload('image', $this->input->post('image'));
echo "</p>";

echo "<p>Avalik: ";
echo form_checkbox('isVisible', $this->input->post('isVisible'));
echo "</p>";

echo "<p>";
echo form_submit('add-news-submit-btn', 'Lisa uudis');
echo "</p>";

echo form_close();

?>