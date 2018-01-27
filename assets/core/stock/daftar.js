function hapus(key,no) {
	swal({
	  title: "Apa anda yakin?",
	  text: "Data No. "+no+" berikut akan dihapus! \n\ Mungkin akan menyebabkan Error pada Data yang berkaitan.",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  confirmButtonText: 'Hapus!',
	  cancelButtonText: 'Batal'
	}).then(function (isConfirm) {
		if (isConfirm) {
			window.location.href = app.base_url+'stock/hapus/'+key;
	  }
	});
}

$(function() {
	$('button[name="submit"]').click(function(event) {
		var kode = $('input[name="kode"]').val();
		var quantity = $('input[name="quantity"]').val();
		if (kode.length !=0 ) {
			$.ajax({
				url: app.base_url+'stock/check-data',
				type: 'POST',
				dataType: 'json',
				data: {
					param_kode: kode,
					param_quantity: quantity
				},
			})
			.done(function(data) {
				console.log(data);
				if (data!=null) window.location.replace(app.base_url+'stock');
				else swal("<span style='color:rgb(211, 84, 0);'>Kode tidak ada!</span>\nTambahkan stock product.");
			});
		}
		else {
			swal("<span style='color:rgb(211, 84, 0);'>Kode tidak ada!</span>\nSilahkan diisi terlebih dahulu");
		}
	});

	$('button[name="verifikasi"]').click(function(event) {
		window.location.replace(app.base_url+'stock/verifikasi');
	});
});