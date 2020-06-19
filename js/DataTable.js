$(document).ready(function() {
    var table = $('#history_topup').DataTable( {
        responsive: true
    } );
 
    new $.fn.dataTable.FixedHeader(table);
} );