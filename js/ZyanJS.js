function refreshPage()
{ 
    location.reload(); 
}

function gotoPage(page)
{
    location.replace(page);
}

function Login()
{
    $("#alert_login").empty();
    $("#alert_login").append('<div class="alert alert-warning" role="alert"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กรุณารอสักครู่...</div>');
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
            if(data == 1)
            {
                $("#alert_login").empty();
                $("#alert_login").append('<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> เข้าสู่ระบบเรียบร้อยแล้ว กรุณารอสักครู่...</div>');

                setInterval('gotoPage("'+ submit[2] +'")', 3000);
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
            $("#login_btn").html('<i class="fa fa-sign-in"></i> เข้าสู่ระบบ');
        }
    })
}

function Register()
{
    $("#alert_register").empty();
    $("#alert_register").append('<div class="alert alert-warning" role="alert"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กรุณารอสักครู่...</div>');
    var elements_form = document.getElementById("register_frm").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var login_username = submit[0];
    var login_password = submit[1];
    var login_confirmpassword = submit[2];
    var login_email = submit[3];

    if(login_username == '')
    {
        $("#alert_register").empty();
        $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Username</div>');
        $("#username_input").focus();
        return false;
    }
    else if(login_password == '')
    {
        $("#alert_register").empty();
        $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Password</div>');
        $("#password_input").focus();
        return false;
    }
    else if(login_confirmpassword == '')
    {
        $("#alert_register").empty();
        $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอกยืนยัน Password</div>');
        $("#confirmpassword_input").focus();
        return false;
    }
    else if(login_email == '')
    {
        $("#alert_register").empty();
        $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Email</div>');
        $("#email_input").focus();
        return false;
    }

    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=register",
        data: "username="+ submit[0] +"&password="+ submit[1] +"&confirmpassword="+ submit[2] +"&email=" + submit[3],
        beforeSend: function() {
            document.getElementById("login_btn").disabled = true;
            document.getElementById("username_input").disabled = true;
            document.getElementById("password_input").disabled = true;
            document.getElementById("confirmpassword_input").disabled = true;
            document.getElementById("email_input").disabled = true;
            $("#login_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> สมัครสมาชิก');
        },
        success: function(data)
        {
            if(data == 7)
            {
                $("#alert_register").empty();
                $("#alert_register").append('<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> สมัครสมาชิกเรียบร้อยแล้ว กรุณารอสักครู่...</div>');

                setInterval('gotoPage("'+ submit[4] +'/?page=login")', 3000);
                // setTimeout(function(){location.href = login_success},3000);
            }
            else if(data == 0)
            {
                $("#alert_register").empty();
                $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Username ต้องมีความยาวมากกว่า  4ตัวขึ้นไป</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 1)
            {
                $("#alert_register").empty();
                $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Password ต้องมีความยาวมากกว่า 4 ตัว</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 2)
            {
                $("#alert_register").empty();
                $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> คุณกรอก Password ไม่ตรงกัน</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 3)
            {
                $("#alert_register").empty();
                $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> คุณกรอก E-Mail ไม่ถูกต้อง</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 4)
            {
                $("#alert_register").empty();
                $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> คุณสมัครสมาชิกถึงกำหนดที่ตั้งไว้แล้ว</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 5)
            {
                $("#alert_register").empty();
                $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> มี Username นี้ในระบบแล้ว</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 6)
            {
                $("#alert_register").empty();
                $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> เกิดข้อผิดพลาดในการเพิ่มลงฐานข้อมูล</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else
            {
                $("#alert_register").empty();
                $("#alert_register").append('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> เกิดข้อผิดพลาดไม่ทราบสาเหตุ</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }

            $("#login_btn").html('<i class="fa fa-user-plus"></i> สมัครสมาชิก');
        }
    })
}

function Logout(path)
{

    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=logout",
        beforeSend: function() {
            document.getElementById("logout_btn").disabled = true;
            $("#logout_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(data)
        {
            if(data == 1)
            {
                toastr["success"]('ออกจากระบบเรียบร้อยแล้ว...');
                setInterval('gotoPage("'+ path +'")', 3000);
                // setTimeout(function(){location.href = login_success},3000);
            }
            else
            {
                toastr["error"]('เกิดข้อผิดพลาดในการออกจากระบบ !');
                document.getElementById("logout_btn").disabled = false;
            }

            $("#logout_btn").html('<i class="fa fa-sign-out"></i> ออกจากระบบ');
        }
    })
}