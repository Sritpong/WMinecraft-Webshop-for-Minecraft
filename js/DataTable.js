$(document).ready(function() {
    var tableHistoryTopup = $('#history_topup').DataTable( {
        responsive: true
    } );
    
    var tableBackpack = $('#backpack_table').DataTable( {
        responsive: true
    } );

    var tableLoginLogs = $('#loginLogs_table').DataTable( {
        responsive: true
    } );

    var tableShopLogs = $('#shopLogs_Table').DataTable( {
        responsive: true
    } );

    var tableRefillLogs = $('#refilLogs_Table').DataTable( {
        responsive: true
    } );
 
    new $.fn.dataTable.FixedHeader(tableHistoryTopup);
    new $.fn.dataTable.FixedHeader(tableBackpack);
    new $.fn.dataTable.FixedHeader(tableLoginLogs);
    new $.fn.dataTable.FixedHeader(tableShopLogs);
    new $.fn.dataTable.FixedHeader(tableRefillLogs);
} );