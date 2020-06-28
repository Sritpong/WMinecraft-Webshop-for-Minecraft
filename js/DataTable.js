$(document).ready(function() {
    var tableHistoryTopup = $('#history_topup').DataTable( {
        responsive: true
    } );
    
    var tableBackpack = $('#backpack_table').DataTable( {
        responsive: true
    } );
 
    new $.fn.dataTable.FixedHeader(tableHistoryTopup);
    new $.fn.dataTable.FixedHeader(tableBackpack);
} );