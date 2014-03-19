$(document).ready(function() {
	$('#change-password-link').click(function() {
		$('#change-password-form').slideDown();
	});
});
function loadNews(baseUrl, url) {
	var date = $('#last-loaded-date').val();

	$.ajax({
		type: "json",
		url: baseUrl + url + date,
		beforeSend : function() {
			$('#load-news-btn').prop('disabled', true);
		},
		success: function(data) {
			$(jQuery.parseJSON(data)).each(function() {
				var html = "";

				html += '<div class="news">' + '<a href="' + baseUrl +  'news/index/' + this.id + '">';
				html += '<img src="' + this.imgUrl + '" alt="' + this.title + '" width="200px" height="200px" />';
				html += '<span class="news-title">' + this.title + '</span></a></div>';

				$('.news:last').after(html);
				$('#last-loaded-date').val(this.date)
			});
			$('#load-news-btn').prop('disabled', false);
		}
	});
}