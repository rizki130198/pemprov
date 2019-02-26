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
$("#formubahspj").submit(function (event) {
	var data = new FormData($(this)[0]); 
	$.ajax({
		url: BASE_URL + '/spj/ubahform',
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

function Booking() {
	$("#switch").change(function() {
		if (this.checked) {
			$("#booking").val('booking');
		}else{
			$("#booking").val('pending');
		}
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
function jumlahharga() {
	var snack = parseFloat($("#snack").val()) * 19800;
	var makan = parseFloat($("#makan").val()) * 51700;
	var jwb = snack + makan;
	if (isNaN(snack)) {
		$('#total').val(makan);
	}else if(isNaN(makan)){
		$('#total').val(snack);
	}else{
		$('#total').val(jwb);
	}
}
// Pengguna 
$("#ubahjabatan").submit(function (event) {
	var data = new FormData($(this)[0]); 
	$.ajax({
		url: BASE_URL + '/pengguna/ubahjabatan',
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