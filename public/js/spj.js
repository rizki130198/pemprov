$("#formspj").submit(function (event) {
	var data = new FormData($(this)[0]); 
	$.ajax({
		url: BASE_URL + '/spj/action',
		type: "POST",
		data: data,
		contentType: false,
		cache: false,
		processData: false,
		headers: {'X-CSRF-TOKEN': CSRF},
		success: function (response) {
			if (response.code == 200) {
				$('#exampleModal2').modal('hide');
				location.reload();
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
function booking() {
	$("#booking").fadeToggle('fast',function() {
		$("#booking").removeAttr('disabled','disabled');
	})
}
function accForm(id) {
	$.ajax({
		url: BASE_URL + '/spj/ubah',
		type: "POST",
		data: {idpengajuan : id},
        headers: {'X-CSRF-TOKEN': CSRF},
		success: function (response) {
			if (response.code == 200) {
				$('#exampleModal2').modal('hide');
				location.reload();
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
}