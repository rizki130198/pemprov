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
$(document).on('blur', '.table_data', function(){
	var id_saldo = $(this).data('row_id');
	var table_column = $(this).data('column_name');
	var value = $(this).text();
	$.ajax({
		url:BASE_URL+ '/spj/editsaldo',
		method:"POST",
		data:{id_saldo:id_saldo, table_column:table_column, value:value},
		headers: {'X-CSRF-TOKEN': CSRF},
		success: function (response) {
			if (response.code == 200) {
				$('#exampleModal2').modal('hide');
			} else {
				$('#errorMessageModal').modal('show');
			}
		},
		error: function () {
			$('#errorMessageModal').modal('show');
			$('#errorMessageModal #errors').html(''+response.message);
		}
	})
});
function Booking() {
	$("#switch").change(function() {
		if (this.checked) {
			$("#booking").removeAttr('disabled','disabled');
		}else{
			$("#booking").attr('disabled','disabled');
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
	if (!isNaN(jwb)) {
		$('#total').val(jwb);
	}
}