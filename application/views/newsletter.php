<?php

echo validation_errors();

if (!empty($msg)) {
	echo "<div id='add-news-msg'>" . $msg . "</div>";
}

echo form_open_multipart('main/send_newsletter', array('id' => 'send-newsletter-form'));

echo "<p>Pealkiri: ";
echo form_input('title', $this->input->post('title'));
echo "</p>";

echo "<p>Sisu: ";
echo form_textarea('content', $this->input->post('content'));
echo "</p>";

echo "<p>";
echo form_submit('send-newsletter-submit-btn', 'Saada uudiskiri');
echo "</p>";

echo form_close();

?>