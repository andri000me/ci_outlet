$(function() {
	if($('select[name="id_supplier"]').val()==''){
		$('select[name="id_supplier"]').attr('disabled', 'disabled');
	}
	if($('select[name="id_jenis"]').val()==''){
		$('select[name="id_jenis"]').attr('disabled', 'disabled');
	}
	if($('select[name="id_provider"]').val()==''){
		$('select[name="id_provider"]').attr('disabled', 'disabled');
	}
	if($('select[name="id_lokasi"]').val()==''){
		$('select[name="id_lokasi"]').attr('disabled', 'disabled');
	}


	$('select[name="id_product"]').change(function(event) {
		if ($(this).val()!=='') {
			var kproduct = $('option:selected', this).attr('data-val');
			$('select[name="id_supplier"]').removeAttr('disabled');
			var kode = $('input[name="kode"]').val();
			if (kode.length==3) {
				$('input[name="kode"]').val(kproduct);
				$('select[name="id_supplier"]').prop('selectedIndex',0);
				$('select[name="id_jenis"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_jenis"]').attr('disabled', 'disabled');
				$('select[name="id_provider"]').attr('disabled', 'disabled');
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			}
			else {
				$('input[name="kode"]').val(kproduct);
				$('select[name="id_supplier"]').prop('selectedIndex',0);
				$('select[name="id_jenis"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_jenis"]').attr('disabled', 'disabled');
				$('select[name="id_provider"]').attr('disabled', 'disabled');
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			}
		}
		else {
			$('select[name="id_supplier"]').prop('selectedIndex',0);
			$('select[name="id_jenis"]').prop('selectedIndex',0);
			$('select[name="id_provider"]').prop('selectedIndex',0);
			$('select[name="id_lokasi"]').prop('selectedIndex',0);
			$('select[name="id_supplier"]').attr('disabled', 'disabled');
			$('select[name="id_jenis"]').attr('disabled', 'disabled');
			$('select[name="id_provider"]').attr('disabled', 'disabled');
			$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			$('input[name="kode"]').val('');
		}
	});

	$('select[name="id_supplier"]').change(function(event) {
		if ($(this).val()!=='') {
			var ksupplier = $('option:selected', this).attr('data-val');
			$('select[name="id_jenis"]').removeAttr('disabled');
			var kode = $('input[name="kode"]').val();
			if (kode.length==3) {
				$('input[name="kode"]').val(kode+ksupplier);
				$('select[name="id_jenis"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').attr('disabled', 'disabled');
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			}
			else {
				kode = kode.slice(0, 3);
				$('input[name="kode"]').val(kode+ksupplier);
				$('select[name="id_jenis"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_provider"]').attr('disabled', 'disabled');
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			}
		}
		else {
			$('select[name="id_jenis"]').prop('selectedIndex',0);
			$('select[name="id_provider"]').prop('selectedIndex',0);
			$('select[name="id_lokasi"]').prop('selectedIndex',0);
			$('select[name="id_jenis"]').attr('disabled', 'disabled');
			$('select[name="id_provider"]').attr('disabled', 'disabled');
			$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			var kode = $('input[name="kode"]').val();
			kode = kode.slice(0, 3);
			$('input[name="kode"]').val(kode);
		}
	});

	$('select[name="id_jenis"]').change(function(event) {
		if ($(this).val()!=='') {
			var kjenis = $('option:selected', this).attr('data-val');
			$('select[name="id_provider"]').removeAttr('disabled');
			var kode = $('input[name="kode"]').val();
			if (kode.length==5) {
				$('input[name="kode"]').val(kode+kjenis);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			}
			else {
				kode = kode.slice(0, 5);
				$('input[name="kode"]').val(kode+kjenis);
				$('select[name="id_provider"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
				$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			}
		}
		else {
			$('select[name="id_provider"]').prop('selectedIndex',0);
			$('select[name="id_lokasi"]').prop('selectedIndex',0);
			$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			$('select[name="id_provider"]').attr('disabled', 'disabled');
			var kode = $('input[name="kode"]').val();
			kode = kode.slice(0, 5);
			$('input[name="kode"]').val(kode);
		}
	});

	$('select[name="id_provider"]').change(function(event) {
		if ($(this).val()!=='') {
			var kprovider = $('option:selected', this).attr('data-val');
			$('select[name="id_lokasi"]').removeAttr('disabled');
			var kode = $('input[name="kode"]').val();
			if (kode.length==7) {
				$('input[name="kode"]').val(kode+kprovider);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
			}
			else {
				kode = kode.slice(0, 7);
				$('input[name="kode"]').val(kode+kprovider);
				$('select[name="id_lokasi"]').prop('selectedIndex',0);
			}
		}
		else {
			$('select[name="id_lokasi"]').prop('selectedIndex',0);
			$('select[name="id_lokasi"]').attr('disabled', 'disabled');
			var kode = $('input[name="kode"]').val();
			kode = kode.slice(0, 7);
			$('input[name="kode"]').val(kode);
		}
	});

	$('select[name="id_lokasi"]').change(function(event) {
		if ($(this).val()!=='') {
			var klokasi = $('option:selected', this).attr('data-val');
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
})