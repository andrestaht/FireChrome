var noMoreData = false;

$(window).load(function() {
	startTime();
});

$(document).ready(function() {
	$('body').removeClass('no-js');
	$('body').addClass('js');

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

function addComment() {
	var pathArray = window.location.pathname.split('/');
	var newsId= pathArray[pathArray.length - 1];
	var content = $('#comment-content').val();
	var captchaChallengeField = $('#recaptcha_challenge_field').val();
	var captchaResponseField = $('#recaptcha_response_field').val();

	if (content.replace(/\s/g, '') != '') {
		if (captchaResponseField.replace(/\s/g, '') != '') {
			$.ajax({
				type: "GET",
				url: getBaseURL() + 'comment/add_comment/' + content + '/' + newsId + '/' + captchaChallengeField + '/' + captchaResponseField,
				dataType: 'html',
				success: function(data) {
					$('#comment-content').val('');
			alert("Kommentaar lisatud.");
			updateComments(newsId);
		}
	});
}

function updateComments(newsId){
	$.ajax({
		type: "GET",
		url: getBaseURL() + 'comment/load_comments/' + newsId,
		dataType: 'html',
		success: function(data) {
			$("#comments-feed").html(data);
		}
	})
}

function deleteComment(Id,Caller){
	var pathArray = window.location.pathname.split('/');
	var newsId= pathArray[pathArray.length - 1];
	
	$.ajax({
		type: "GET",
		url: getBaseURL() + 'comment/delete_comment/' + Id,
		dataType: 'html',
		success: function(data) {
			alert(data);
			$(Caller).closest(".comment").hide();
				}
			});
		}
		else {
			alert("Captcha ei saa olla tühi!");
		}
	}
	else {
		alert("Kommentaar ei saa olla tühi!");
	}
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