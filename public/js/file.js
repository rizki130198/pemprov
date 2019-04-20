$(function() {
	setInterval(function(){

        showFile();

    }, 10000);
});
$("#Formuploadfile").submit(function (event) {
	var data = new FormData($(this)[0]);
	$.ajax({
		url: BASE_URL + '/files/uploadfile',
		type: "POST",
        timeout: 5000,
		data: data,
		contentType: false,
		cache: false,
		processData: false,
		headers: {'X-CSRF-TOKEN': CSRF},
		success: function (response) {
			if (response.code == 200) {
				$("#Formuploadfile")[0].reset();
				$('#datafile').html(response.html);
			} else {
				$('#errorMessageModal').modal('show');
				$('#errorMessageModal #errors').html(''+response.message);
			}
		},
		error: function () {
			$('#errorMessageModal').modal('show');
			$('#errorMessageModal #errors').html(''+response.message);
		}
	});
	return false;
});
function showFile() {
	$.ajax({
		url: BASE_URL + '/files/getFile',
		type: "POST",
        timeout: 5000,
		contentType: false,
		cache: false,
		processData: false,
		headers: {'X-CSRF-TOKEN': CSRF},
		success: function (response) {
			if (response.code == 200) {
				$('#datafile').html(response.html);
			} else {
				$('#errorMessageModal').modal('show');
				$('#errorMessageModal #errors').html(''+response.message);
			}
		},
		error: function () {
			$('#errorMessageModal').modal('show');
			$('#errorMessageModal #errors').html(''+response.message);
		}
	});
	return false;
}