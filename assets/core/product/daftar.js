function hapus(key,no) {
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
			window.location.href = app.base_url+'product/hapus/'+key;
	  }
	});
}

$(function() {
	$('button[name="tampilkan"]').click(function(event) {
  	var id_supplier = $('select[name="id_supplier"]').val();
		var id_jenis = $('select[name="id_jenis"]').val();
		var id_provider = $('select[name="id_provider"]').val();
		var id_lokasi = $('select[name="id_lokasi"]').val();
		// var id_barang = $('select[name="id_barang"]').val();
		// console.log(id_supplier,id_jenis,id_provider,id_lokasi);
		$.post(app.base_url+'product/tampilkan', {
			pid_jenis: id_jenis,
			pid_supplier: id_supplier,
			pid_lokasi: id_lokasi,
			pid_provider: id_provider
			// pid_barang: id_barang 
    }, 
  		function(){
  			window.location.replace(app.base_url+'product/index')
  		}
		);
  });

  $('a[title="Print"]').click(function(event) {
  	var newWin = window.open();
  	$.ajax({
  		url: app.base_url+'product/print',
  		provider: 'GET',
  		data: {},
  	})
  	.done(function(data) {
  		newWin.document.writeln(data);
      newWin.document.close();
      newWin.focus();
      newWin.print();
      newWin.close();
  	})  	
  });

  $('a[title="Barcode"]').click(function(event) {
  	var newWin = window.open();
  	$.ajax({
  		url: app.base_url+'product/barcode',
  		provider: 'GET',
  		data: {},
  	})
  	.done(function(data) {
  		newWin.document.writeln(data);
      newWin.document.close();
      newWin.focus();
      newWin.print();
      newWin.close();
  	})  	
  });

  $('.btn-search').click(function(event) {
    var search = $('#form-search').val();
    if (search!='') {
      console.log(search);
      $.post(app.base_url+'product/search/'+search, {form_search: search}, function(data, textStatus, xhr) {
        window.location.replace(app.base_url+'product/search/'+search);
      });
    }
  });
});