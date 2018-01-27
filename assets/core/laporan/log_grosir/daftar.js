$(function() {
	$('button[name="tampilkan"]').click(function(event) {
		var lokasi = $('#id_lokasi').val();
		var user = $('#id_user').val();
		var tgl_awal = $('input[name="tanggal_awal"]').val();
		var tgl_akhir = $('input[name="tanggal_akhir"]').val();
    // console.log(tgl_awal, tgl_akhir);
		$.post(app.base_url+'laporan/tampilkan', {
			pid_user:user,
			pid_lokasi:lokasi,
			ptgl_awal:tgl_awal,
			ptgl_akhir:tgl_akhir}, 
			function(){
				window.location.replace(app.base_url+'laporan/log-grosir.phtml');
			}
		);
  });
});