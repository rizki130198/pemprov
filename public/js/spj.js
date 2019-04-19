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
				location.href = BASE_URL + '/spj';
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
$("#formverif").submit(function (event) {
	var data = new FormData($(this)[0]);
	$.ajax({
		url: BASE_URL + '/spj/updateform',
		type: "POST",
		data: data,
		contentType: false,
		cache: false,
		processData: false,
		headers: {'X-CSRF-TOKEN': CSRF},
		success: function (response) {
			if (response.code == 200) {
				$('#exampleModal2').modal('hide');
				location.href = BASE_URL + '/spj';
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
				location.href = BASE_URL + '/spj';
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
				location.href = BASE_URL + '/spj';
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
$("#tolakForm").submit(function (event) {
	var data = new FormData($(this)[0]); 
	$.ajax({
		url: BASE_URL + '/spj/tolak',
		type: "POST",
		data: data,
		contentType: false,
		cache: false,
		processData: false,
		headers: {'X-CSRF-TOKEN': CSRF},
		success: function (response) {
			if (response.code == 200) {
				location.href = BASE_URL + '/spj';
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
})
function Tolakverif(id) {
	$.ajax({
		url: BASE_URL + '/spj/tolakverif',
		type: "POST",
		data: {idpengajuan : id},
		headers: {'X-CSRF-TOKEN': CSRF},
		success: function (response) {
			if (response.code == 200) {
				location.href = BASE_URL + '/spj';
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
function kurangiSaldo(id) {
	$.ajax({
		url: BASE_URL + '/spj/kurangisaldo',
		type: "POST",
		data: {idpengajuan : id},
		headers: {'X-CSRF-TOKEN': CSRF},
		success: function (response) {
			if (response.code == 200) {
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
	var makan = parseFloat($("#makan").val()) * 47000;
	var jwb = snack + makan;
	if (isNaN(snack)) {
		$('#total').val(makan);
	}else if(isNaN(makan)){
		$('#total').val(snack);
	}else{
		$('#total').val(jwb);
	}
}
function hargastock() {
	var snack = parseFloat($("#snack").val());
	var makan = parseFloat($("#makan").val());
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