window.onload = function () {
  mutasi_list()
}


$(function() {
  $('#mutasi_scan').keyup(function(event) {
    if (event.which == 13) {
      var bc = $(this).val();
      mutasi_scan(bc);
    }
  });

  $('#mutasi_submit').click(function(event) {
    mutasi_submit();
  });

  $('#bersihkan').click(function(event) {
    bersihkan();
  });
});

function mutasi_list() {
  var tr = 
      '<tr>'+
        '<td>&nbsp;</td>'+
        '<td>&nbsp;</td>'+
        '<td widtd="50" class="center"><a href="javascript:void(0);" disabled="disabled"><i class="fa fa-trash text-red"></i></a></td>'+
      '</tr>';
  $('#list_mutasi').html(tr);

  $.ajax({
    url: app.base_url+'mutasi/mutasi_list/',
    type: 'GET',
    dataType: 'json',
    data: {}
  })
  .done(function(data) {
    var tr
    var trs = [];
    for (var i = Object.keys(data).length - 1; i >= 0; i--) {
      tr = 
      '<tr>'+
        '<td>'+data[i]['product']+'</td>'+
        '<td>'+data[i]['jumlah']+'</td>'+
        '<td widtd="50" class="center"><a href="javascript:void(0)" onclick="hapus('+data[i]['id_product']+')"><i class="fa fa-trash text-red"></i></a></td>'+
      '</tr>';
      trs.push(tr);
    }
    $('#list_mutasi').html(trs);
  });
}

function mutasi_scan(barcode) {
  $.post(app.base_url+'mutasi/mutasi_check', { pbarcode: barcode }, function(data){
    if (data['product']!='') { 
      $.ajax({
        url: app.base_url+'mutasi/mutasi_temp/'+barcode,
        type: 'GET',
        dataType: 'json'
      })
      .done(function(data) {
        if (data['error']=='empty') {
          swal({
            title: 'Oops...',
            text: "Product tidak terdaftar!",
            type: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          }).then(function () {
            $('#mutasi_scan').val('');
          });
        }
        else if (data['error']=='listed') {
          swal({
            title: 'Oops...',
            text: "Product sudah diinput!",
            type: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          }).then(function () {
            $('#mutasi_scan').val('');
          });
        }
        else if (data['error']=='unlist') {
          swal({
            title: 'Oops...',
            text: "Product tidak terdaftar!",
            type: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          }).then(function () {
            $('#mutasi_scan').val('');
          });
        }
        else {
          mutasi_list();
          $('#mutasi_scan').val('');
        }
      });
    }
    else {
      swal({
        title: 'Oops...',
        text: "Product tidak terdaftar!",
        type: 'warning',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
      }).then(function () {
        $('#mutasi_scan').val('');
      });
    }
  },'json');
}

function mutasi_submit() {
  var id_lokasi = $('#id_lokasi').val();
  if (id_lokasi=='') {
    swal('Oops...','Lokasi belum dipilih!','error');
  }
  else {
    $.ajax({
      url: app.base_url+'mutasi/mutasi_submit/'+id_lokasi,
      type: 'GET',
      dataType: 'json'
      // data: {lokasi: id_lokasi},
    })
    .done(function() {
      console.log("success");
      window.location.href = app.base_url+'mutasi';
    })
    .fail(function() {
      console.log("error");
    });
  }
}

function bersihkan() {
  swal({
    title: "Apa anda yakin?",
    text: "Data berikut akan dihapus!",
    provider: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Hapus!',
    cancelButtonText: 'Batal'
  }).then(function (isConfirm) {
    $.post(app.base_url+'mutasi/del_all/', function(data){
      mutasi_list();
    },'json');
    mutasi_list();
  });
}

function hapus(key) {
  swal({
    title: "Apa anda yakin?",
    text: "Data berikut akan dihapus!",
    provider: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Hapus!',
    cancelButtonText: 'Batal'
  }).then(function (isConfirm) {
    $.post(app.base_url+'mutasi/del_itm/'+key, function(data){
      console.log(data);
      if (data) {
        mutasi_list();
      }
    },'json');
    mutasi_list();
  });
}
