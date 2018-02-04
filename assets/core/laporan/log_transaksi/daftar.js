$(function() {
	$('button[name="tampilkan"]').click(function(event) {
		var lokasi = $('#id_lokasi').val();
		var user = $('#id_user').val();
		var tgl_awal = $('input[name="tanggal_awal"]').val();
		var tgl_akhir = $('input[name="tanggal_akhir"]').val();
    console.log(lokasi, user, tgl_awal, tgl_akhir);
		$.post(app.base_url+'laporan/tampilkan', {
			pid_user:user,
			pid_lokasi:lokasi,
			ptgl_awal:tgl_awal,
			ptgl_akhir:tgl_akhir},
			function(){
				window.location.replace(app.base_url+'laporan/log-transaksi.phtml');
			}
		);
  });

  $('table[for="pcs_list"]').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": false,
    "info": false,
    "pageLength": 15,
    "autoWidth": false,
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

function print(val) {
  var printableObjects=[];
  $.post(app.base_url+'laporan/print_faktur_pcs', {faktur: val}, function(data, textStatus, xhr) {
    // console.log(data)
    printableObjects.push(data);
    printableObjects.forEach(function(d){
      printContent(d);
    });
    return printableObjects;
  });
}

function printContent(printDoc){
  var newWin = window.open();
  var restorepage = document.body.innerHTML;
  var printcontent = printDoc;
  newWin.document.body.innerHTML = printcontent;
  newWin.print();
  newWin.document.body.innerHTML = restorepage;
  newWin.close();
}