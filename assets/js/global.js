var noMoreData = false;

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
//	$(".login_button").click(function(e) {
//		e.preventDefault();
//		$(".popup").fadeToggle("fast");
//		$("#close_login_popup").click(function() { 
//		$(".popup, .overlay").hide(); 
//		}); 
//	});
});

function loadNews(loadNewsCount, newsPerLoad) {
	if (noMoreData === false) {
		$.ajax({
			type: "GET",
			url: getBaseURL() + 'news/get_news/' + loadNewsCount + '/' + newsPerLoad,
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
		url: getBaseURL() + 'comment/add_comment/' + content + '/' + newsId,
		dataType: 'html',
		success: function(data) {
			alert(data);
			$('#comment-content').val('');
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

function getBaseURL() {
	var url = location.href;
	var baseURL = url.substring(0, url.indexOf('/', 14));

	if (baseURL.indexOf('http://localhost') != -1) {
		var url = location.href;
		var pathname = location.pathname;
		var index1 = url.indexOf(pathname);
		var index2 = url.indexOf("/", index1 + 1);
		var baseLocalUrl = url.substr(0, index2);

		return baseLocalUrl + "/";
	}
	else {
		return baseURL + "/";
	}
}