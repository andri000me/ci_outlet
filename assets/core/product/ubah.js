function hapus(id,no,key) {
	swal({
	  title: "Apa anda yakin?",
	  text: "Data No. "+no+" berikut akan dihapus! \n\ Mungkin akan menyebabkan Error pada Data yang berkaitan.",
	  provider: "warning",
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  confirmButtonText: 'Hapus!',
	  cancelButtonText: 'Batal'
	}).then(function (isConfirm) {
		if (isConfirm) {
			window.location.href = app.base_url+'product/hapus-detail-stock/'+id+'/'+key;
	  }
	});
}

function edit(id,kode,msisdn,exp,key) {
	$('#mtitle').html(kode);
	$('#mid').val(id);
	$('#mkey').val(key);
	$('#mmsisdn').val(msisdn);
	$('#mkode').val(kode);
	$('#mdate').val(exp);
	$('#mymodal').modal('show');
}

function simpan() {
	var mid = $('#mid').val();
	var key = $('#mkey').val();
	var mkode = $('#mkode').val();
	var mmsisdn = $('#mmsisdn').val();
	var mdate = $('#mdate').val();
	var mketerangan = $(".modal-body #mketerangan").val();

	$.post(app.base_url+'product/update_detail_stock', {id_pdetail: mid, kode: mkode, msisdn: mmsisdn, exp: mdate, keterangan: mketerangan}, function(data, textStatus, xhr) {
		$('#mymodal').modal('hide');
		window.location.href = app.base_url+'product/ubah/'+key;
	});
}

$(function() {
	$('#quantity').hide();
	$('#btn-quantity').click(function(event) {
		$('#quantity').show();
	});

	$('#harga_awal').keyup(function(event) {
		var val = $(this).val();
		$('#harga_jual').val(val);
		$('#harga_akhir').val(val);
	});

	$('table[for="stock"]').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": false,
    "info": false,
    "pageLength": 15,
    "autoWidth": false,
    // "dom": 'Bfrtip',
    // "buttons": [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
    "oLanguage": {
      "oPaginate": {
        "sNext": '»',
        "sPrevious": '«'
      },
      "sZeroRecords":    "TIDAK ADA DATA YANG SESUAI",
      "sLoadingRecords": "DATA KOSONG",
      "sEmptyTable":     "DATA TIDAK TERSEDIA",
    }
  });
});