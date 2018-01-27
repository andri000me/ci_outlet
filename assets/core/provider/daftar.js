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
			window.location.href = app.base_url+'provider/hapus/'+key;
	  }
	});
}

$(function() {
	$('a[title="Print"]').click(function(event) {
  	var newWin = window.open();
  	$.ajax({
  		url: app.base_url+'provider/print',
  		type: 'GET',
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
});