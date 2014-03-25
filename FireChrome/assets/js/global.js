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

function loadNews(loadNewsCount, newsPerLoad) {
	$.ajax({
		type: "GET",
		url: 'http://localhost/FireChrome/FireChrome/news/get_news/' + loadNewsCount + '/' + newsPerLoad, //vaja ära muuta
		dataType: 'html',
		success: function(data) {
			$('#news-feed').append(data);
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

	document.getElementById('current-time').innerHTML = h + ":" + m + ":" + s;

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