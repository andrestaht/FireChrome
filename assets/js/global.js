var noMoreData = false;

$(document).ready(function() {
	var newsPerLoad = 12;
	var categoryId;

	var categoryIdFromUrl = window.location.pathname.match(/main\/index\/(\d+)/);
	var currentUrl = window.location.protocol + "//" + window.location.host + "" + window.location.pathname;

	if (categoryIdFromUrl != null) {
		categoryId = categoryIdFromUrl[1];
	}
	else if (getBaseURL() == currentUrl) {
		categoryId = 1;
	}
	hideNews(newsPerLoad);

	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() == $(document).height()) {
			showNews(newsPerLoad);
		}
	});

	$('#menu-item-' + categoryId).parent().addClass('active');

	$('.menu-item a').click(function() {
		$('.menu-item.active').removeClass('active');
		$(this).parent().addClass('active');
	});

	$('#settings').click(function() {
		$(this).toggleClass('active');
	});

	$('#menu-button').click(function() {
		$(this).toggleClass('active');
	});
});

function hideNews(newsPerLoad) {
	var counter = 0;

	$('#news-feed .news').each(function() {
		if (counter >= newsPerLoad) {
			$(this).hide();
		}
		counter++;
	});
}

function showNews(newsPerLoad) {
	var counter = 0;

	$('#news-feed .news:hidden').each(function() {
		if (counter < newsPerLoad) {
			$(this).show();
		}
		counter++;
	});
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
					alert(data);
					updateComments(newsId);
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


function updateComments(newsId) {
	$.ajax({
		type: "GET",
		url: getBaseURL() + 'comment/load_comments/' + newsId,
		dataType: 'html',
		success: function(data) {
			$("#comments-feed").html(data);
		}
	})
}

function deleteComment(id, caller) {
	var pathArray = window.location.pathname.split('/');
	var newsId= pathArray[pathArray.length - 1];

	$.ajax({
		type: "GET",
		url: getBaseURL() + 'comment/delete_comment/' + id,
		dataType: 'html',
		success: function(data) {
			alert(data);

			$(caller).closest(".comment").hide();
		}
	});
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