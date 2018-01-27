$(function() {
	$('#faktur_satuan').keyup(function(event) {
    if (event.which == 13) {
      var bc = $(this).val();
      satuan_faktur_scan(bc);
    }
  });

	$('#faktur_grosir').keyup(function(event) {
    if (event.which == 13) {
      var bc = $(this).val();
      grosir_faktur_scan(bc);
    }
  });
});



/* Retur Satuan */
function satuan_faktur_scan(faktur) {
	var faktur = $('#faktur_satuan').val();
  if (faktur.length==0) {
  	swal({
      title: 'Oops...',
      text: "Field masih kosong!",
      type: 'warning',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ok'
    }).then(function () {
      $('#faktur_satuan').val('');
    });
  }
  else {
		$.post(app.base_url+'retur/satuan_faktur_scan', {nofaktur: faktur}, function(data, textStatus, xhr) {
			if (data['msg']=='unlisted') {
				swal({
		      title: 'Oops...',
		      text: "Product tidak tersedia!",
		      type: 'warning',
		      confirmButtonColor: '#3085d6',
		      confirmButtonText: 'Ok'
		    }).then(function () {
		      $('#faktur_satuan').val('');
		      $('#opsiitem').html('');
		    });
			}
			else if (data['msg']=='retured') {
				swal({
		      title: 'Oops...',
		      text: "Product sudah diretur!",
		      type: 'warning',
		      confirmButtonColor: '#3085d6',
		      confirmButtonText: 'Ok'
		    }).then(function () {
		      $('#faktur_satuan').val('');
		      $('#opsiitem').html('');
		    });
			}
			else {
				var tbl = $('#tbl_transsatuan');
				var tr = $(
				'<tr>'+
				'<td>'+data['tanggal']+'</td>'+
				'<td>'+data['kode_stock']+'</td>'+
				'<td>'+data['product']+'</td>'+
				'<td>'+data['totalbelanja']+'</td>'+
				'<td>'+data['totalitem']+'</td>'+
				'</tr>'+
				'<tr><td colspan="5">'+
				'<textarea name="ketreturitem" id="ketreturitem" rows="3" placeholder="Keterangan Retur" class="form-control"></textarea>'+
				'</td>'+
				'</tr>');
				tbl.html(tr);
				var btn = '<a href="javascript:void(0)" class="btn btn-flat btn-warning pull-right" onclick="satuan_retur(\''+data['no_faktur']+'\')" data-toggle="tooltip" data-placement="top" title="Retur">Retur</a>';
				$('#opsiitem').html(btn);
			}
		},'json');
	}
}

function satuan_retur(no_faktur) {
	var ket = $('#ketreturitem').val();
	if (ket.length==0) {
		swal({
      title: 'Oops...',
      text: "Keterangan belum diisi!",
      type: 'warning',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ok'
    }).then(function () {
      $('#grosir_item').val('');
    });
	}
	else {
		$.post(app.base_url+'retur/satuan_retur', {nofaktur: no_faktur, keterangan:ket}, function(data, textStatus, xhr) {
			console.log(data);
			window.location.href = app.base_url+'retur/transaksi.phtml';
		});
	}
}


/* Retur Grosir */
function grosir_faktur_scan(faktur) {
	var faktur = $('#faktur_grosir').val();
  if (faktur.length==0) {
  	swal({
      title: 'Oops...',
      text: "Field masih kosong!",
      type: 'warning',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ok'
    }).then(function () {
      $('#faktur_trans').html('');
	  	$('#tbl_transgrosir').html(
	  		'<tr>'+
			  '<td>&nbsp;</td>'+
			  '<td>&nbsp;</td>'+
			  '<td>&nbsp;</td>'+
			  '<td>&nbsp;</td>'+
			  '<td>&nbsp;</td>'+
			  '<tr>'
		  );
    });
  }
  else {
  	$.post(app.base_url+'retur/grosir_faktur_scan/', {nofaktur: faktur}, function(data, textStatus, xhr) {
  		if (data['msg']=='unlisted') {
  			swal({
		      title: 'Oops...',
		      text: "No Faktur tidak ada!",
		      type: 'warning',
		      confirmButtonColor: '#3085d6',
		      confirmButtonText: 'Ok'
		    }).then(function () {
		      $('#faktur_trans').html('');
			  	$('#tbl_transgrosir').html(
			  		'<tr>'+
					  '<td>&nbsp;</td>'+
					  '<td>&nbsp;</td>'+
					  '<td>&nbsp;</td>'+
					  '<td>&nbsp;</td>'+
					  '<td>&nbsp;</td>'+
					  '<tr>'
				  );
			  	$('#returgsr_scan').html('');
					$('#returgsr').html('');
		    });
  		}
  		else {
  			var dtrans = '<br><table>'+
				'<tr>'+
				'<td><b>No. Faktur</b></td>'+
				'<td>: '+data['no_faktur']+'</td>'+
				'</tr>'+
				'<tr>'+
				'<td><b>Tanggal Transaksi</b> &nbsp;</td>'+
				'<td>: '+data['tanggal']+'</td>'+
				'</tr>'+
				'<tr>'+
				'<td><b>Kasir</b></td>'+
				'<td>: '+data['kasir']+'</td>'+
				'</tr>'+
				'</table>';
				$('#faktur_trans').html(dtrans);

				var trs = [];
				var tbl = $('#tbl_transgrosir');
				for (var i = data['detail'].length - 1; i >= 0; i--) {
					// console.log(data['detail'][i]);
					var tr = 
						'<tr>'+
					  '<td>'+data['detail'][i]['product']+'</td>'+
					  '<td>'+data['detail'][i]['hargasatuan']+'</td>'+
					  '<td>'+data['detail'][i]['jumlah']+'</td>'+
					  '<td>'+data['detail'][i]['diskon']+'</td>'+
					  '<td>'+data['detail'][i]['total']+'</td>'+
					  '<tr>';
					trs.push(tr);
				}

				trs.push('<tr>'+
					'<td colspan="4" class="text-right"><b>Total Belanja</b></td>'+
				  '<td>'+data['total']+'</td>'+
				  '<tr>');
				trs.push('<tr>'+
					'<td colspan="4" class="text-right"><b>Bayar</b></td>'+
				  '<td>'+data['bayar']+'</td>'+
				  '<tr>');
				trs.push('<tr>'+
					'<td colspan="4" class="text-right"><b>Kembali</b></td>'+
				  '<td>'+data['kembalian']+'</td>'+
				  '<tr>');
				tbl.html(trs);
				$('#faktur_grosir').val('');

	  		$('#returgsr_scan').html(
					'<div class="form-groub">'+
					'<lable class="control-label col-xs-2">Barcode</lable>'+
					'<div class="col-xs-4">'+
					'<input type="text" name="grosir_item" id="grosir_item" placeholder="0000000" class="form-control" data-toggle="tooltip" data-placement="top" title="Barcode">'+
					'</div>'+
					'</div>'+
					'<br><br>'
				);
				$('#returgsr').html(
					'<table class="table table-bordered no-margin"><tbody>'+
					'<tr>'+
					'<th>Barcode</th>'+
					'<th>Product</th>'+
					'<th>Harga</th>'+
					'<th>Quantity</th>'+
					'<th>Opsi</th>'+
					'</tr>'+
					'</tbody>'+
					'<tbody id="tbl_returgsr">'+
					'<tr>'+
					'<th>&nbsp;</th>'+
					'<th>&nbsp;</th>'+
					'<th>&nbsp;</th>'+
					'<th>&nbsp;</th>'+
					'<th>&nbsp;</th>'+
					'<th>&nbsp;</th>'+
					'</tr>'+
					'</tbody></table>'+
					'<br><div id="opsigrosir"></div>'
				);
				var tr = 
	      '<tr>'+
				'<td>&nbsp;</td>'+
				'<td>&nbsp;</td>'+
				'<td>&nbsp;</td>'+
				'<td>&nbsp;</td>'+
				'<td>&nbsp;</td>'+
				'</tr>';
			  $('#tbl_returgsr').html(tr);
				var tr;
		    var trs = [];
      	$.ajax({
      		url: app.base_url+'retur/grosir_list/'+data['no_faktur'],
      		type: 'GET',
      		dataType: 'json'
      	})
      	.done(function(datas) {
      		// console.log(datas);
			    for (var i = Object.keys(datas).length - 1; i >= 0; i--) {
			      tr = 
				      '<tr>'+
							'<td>'+datas[i]['kode_stock']+'</td>'+
							'<td>'+datas[i]['product']+'</td>'+
							'<td>'+datas[i]['harga_satuan']+'</td>'+
							'<td>'+datas[i]['totalitem']+'</td>'+
							'<td widtd="50" class="center"><a href="javascript:void(0)" onclick="hapus(\''+datas[i]['kode_stock']+'\',\''+data['no_faktur']+'\')"><i class="fa fa-trash text-red"></i></a></td>'+
							'</tr>';
			      trs.push(tr);
			    }
			    if(Object.keys(datas).length!=0){
			    	tr ='<tr><td colspan="5">'+
						'<textarea name="ketreturgrosir" id="ketreturgrosir" rows="3" placeholder="Keterangan Retur" class="form-control"></textarea>'+
						'</td>'+
						'</tr>';
						trs.push(tr);
			    }
					$('#tbl_returgsr').html(trs);
      	})
      	.fail(function() {
      		console.log("error");
      	});
      	var btn = '<a href="javascript:void(0)" class="btn btn-flat btn-warning pull-right" onclick="grosir_retur(\'' + data['no_faktur'] + '\')" data-toggle="tooltip" data-placement="top" title="Retur">Retur</a>';
				$('#opsigrosir').html(btn);

				$('#grosir_item').keyup(function(event) {
			    if (event.which == 13) {
			      var bd = $(this).val();
			      $.post(app.base_url+'retur/grosir_stock_scan', {grosir_barcode: bd}, function(data, textStatus, xhr) {
			      	// console.log(data);
			      	if (data['msg']=='listed') {
			      		swal({
						      title: 'Oops...',
						      text: "Product sudah ada!",
						      type: 'warning',
						      confirmButtonColor: '#3085d6',
						      confirmButtonText: 'Ok'
						    }).then(function () {
						      $('#grosir_item').val('');
						    });
			      	}
			      	else if (data['msg']=='unlisted') {
			      		swal({
						      title: 'Oops...',
						      text: "Product tidak tersedia!",
						      type: 'warning',
						      confirmButtonColor: '#3085d6',
						      confirmButtonText: 'Ok'
						    }).then(function () {
						      $('#grosir_item').val('');
						    });
			      	}
			      	else if (data['msg']=='retured') {
			      		swal({
						      title: 'Oops...',
						      text: "Product sudah diretur!",
						      type: 'warning',
						      confirmButtonColor: '#3085d6',
						      confirmButtonText: 'Ok'
						    }).then(function () {
						      $('#grosir_item').val('');
						    });
			      	}
			      	else {
			      		var tr;
						    var trs = [];
				      	$.ajax({
				      		url: app.base_url+'retur/grosir_list/'+data['no_faktur'],
				      		type: 'GET',
				      		dataType: 'json'
				      	})
				      	.done(function(datas) {

							    for (var i = Object.keys(datas).length - 1; i >= 0; i--) {
							      tr = 
								      '<tr>'+
											'<td>'+datas[i]['kode_stock']+'</td>'+
											'<td>'+datas[i]['product']+'</td>'+
											'<td>'+datas[i]['harga_satuan']+'</td>'+
											'<td>'+datas[i]['totalitem']+'</td>'+
											'<td widtd="50" class="center"><a href="javascript:void(0)" onclick="hapus(\''+datas[i]['kode_stock']+'\',\''+data['no_faktur']+'\')"><i class="fa fa-trash text-red"></i></a></td>'+
											'</tr>';
							      trs.push(tr);
							    }
							    tr ='<tr><td colspan="5">'+
										'<textarea name="ketreturgrosir" id="ketreturgrosir" rows="3" placeholder="Keterangan Retur" class="form-control"></textarea>'+
										'</td>'+
										'</tr>';
									trs.push(tr);
									$('#tbl_returgsr').html(trs);
				      	})
				      	.fail(function() {
				      		console.log("error");
				      	})
				      	.always(function() {
				      		console.log("complete");
				      	});

								var btn = '<a href="javascript:void(0)" class="btn btn-flat btn-warning pull-right" onclick="grosir_retur(\'' + data['no_faktur'] + '\')" data-toggle="tooltip" data-placement="top" title="Retur">Retur</a>';
								$('#opsigrosir').html(btn);
			      	}
			  		}, 'json');
			    }
			  });
			}

  	},'json');
  }
}

function grosir_retur(no_faktur) {
	var ket = $('#ketreturgrosir').val();
	if (ket.length==0) {
		swal({
      title: 'Oops...',
      text: "Keterangan belum diisi!",
      type: 'warning',
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ok'
    }).then(function () {
      $('#grosir_item').val('');
    });
	}
	else {
		$.post(app.base_url+'retur/grosir_retur', {nofaktur: no_faktur, keterangan:ket}, function(data, textStatus, xhr) {
			console.log(data);
			window.location.href = app.base_url+'retur/transaksi.phtml';
		});
	}
}

function hapus(kode_stock, no_faktur) {
  swal({
    title: "Apa anda yakin?",
    text: "Data berikut akan dihapus!",
    provider: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Hapus!',
    cancelButtonText: 'Batal'
  }).then(function (isConfirm) {
    $.post(app.base_url+'retur/grosir_hapus_tmp', {kodestock: kode_stock}, function(data, textStatus, xhr) {
      grosir_list(no_faktur);
    },'json');
    grosir_list(no_faktur);
  });
}

function grosir_list(no_faktur) {
	var tr = 
      '<tr>'+
			'<td>&nbsp;</td>'+
			'<td>&nbsp;</td>'+
			'<td>&nbsp;</td>'+
			'<td>&nbsp;</td>'+
			'<td>&nbsp;</td>'+
			'</tr>';
  $('#tbl_returgsr').html(tr);

	var tr;
  var trs = [];
	$.ajax({
		url: app.base_url+'retur/grosir_list/'+no_faktur,
		type: 'GET',
		dataType: 'json'
	})
	.done(function(datas) {
		// console.log(datas);
    for (var i = Object.keys(datas).length - 1; i >= 0; i--) {
      tr = 
	      '<tr>'+
				'<td>'+datas[i]['kode_stock']+'</td>'+
				'<td>'+datas[i]['product']+'</td>'+
				'<td>'+datas[i]['harga_satuan']+'</td>'+
				'<td>'+datas[i]['totalitem']+'</td>'+
				'<td widtd="50" class="center"><a href="javascript:void(0)" onclick="hapus(\''+datas[i]['kode_stock']+'\', \''+no_faktur+'\')"><i class="fa fa-trash text-red"></i></a></td>'+
				'</tr>';
      trs.push(tr);
    }
    if(Object.keys(datas).length!=0){
    	tr ='<tr><td colspan="5">'+
			'<textarea name="ketreturgrosir" id="ketreturgrosir" rows="3" placeholder="Keterangan Retur" class="form-control"></textarea>'+
			'</td>'+
			'</tr>';
			trs.push(tr);
    }
		$('#tbl_returgsr').html(trs);
	});
}