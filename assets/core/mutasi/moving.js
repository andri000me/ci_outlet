$(function() {
	$('#check_all').change(function(event) {
		var cek = $('input[name="id_pdetail[]"]');
		cek.not(this).prop('checked', this.checked);
	});

	$('#submit_mutasi').click(function(event) {
		var product = $('#id_product').val();
		var lokasi_awal = $('#lokasi_awal').val();
		var lokasi_akhir = $('#lokasi_akhir').val();
		var cek = $('input[name="id_pdetail[]"]:checked');
		var arr = [];
		if (lokasi_akhir=='') swal('Oops...','Lokasi belum diisi!','error');
		else {
			cek.each(function () {
				arr.push({id:$(this).val()});
			});
			if (arr.length==0) swal('Oops...','Item belum dipilih!','error');
			else {
				var jml = arr.length;
				var dmp = {product:product, lokasi_awal:lokasi_awal, lokasi_akhir:lokasi_akhir, jumlah:jml, item:arr};
				var enc = JSON.stringify(dmp);
				var url = app.base_url+'mutasi/dmp';
				
				$.post(url, {param: dmp}, function(data, textStatus, xhr) {
					// console.log(data);
					window.location.href = app.base_url+'mutasi';
				});
				
			}
		}
	});
});