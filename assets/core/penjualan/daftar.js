window.onload = function () {
  $('#sb').focus();
  $.ajax({
    url: app.base_url+'penjualan/grosir_list/',
    type: 'get',
    dataType: 'json',
    data: {}
  })
  .done(function(data) {
    var tr
    var trs = [];
    for (var i = Object.keys(data).length - 1; i >= 0; i--) {
      tr = 
      '<tr>'+
        // '<td>'+data[i]['kode']+'</td>'+
        '<td>'+data[i]['product']+'</td>'+
        '<td>'+data[i]['hargasatuan']+'</td>'+
        '<td>'+data[i]['jumlah']+'</td>'+
        '<td>'+data[i]['diskon']+'</td>'+
        '<td class="text-right">'+data[i]['total']+'</td>'+
        '<td widtd="50" class="center"><a href="javascript:void(0)" onclick="hapus('+data[i]['id_product']+')"><i class="fa fa-trash text-red"></i></a></td>'+
      '</tr>';
      trs.push(tr);
    }
    var tbody_top = '<tbody id="grosir_list">';
    var tbody_bottom = '</tbody>';
    $('#grosir_list').html(trs);
    gettotal();
  });

  if ($('#gsrtotal').val()==='') {
    $('#print_gsr').addClass('disabled')
  }
  else {
    $('#print_gsr').removeClass('disabled')
  }
}

$(function() {
  // scand barcode
  $('#sb').keyup(function(event) {
    if (event.which == 13) {
      var bc = $(this).val();
      submit_scan(bc);
    }
  });

  $('#gb').keyup(function(event) {
    if (event.which == 13) {
      var bc = $(this).val();
      submit_grosir(bc);
    }
  });

  $('#submit_scn').click(function(event) {
    var bc = $('#sb').val();
    submit_scan(bc);
  });

  $('#submit_gsr').click(function(event) {
    var bc = $('#gb').val();
    submit_grosir(bc);
  });

  $('#bersihkan_gsr').click(function(event) {
    bersihkan();
  });

  $('#print_gsr').click(function(event) {
    printgrosir();
  });

  $('#gsrbayar').keyup(function(event) {
    var gsrbayar = $('#gsrbayar').val();
    var total = $('#gsrtotal').val();
    var potongan = $('#gsrpotongan').val();
    if (potongan.length==0) {
      var kembali = parseInt(gsrbayar) - parseInt(total);
      $('#gsrkembalian').val(kembali);
    }
    else {
      var htotal = parseInt(total) - parseInt(potongan);
      var altkembali = parseInt(gsrbayar) - parseInt(htotal);
      $('#gsrkembalian').val(altkembali);
    }
    $('#print_gsr').removeClass('disabled');
  });

  $('#gsrpotongan').keyup(function(event) {
    var gsrbayar = $('#gsrbayar').val();
    var total = $('#gsrtotal').val();
    var potongan = $('#gsrpotongan').val();

    if (potongan.length==0) {
      var kembali = parseInt(gsrbayar) - parseInt(total);
      $('#gsrkembalian').val(kembali);
    }
    else {
      var htotal = parseInt(total) - parseInt(potongan);
      var altkembali = parseInt(gsrbayar) - parseInt(htotal);
      $('#gsrkembalian').val(altkembali);
    }
    $('#print_gsr').removeClass('disabled');
  });

  if ($('#gsrtotal').val()==='') {
    $('#print_gsr').addClass('disabled')
  }
  else {
    $('#print_gsr').removeClass('disabled')
  }
});

function submit_scan(bc) {
  $.post(app.base_url+'penjualan/gsr_check', { param1: bc }, function(data){
    // console.log(data);
    $('#sp').val(data['product']);
    if (data['product']!='') {
      var printableObjects=[];  
      $.ajax({
        url: app.base_url+'penjualan/submit_scan/'+bc,
        type: 'GET',
        data: {},
      })
      .done(function(data) {
        if (data=='empty') {
          swal({
            title: 'Oops...',
            text: "Product sudah keluar!",
            type: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          }).then(function () {
            $('#sb').val('');$('#sp').val('');
          })
        }
        else if (data=='unlist') {
          swal('Oops...','Product tidak terdaftar!','error');
        }
        else {
          // console.log(data)
          printableObjects.push(data);
          printableObjects.forEach(function(d){
            printContent(d);
          });
          return printableObjects;
        }
      });
    }
    else swal('Oops...','Product tidak ada.','error');
  },'json');
}

function submit_grosir(bc) {
  $.post(app.base_url+'penjualan/gsr_check', { param1: bc }, function(data){
    // console.log(data);
    $('#gp').val(data['product']);
    if (data['product']!='') {
      var printableObjects=[];  
      $.ajax({
        url: app.base_url+'penjualan/submit_grosir/'+bc,
        type: 'GET',
        dataType: 'json'
      })
      .done(function(data) {
        // console.log(data);
        if (data['error']=='empty') {
          swal({
            title: 'Oops...',
            text: "Product sudah keluar!",
            type: 'warning',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Ok'
          }).then(function () {
            $('#gb').val('');$('#gp').val('');
          })
        }
        else if (data['error']=='unlist') {
          swal('Oops...','Product tidak terdaftar!','error');
        }
        else {
          $('#gb').val('');$('#gp').val('');
          $('#gb').focus();
          var tr
          var trs = [];
          for (var i = Object.keys(data).length - 1; i >= 0; i--) {
            tr = 
            '<tr>'+
              // '<td>'+data[i]['kode']+'</td>'+
              '<td>'+data[i]['product']+'</td>'+
              '<td>'+data[i]['hargasatuan']+'</td>'+
              '<td>'+data[i]['jumlah']+'</td>'+
              '<td>'+data[i]['diskon']+'</td>'+
              '<td class="text-right">'+data[i]['total']+'</td>'+
              '<td widtd="50" class="center"><a href="javascript:void(0)" onclick="hapus('+data[i]['id_product']+')"><i class="fa fa-trash text-red"></i></a></td>'+
            '</tr>';
            trs.push(tr);
          }
          var tbody_top = '<tbody id="grosir_list">';
          var tbody_bottom = '</tbody>';
          $('#grosir_list').html(trs);
          gettotal();
        }
      });
    }
    else swal('Oops...','Product tidak ada.','error');
  },'json');
  if ($('#gsrtotal').val()==='') {
    $('#print_gsr').addClass('disabled')
  }
  else {
    $('#print_gsr').removeClass('disabled')
  }
}

function gettotal() {
  $.ajax({
    url: app.base_url+'penjualan/get_total_grosir',
    type: 'GET',
    dataType: 'json',
  })
  .done(function(data) {
    $('#total').html(data)
    $('#gsrtotal').val(data)
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
  window.location.href = app.base_url+'penjualan';
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
    $.post(app.base_url+'penjualan/del_itm/'+key, function(data){
    },'json');
    sini();
  });
}

function sini() {
  var tr = 
      '<tr>'+
        '<td>&nbsp;</td>'+
        '<td>&nbsp;</td>'+
        '<td>&nbsp;</td>'+
        '<td>&nbsp;</td>'+
        '<td class="text-right">&nbsp;</td>'+
        '<td widtd="50" class="center"><a href="javascript:void(0);" disabled="disabled"><i class="fa fa-trash text-red"></i></a></td>'+
      '</tr>';
  $('#grosir_list').html(tr);
  $.ajax({
    url: app.base_url+'penjualan/grosir_list/',
    type: 'get',
    dataType: 'json',
    data: {}
  })
  .done(function(dataa) {
    console.log(dataa);
    var tr
    var trs = [];
    for (var i = Object.keys(dataa).length - 1; i >= 0; i--) {
      tr = 
      '<tr>'+
        // '<td>'+data[i]['kode']+'</td>'+
        '<td>'+dataa[i]['product']+'</td>'+
        '<td>'+dataa[i]['hargasatuan']+'</td>'+
        '<td>'+dataa[i]['jumlah']+'</td>'+
        '<td>'+dataa[i]['diskon']+'</td>'+
        '<td class="text-right">'+dataa[i]['total']+'</td>'+
        '<td widtd="50" class="center"><a href="javascript:void(0)" onclick="hapus('+dataa[i]['id_product']+')"><i class="fa fa-trash text-red"></i></a></td>'+
      '</tr>';
      trs.push(tr);
    }
    var tbody_top = '<tbody id="grosir_list">';
    var tbody_bottom = '</tbody>';
    $('#grosir_list').html(trs);
    gettotal();
  });
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
    $.post(app.base_url+'penjualan/del_all/', function(data){
    },'json');
    sini();
  });
}

function printgrosir() {
  var printableObjects=[];
  var gsrbayar = $('#gsrbayar').val();
  var kembali = $('#gsrkembalian').val();
  var potongan = $('#gsrpotongan').val();

  $.ajax({
    url: app.base_url+'penjualan/gsr_print/',
    type: 'GET',
    data: {pgsrbayar:gsrbayar,pgsrkembalian:kembali, gsrpotongan:potongan},
  })
  .done(function(data) {
    console.log(data);
    printableObjects.push(data);
    printableObjects.forEach(function(d){
      printContent(d);
    });
    return printableObjects;
  });
}