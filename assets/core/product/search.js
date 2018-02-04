$(function() {
  $('table[for="search"]').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": true,
    "pageLength": 15,
    "autoWidth": false
  });
});