$(window).load(function() {
	startTime();
});

$(document).ready(function() {
	$('#change-password-link').click(function() {
		$('#change-password-form').slideDown();
	});
});

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