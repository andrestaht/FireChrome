$(window).load(function() {
	startTime();
});

$(document).ready(function() {
	$('#change-password-link').click(function() {
		$('#change-password-form').slideDown();
	});

	var loadNewsCount = 0;
	var newsPerLoad = 12;

	loadNews(loadNewsCount, newsPerLoad);
	loadNewsCount++;

	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() == $(document).height()) {
			loadNews(loadNewsCount, newsPerLoad);
			loadNewsCount++;
		}
	});
});

var noMoreData = false;

function loadNews(loadNewsCount, newsPerLoad) {
	if (noMoreData === false) {
		$.ajax({
			type: "GET",
			url: 'http://localhost/FireChrome/FireChrome/news/get_news/' + loadNewsCount + '/' + newsPerLoad, //vaja ära muuta
			dataType: 'html',
			beforeSend: function() {
				$('.ajax-loader').show();
			},
			success: function(data) {
				if (data) {
					$('.ajax-loader').before(data);
				}
				else {
					noMoreData = true;
				}
			}
		});
		$('.ajax-loader').hide();
	}
	else {
		$('.ajax-message').html('Kõik uudised on laetud');
	}
}

function addComment(content, newsId) {
	var pathArray = window.location.pathname.split('/');
	var newsId= pathArray[pathArray.length - 1];
	var content = $('#comment-content').val();

	$.ajax({
		type: "GET",
		url: 'http://localhost/FireChrome/FireChrome/comment/add_comment/' + content + '/' + newsId, //vaja ära muuta
		dataType: 'html',
		success: function(data) {
			alert(data);
		}
	});
}

function startTime() {
	var today = new Date();

	var h = today.getHours();
	var m = today.getMinutes();
	var s = today.getSeconds();

	m = checkTime(m);
	s = checkTime(s);

	$('#current-time').html(h + ":" + m + ":" + s);

	t = setTimeout(function() {
		startTime()
	}, 500);
}

function checkTime(i) {
	if (i < 10) {
		i = "0" + i;
	}
	return i;
}