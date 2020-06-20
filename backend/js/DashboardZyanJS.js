$(document).ready(function()
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=getDetailDashboard",
        success: function(data)
        {
        	if(data != 0)
        	{
        		var setHtml = data.split("|");

	        	$("#player_login").html(setHtml[1]);
	            $("#all_player").html('<i class="fa fa-exclamation-circle mr-1" aria-hidden="true"></i> จากทั้งหมด ' + setHtml[0] + ' ผู้เล่น');
	        	$("#topup_today").html(setHtml[2] + "฿");
                $("#shopAll").html('<i class="fa fa-bookmark-o mr-1" aria-hidden="true"></i> สินค้ามีทั้งหมด '+ setHtml[3] +' ชิ้น');
                $("#shopLogsToday").html(setHtml[4]);
        	}
        }
    })
});