var $alerts = $('#alerts');

function showSuccessAlert(message, time) {
	var $successAlert = $alerts.find('#alert-success');
	$successAlert.html(message);
	$successAlert.show();

	setTimeout(function() {
		$successAlert.hide();
	}, 3000);
}

function showErrorAlert(message, time) {
	var $errorAlert = $alerts.find('#alert-error');
	var timeInterval = 3000;
	if (time)
	{
		timeInterval = time;
	}
	$errorAlert.html(message);
	$errorAlert.show();

	setTimeout(function() {
		$errorAlert.hide();
	}, timeInterval);
}