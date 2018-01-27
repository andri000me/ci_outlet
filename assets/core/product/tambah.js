$(function() {
	$('#quantity').hide();
	if($('select[name="id_jenis"]').val()==''){
		$('select[name="id_jenis"]').attr('disabled', 'disabled');
	}
	if($('select[name="id_provider"]').val()==''){
		$('select[name="id_provider"]').attr('disabled', 'disabled');
	}
	if($('select[name="id_lokasi"]').val()==''){
		$('select[name="id_lokasi"]').attr('disabled', 'disabled');
	}
	if($('select[name="id_barang"]').val()==''){
		$('select[name="id_barang"]').attr('disabled', 'disabled');
	}
	$('select[name="kode"]').addClass('disabled');
	$('select[name="product"]').addClass('disabled');
	var jx = null;
	var px = null;

	$('select[name="id_supplier"]').change(function(event) {
		if ($(this).val()!=='') {
			var ksupplier = $('option:selected', this).attr('data-val');
			// var ssupplier = $('option:selected', this).attr('data-content');
			$('select[name="id_jenis"]').removeAttr('disabled');
			var kode = $('input[name="kode"]').val();
			if (kode.length==2) {
				$('input[name="kode"]').val(ksupplier);
				$('select[name="id_jenis"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_barang"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').attr('disabled', 'disabled');
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
				$('select[name="id_barang"]').attr('disabled', 'disabled');
			}
			else {
				$('input[name="kode"]').val(ksupplier);
				$('select[name="id_jenis"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_barang"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').attr('disabled', 'disabled');
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
				$('select[name="id_barang"]').attr('disabled', 'disabled');
			}
		}
		else {
			$('select[name="id_jenis"]').prop('selectedIndex',0);
			$('select[name="id_provider"]').prop('selectedIndex',0);
			$('select[name="id_lokasi"]').prop('selectedIndex',0);
			$('select[name="id_barang"]').prop('selectedIndex',0);
			$('select[name="id_jenis"]').attr('disabled', 'disabled');
			$('select[name="id_provider"]').attr('disabled', 'disabled');
			$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			$('select[name="id_barang"]').attr('disabled', 'disabled');
			$('input[name="kode"]').val('');
		}
	});

	$('select[name="id_jenis"]').change(function(event) {
		if ($(this).val()!=='') {
			var kjenis = $('option:selected', this).attr('data-val');
			var sjenis = $('option:selected', this).attr('data-content')+' ';
			$('select[name="id_provider"]').removeAttr('disabled');
			var kode = $('input[name="kode"]').val();
			var product = $('input[name="product"]').val();
			if (kode.length==2) {
				$('input[name="kode"]').val(kode+kjenis);
				$('input[name="product"]').val(sjenis);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_barang"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
				$('select[name="id_barang"]').attr('disabled', 'disabled');
			}
			else {
				kode = kode.slice(0, 2);
				$('input[name="kode"]').val(kode+kjenis);
				$('input[name="product"]').val(sjenis);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_barang"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
				$('select[name="id_barang"]').attr('disabled', 'disabled');
			}
			jx = sjenis.length;
			console.log('jenis '+jx,px);
		}
		else {
			$('select[name="id_provider"]').prop('selectedIndex',0);
			$('select[name="id_lokasi"]').prop('selectedIndex',0);
			$('select[name="id_barang"]').prop('selectedIndex',0);
			$('select[name="id_provider"]').attr('disabled', 'disabled');
			$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			$('select[name="id_barang"]').attr('disabled', 'disabled');
			var kode = $('input[name="kode"]').val();
			kode = kode.slice(0, 2);
			$('input[name="kode"]').val(kode);
		}
	});

	$('select[name="id_provider"]').change(function(event) {
		if ($(this).val()!=='') {
			var kprovider = $('option:selected', this).attr('data-val');
			var sprovider = $('option:selected', this).attr('data-content')+' ';
			$('select[name="id_barang"]').removeAttr('disabled');
			var kode = $('input[name="kode"]').val();
			var product = $('input[name="product"]').val();
			if (kode.length==4) {
				$('input[name="kode"]').val(kode+kprovider);
				$('input[name="product"]').val(product+sprovider);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_barang"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			}
			else {
				kode = kode.slice(0, 4);
				product = product.slice(0, jx);
				$('input[name="kode"]').val(kode+kprovider);
				$('input[name="product"]').val(product+sprovider);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_barang"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			}
			px = jx + sprovider.length;
			console.log('provider',jx,px);
		}
		else {
			$('select[name="id_lokasi"]').prop('selectedIndex',0);
			$('select[name="id_barang"]').prop('selectedIndex',0);
			$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			$('select[name="id_barang"]').attr('disabled', 'disabled');
			var kode = $('input[name="kode"]').val();
			kode = kode.slice(0, 4);
			$('input[name="kode"]').val(kode);
		}
	});

	$('select[name="id_barang"]').change(function(event) {
		if ($(this).val()!=='') {
			var kbarang = $('option:selected', this).attr('data-val');
			var sbarang = $('option:selected', this).attr('data-content')+' ';
			$('select[name="id_lokasi"]').removeAttr('disabled');
			var kode = $('input[name="kode"]').val();
			var product = $('input[name="product"]').val();
			if (kode.length==6) {
				$('input[name="kode"]').val(kode+kbarang);
				$('input[name="product"]').val(product+sbarang);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
			}
			else {
				kode = kode.slice(0, 6);
				product = product.slice(0, px);
				$('input[name="kode"]').val(kode+kbarang);
				$('input[name="product"]').val(product+sbarang);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
			}
			console.log('barang '+jx,px);
		}
		else {
			$('select[name="id_lokasi"]').prop('selectedIndex',0);
			$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			var kode = $('input[name="kode"]').val();
			kode = kode.slice(0, 6);
			$('input[name="kode"]').val(kode);
		}
	});

	$('select[name="id_lokasi"]').change(function(event) {
		if ($(this).val()!=='') {
			var klokasi = $('option:selected', this).attr('data-val');
			// var slokasi = $('option:selected', this).attr('data-content');
			var kode = $('input[name="kode"]').val();
			if (kode.length==9) {
				$('input[name="kode"]').val(kode+klokasi);
			}
			else {
				kode = kode.slice(0, 9);
				$('input[name="kode"]').val(kode+klokasi);
			}
		}
		else {
			var kode = $('input[name="kode"]').val();
			kode = kode.slice(0, 9);
			$('input[name="kode"]').val(kode);
		}
	});

	$('#btn-quantity').click(function(event) {
		$('#quantity').show();
	});

	$('#harga_awal').keyup(function(event) {
		var val = $(this).val();
		$('#harga_jual').val(val);
		$('#harga_akhir').val(val);
	});
});