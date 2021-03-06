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
	BootstrapDialog.show({
		title: 'Ubah data',
		message: 'Apa Anda Yakin Ingin Verifikasi Data ini ?',
		buttons: [{
			label: "Ya , Saya Yakin",
			cssClass: 'btn-danger',
			action: function(dialog) {
				$.ajax({
					url: BASE_URL + '/spj/ubah',
					type: "POST",
					data: {idpengajuan : id},
					headers: {'X-CSRF-TOKEN': CSRF},
					success: function (response) {
						dialog.close();
						if (response.code == 200) {
							location.href = BASE_URL + '/spj';
						} else {
							$('#errorMessageModal').modal('show');
							$('#errorMessageModal #errors').html(''+response.message);
						}
					},
					error: function () {
						dialog.close();
						$('#errorMessageModal').modal('show');
						$('#errorMessageModal #errors').html(''+response.message);
					}
				});
			}
		}, {
			label: 'Tidak',
			action: function(dialog) {
				dialog.close();
			}
		}]
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
	BootstrapDialog.show({
		title: 'Tolak data',
		message: 'Apa Anda Yakin Ingin Tolak Data ini ?',
		buttons: [{
			label: "Ya , Saya Yakin",
			cssClass: 'btn-primary',
			action: function(dialog) {
				$.ajax({
					url: BASE_URL + '/spj/tolakverif',
					type: "POST",
					data: {idpengajuan : id},
					headers: {'X-CSRF-TOKEN': CSRF},
					success: function (response) {
						dialog.close();
						if (response.code == 200) {
							location.href = BASE_URL + '/spj';
						} else {
							$('#errorMessageModal').modal('show');
							$('#errorMessageModal #errors').html(''+response.message);
						}
					},
					error: function () {
						dialog.close();
						$('#errorMessageModal').modal('show');
						$('#errorMessageModal #errors').html(''+response.message);
					}
				});
			}
		}, {
			label: 'Tidak',
			cssClass: 'btn-secondary',
			action: function(dialog) {
				dialog.close();
			}
		}]
	});
}
function kurangiSaldo(id) {
	BootstrapDialog.show({
		title: 'Data Selesai',
		message: 'Apa Anda Yakin Ingin Selesaikan data ini ?',
		buttons: [{
			label: "Ya , Saya Yakin",
			cssClass: 'btn-danger',
			action: function(dialog) {
				$.ajax({
					url: BASE_URL + '/spj/kurangisaldo',
					type: "POST",
					data: {idpengajuan : id},
					headers: {'X-CSRF-TOKEN': CSRF},
					success: function (response) {
						dialog.close();
						if (response.code == 200) {
							location.reload();
						} else {
							$('#errorMessageModal').modal('show');
							$('#errorMessageModal #errors').html(''+response.message);
						}
					},
					error: function () {
						dialog.close();
						$('#errorMessageModal').modal('show');
						$('#errorMessageModal #errors').html(''+response.message);
					}
				});
			}
		}, {
			label: 'Tidak',
			action: function(dialog) {
				dialog.close();
			}
		}]
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