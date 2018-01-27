$(function() {
  // scand barcode
  var pressed = false; 
  var chars = []; 
  $(window).keypress(function(e) {
    if (e.which >= 48 && e.which <= 57) {
        chars.push(String.fromCharCode(e.which));
    }
    // console.log(e.which + ":" + chars.join("|"));
    if (pressed == false) {
      setTimeout(function(){
        if (chars.length >= 10) {
          var barcode = chars.join("");
          // console.log("Barcode Scanned: " + barcode);
          // assign value to some input (or do whatever you want)
          // $('input[name="barcode"]').val(barcode);
          
          /*** ============================================= ***/
          // var bc = $(this).val();
          $.post(app.base_url+'penjualan/gsr_check', { param1: barcode }, function(data){
            // console.log(data);
            $('input[name="product"]').val(data['product']);
            if (data['product']!='') {
              var printableObjects=[];  
              $.ajax({
                url: app.base_url+'penjualan/submit_scan/'+barcode,
                type: 'GET',
                data: {},
              })
              .done(function(data) {
                if (data=='empty') {
                  // swal('Oops...','Product sudah keluar!','error');
                  swal({
                    title: 'Oops...',
                    text: "Product sudah keluar!",
                    type: 'warning',
                    // showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    // cancelButtonColor: '#d33',
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
                // window.location.href = app.base_url+'penjualan';
              });
            }
            else swal('Oops...','Product tidak ada.','error');
          },'json');
          /*** ============================================= ***/

        }
        chars = [];
        pressed = false;
      },500);
    }
    pressed = true;
  });

  // $('input[name="barcode"]').on("keypress", function() {
  //   var bc = $(this).val();
  //   $.post(app.base_url+'penjualan/gsr_check', { param1: bc }, function(data){
  //     // console.log(data);
  //     $('input[name="product"]').val(data['product']);
  //     if (data['product']!='') {
  //       var printableObjects=[];  
  //       $.ajax({
  //         url: app.base_url+'penjualan/submit_scan/'+bc,
  //         type: 'GET',
  //         data: {},
  //       })
  //       .done(function(data) {
  //         if (data=='empty') {
  //           // swal('Oops...','Product sudah keluar!','error');
  //           swal({
  //             title: 'Oops...',
  //             text: "Product sudah keluar!",
  //             type: 'warning',
  //             // showCancelButton: true,
  //             confirmButtonColor: '#3085d6',
  //             // cancelButtonColor: '#d33',
  //             confirmButtonText: 'Ok'
  //           }).then(function () {
  //             $('#sb').val('');$('#sp').val('');
  //           })
  //         }
  //         else if (data=='unlist') {
  //           swal('Oops...','Product tidak terdaftar!','error');
  //         }
  //         else {
  //           // console.log(data)
  //           printableObjects.push(data);
  //           printableObjects.forEach(function(d){
  //             printContent(d);
  //           });
  //           return printableObjects;
  //         }
  //         // window.location.href = app.base_url+'penjualan';
  //       });
  //     }
  //     else swal('Oops...','Product tidak ada.','error');
  //   },'json');
  // });

  // product 
  $('input[name="bc"]').on("keypress", function() {
    var bc = $(this).val();
    $.post(app.base_url+'penjualan/gsr_check', { param1: bc }, function(data){
      $('input[name="pd"]').val(data['product']);
      $('input[name="hg"]').val(data['harga']);
    },'json')
  });

  // stock
  $('input[name="jm"]').on("keyup", function() {
    var jm = $(this).val();
    var bc = $('input[name="bc"]').val();
    $.ajax({
      url: app.base_url+'penjualan/gsr_stock/',
      type: 'POST',
      data: {param1: bc},
    })
    .done(function(data) {
      if (parseInt(data)<=jm) {
        swal('Oops...','Stock tidak mencukupi.\n\ Sisa stock '+data+' pcs.','error');
      }
    });
    
    var hg = $('input[name="hg"]').val();
    var tl = parseInt(jm)* parseInt(hg);
    $('input[name="tl"]').val(tl);
  });

  // discount
  $('input[name="ds"]').on("keyup", function() {
    var ds = $(this).val();
    var jm = $('input[name="jm"]').val();
    var hg = $('input[name="hg"]').val();
    var tl = parseInt(jm)* parseInt(hg);
    var cc = tl - (Math.round((parseInt(ds)/100)*tl));
    $('input[name="tl"]').val(cc);
  });

  $('input[name="submit_scn"]').click(function() {
    var a = $('#sb').val();
    var sb = $('#sb').val();
    var sp = $('#sp').val();
    if (sb=='' || sp=='') {
      swal('Oops...','Field masih kosong','error');
    }
    else {
      var printableObjects=[];  
      $.ajax({
        url: app.base_url+'penjualan/submit_scan/'+a,
        type: 'GET',
        data: {},
      })
      .done(function(data) {
        var s = data;
        if (data=='empty') {
          swal('Oops...','Product sudah keluar!','error');
        }
        else if (data=='unlist') {
          swal('Oops...','Product tidak terdaftar!','error');
        }
        else {
          printableObjects.push(data);  // pushing response to array.
          printableObjects.forEach(function(d){
            printContent(d);
          });
          return printableObjects;
        }
      });
    }
  });

  $('input[name="submit_grs"]').click(function() {
    var bc = $('#bc').val();
    var pd = $('#pd').val();
    var hg = $('#hg').val();
    var jm = $('#jm').val();
    var ds = $('#ds').val();
    var tl = $('#tl').val();
    if (bc=='' || pd=='' || hg=='' || jm=='' || tl=='') {
      swal('Oops...','Field masih kosong','error');
    }
    else {
      $.post(app.base_url+'penjualan/gsr_check', { param1: bc }, function(data){
        if (data['stock'] < jm) {
          swal('Oops...','Stock tidak mencukupi. Stock tersisa '+data['stock']+'!','error');
        }
        else {
          // console.log('bc '+bc, 'pd '+pd, 'hg '+hg, 'jm '+jm, 'ds '+ds, 'tl '+tl);
          $.ajax({
            url: app.base_url+'penjualan/grosir_insert',
            type: 'POST',
            // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
            data: {pbarcode:bc, pproduct:pd, pharga:hg, pjumlah:jm, pdiskon:ds, ptotal:tl},
          })
          .done(function() {
            window.location.href = app.base_url+'penjualan';
          })
          .fail(function() {
            console.log("error");
          });
          
        }
      },'json');
    }
  })

  $('#print_row').click(function(event) {
    var printableObjects=[];
    var total = $('#sumharga').val();
    $.ajax({
      url: app.base_url+'penjualan/print_gsr/',
      type: 'POST',
      data: {totalbelanaja:total},
    })
    .done(function(e) {
      // console.log(e);
      // console.log("success");
      printableObjects.push(e);  // pushing response to array.
      printableObjects.forEach(function(d){
        printContent(d);
      });
      return printableObjects;
    })
    .fail(function() {
      swal('Oops...','Tidak ada transaksi','error');
    });
  });

  $('#dt').click(function(event) {
    $('input[name="bc"]').val('');
    $('input[name="pd"]').val('');
    $('input[name="hg"]').val('');
    $('input[name="jm"]').val('');
    $('input[name="ds"]').val('');
    $('input[name="tl"]').val('');
  });


  // $('input[name="barcode"]').keypress(function(e){
  //   if ( e.which === 13 ) {
  //       console.log('--- '+e.preventDefault());
  //   }
  // });
});

function printContent(printDoc){
  var newWin = window.open();
  var restorepage = document.body.innerHTML;
  var printcontent = printDoc;
  newWin.document.body.innerHTML = printcontent;
  // window.print();
  newWin.print();
  newWin.document.body.innerHTML = restorepage;
  newWin.close();
  window.location.href = app.base_url+'penjualan';

  // newWin.document.write(WhatsApp);
  // newWin.document.close();
  // newWin.focus();
  // newWin.print();
  // newWin.close();
}

function hapus(key,no) {
  swal({
    title: "Apa anda yakin?",
    text: "Data "+no+" berikut akan dihapus!",
    provider: "warning",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Hapus!',
    cancelButtonText: 'Batal'
  }).then(function (isConfirm) {
    if (isConfirm) {
      window.location.href = app.base_url+'penjualan/del_itm/'+key;
    }
  });
}