$(function() {
  $('table[for="stock"]').DataTable({
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