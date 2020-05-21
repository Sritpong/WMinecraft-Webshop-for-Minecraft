function refreshPage()
{ 
    location.reload(); 
}

function Login()
{
	$("#alert_login").empty();
	$("#alert_login").append('<div class="alert alert-info" role="alert"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กรุณารอสักครู่...</div>');
	var elements_form = document.getElementById("login_frm").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
		var item = elements_form.item(i);
        submit.push(item.value);
    }

    var login_username = submit[0];
    var login_password = submit[1];

    if(login_username == '')
    {
    	$("#alert_login").empty();
    	$("#alert_login").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Username</div>');
		$("#username_input").focus();
    	return false;
    }
    else if(login_password == '')
    {
    	$("#alert_login").empty();
    	$("#alert_login").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Password</div>');
		$("#password_input").focus();
    	return false;
    }

    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=login",
        data: "username="+ submit[0] +"&password="+ submit[1],
        beforeSend: function() {
            document.getElementById("login_btn").disabled = true;
            document.getElementById("username_input").disabled = true;
            document.getElementById("password_input").disabled = true;
            $("#login_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> เข้าสู่ระบบ');
        },
        success: function(data)
        {
        	console.log(data);
            if(data == 1)
            {
            	$("#alert_login").empty();
				$("#alert_login").append('<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> เข้าสู่ระบบเรียบร้อยแล้ว กรุณารอสักครู่...</div>');

                setInterval('refreshPage()', 3000);
                // setTimeout(function(){location.href = login_success},3000);
            }
            else if(data == 2)
            {
            	$("#alert_login").empty();
                $("#alert_login").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Password ไม่ถูกต้อง</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
            }
            else if(data == 0)
            {
            	$("#alert_login").empty();
                $("#alert_login").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> ไม่พบ Username นี้</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
            }
            $("#login_btn").html('เข้าสู่ระบบ');
        }
    })
}