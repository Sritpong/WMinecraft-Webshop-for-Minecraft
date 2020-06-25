function Login()
{
    $("#alert_login").html('<div class="alert alert-warning" role="alert"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กรุณารอสักครู่...</div>');
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
        $("#alert_login").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Username</div>');
        $("#username_input").focus();
        return false;
    }
    else if(login_password == '')
    {
        $("#alert_login").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Password</div>');
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
                $("#alert_login").html('<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> เข้าสู่ระบบเรียบร้อยแล้ว กรุณารอสักครู่...</div>');
                toastr["success"]('เข้าสู่ระบบเรียบร้อยแล้ว !');

                setTimeout(function(){location.href = submit[2]},3000);
            }
            else if(data == 2)
            {
                $("#alert_login").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Password ไม่ถูกต้อง</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
            }
            else if(data == 0)
            {
                $("#alert_login").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> ไม่พบ Username นี้</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
            }
            
            $("#login_btn").html('<i class="fa fa-sign-in"></i> เข้าสู่ระบบ');
        }
    })
}

function chkRegister()
{
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
        $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Username</div>');
        $("#username_input").focus();
        return false;
    }
    else if(login_password == '')
    {
        $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Password</div>');
        $("#password_input").focus();
        return false;
    }
    else if(login_confirmpassword == '')
    {
        $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอกยืนยัน Password</div>');
        $("#confirmpassword_input").focus();
        return false;
    }
    else if(login_email == '')
    {
        $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Email</div>');
        $("#email_input").focus();
        return false;
    }

    $("#modal_reg_username").html('Username: ' + login_username);
    $("#modal_reg_email").html('Email: ' + login_email);

    $('#confirmRegModal').modal('show');
}

function Register()
{
    $('#confirmRegModal').modal('hide');

    $("#alert_register").html('<div class="alert alert-warning" role="alert"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กรุณารอสักครู่...</div>');
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
        $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Username</div>');
        $("#username_input").focus();
        return false;
    }
    else if(login_password == '')
    {
        $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Password</div>');
        $("#password_input").focus();
        return false;
    }
    else if(login_confirmpassword == '')
    {
        $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอกยืนยัน Password</div>');
        $("#confirmpassword_input").focus();
        return false;
    }
    else if(login_email == '')
    {
        $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Email</div>');
        $("#email_input").focus();
        return false;
    }

    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=register",
        data: "username="+ submit[0] +"&password="+ submit[1] +"&confirmpassword="+ submit[2] +"&email=" + submit[3],
        beforeSend: function() {
            document.getElementById("button_chkregister").disabled = true;
            document.getElementById("username_input").disabled = true;
            document.getElementById("password_input").disabled = true;
            document.getElementById("confirmpassword_input").disabled = true;
            document.getElementById("email_input").disabled = true;
            $("#button_chkregister").html('<i class="fa fa-spinner fa-spin fa-lg"></i> สมัครสมาชิก');
        },
        success: function(data)
        {
            if(data == 7)
            {
                $("#alert_register").html('<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> สมัครสมาชิกเรียบร้อยแล้ว กรุณารอสักครู่...</div>');
                toastr["success"]('สมัครสมาชิกเรียบร้อยแล้ว !');

                setTimeout(function(){location.href = submit[4] + '/?page=login'}, 3000);
            }
            else if(data == 0)
            {
                $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Username ต้องมีความยาวมากกว่า  4ตัวขึ้นไป</div>');

                document.getElementById("button_chkregister").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 1)
            {
                $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Password ต้องมีความยาวมากกว่า 4 ตัว</div>');

                document.getElementById("button_chkregister").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 2)
            {
                $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> คุณกรอก Password ไม่ตรงกัน</div>');

                document.getElementById("button_chkregister").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 3)
            {
                $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> คุณกรอก E-Mail ไม่ถูกต้อง</div>');

                document.getElementById("button_chkregister").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 4)
            {
                $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> คุณสมัครสมาชิกถึงกำหนดที่ตั้งไว้แล้ว</div>');

                document.getElementById("button_chkregister").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 5)
            {
                $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> มี Username นี้ในระบบแล้ว</div>');

                document.getElementById("button_chkregister").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else if(data == 6)
            {
                $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> เกิดข้อผิดพลาดในการเพิ่มลงฐานข้อมูล</div>');

                document.getElementById("button_chkregister").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }
            else
            {
                $("#alert_register").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> เกิดข้อผิดพลาดไม่ทราบสาเหตุ</div>');

                document.getElementById("button_chkregister").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
                document.getElementById("confirmpassword_input").disabled = false;
                document.getElementById("email_input").disabled = false;
            }

            $("#button_chkregister").html('<i class="fa fa-user-plus"></i> สมัครสมาชิก');
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
                setTimeout(function(){location.href = path},2000);
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

function Topup()
{
    var wallet_transaction = document.getElementById("transaction_wallet").value;
    if(wallet_transaction == '')
    {
        toastr["error"]('กรุณากรอกหมายเลขอ้างอิง !');
        return false;
    }
    else if(wallet_transaction.length <= 13)
    {
        toastr["error"]('กรุณากรอกหมายเลขอ้างอิงให้ถูกต้อง !');
        return false;
    }

    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=topup",
        data: "transaction_wallet="+ wallet_transaction,
        beforeSend: function() {
            document.getElementById("btn_topup").disabled = true;
            $("#btn_topup").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(data)
        {
            var res = data.split("|");
            
            if(res[0] == 2)
            {
                document.getElementById("transaction_wallet").value = "";
                var divplayerPoints = $('#player_points')[0].textContent.split(' ');
                var points = parseFloat(divplayerPoints[1].replace(',','')) + parseFloat(res[1]);
                $('#player_points').html("Points: <b>" + points.toFixed(2) + "</b>");

                var today = new Date();
                var date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();

                var htmlTbody = "";
                htmlTbody += "<td>";
                htmlTbody += "New..";
                htmlTbody += "</td>";
                htmlTbody += "<td>";
                htmlTbody += "TrueWallet";
                htmlTbody += "</td>";
                htmlTbody += "<td>";
                htmlTbody += wallet_transaction;
                htmlTbody += "</td>";
                htmlTbody += "<td>";
                htmlTbody += date;
                htmlTbody += "</td>";
                htmlTbody += "<td>";
                htmlTbody += time;
                htmlTbody += "</td>";
                $("#tbody_history_topup").append("<tr>" + htmlTbody + "</tr>");

                toastr["success"]('คุณได้ทำการเติมเงิน ' + res[1] + ' บาท');
            }
            else if(res[0] == 0)
            {
                toastr["error"]('กรุณาตั้งค่าระบบเติมเงิน [Admin]');
            }
            else if(res[0] == 1)
            {
                toastr["error"]('กรุณากรอกหมายเลขอ้างอิงให้ถูกต้อง !');
            }
            else if(res[0] == 3)
            {
                toastr["error"]('เกิดข้อผิดพลาดหรือไม่พบหมายเลขอ้างอิงนี้ !');
            }
            else if(res[0] == 4)
            {
                toastr["error"]('เกิดข้อผิดพลาดในการ Update Points !');
            }
            else if(res[0] == 5)
            {
                toastr["error"]('เกิดข้อผิดพลาดในการโหลดข้อมูลจาก Wallet !');
            }
            else if(res[0] == 6)
            {
                toastr["error"]('กรุณาเข้าสู่ระบบก่อนเติมเงิน !');
            }
            else if(res[0] == 7)
            {
                toastr["error"]('กรุณากรอกเฉพาะตัวเลขเท่านั้น !');
            }
            else if(res[0] == 8)
            {
                toastr["error"]('เกิดข้อผิดพลาดไม่ทราบสาเหตุ !');
            }
            else if(res[0] == 9)
            {
                toastr["error"]('หมาบเลขอ้างอิงนี้ถูกใช้งานไปแล้ว !');
            }

            document.getElementById("btn_topup").disabled = false;
            $("#btn_topup").html('<i class="fa fa-slack"></i> เติมเงิน');
        }
    })
}

function LoginBackend()
{
    $("#alert_login").html('<div class="alert alert-warning" role="alert"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กรุณารอสักครู่...</div>');
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
        $("#alert_login").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Username</div>');
        $("#username_input").focus();
        return false;
    }
    else if(login_password == '')
    {
        $("#alert_login").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> กรุณากรอก Password</div>');
        $("#password_input").focus();
        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=login",
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
                $("#alert_login").html('<div class="alert alert-success" role="alert"><i class="fa fa-check"></i> เข้าสู่ระบบเรียบร้อยแล้ว กรุณารอสักครู่...</div>');
                toastr["success"]('เข้าสู่ระบบเรียบร้อยแล้ว !');

                document.getElementById("login_btn").disabled = true;
                setTimeout(function(){location.href = submit[2]},3000);
            }
            else if(data == 2)
            {
                $("#alert_login").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> Password ไม่ถูกต้อง</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
            }
            else if(data == 0)
            {
                $("#alert_login").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> ไม่พบ Username นี้</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
            }
            else if(data == 3)
            {
                $("#alert_login").html('<div class="alert alert-danger" role="alert"><i class="fa fa-exclamation-triangle"></i> คุณไม่ได้รับสิทธิ์ในการเข้าใช้งานระบบหลังร้าน</div>');

                document.getElementById("login_btn").disabled = false;
                document.getElementById("username_input").disabled = false;
                document.getElementById("password_input").disabled = false;
            }

            $("#login_btn").html('<i class="fa fa-sign-in"></i> เข้าสู่ระบบ');
        }
    })
}

function LogoutBackend(path)
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=logout",
        beforeSend: function() {
            document.getElementById("logout_btn").disabled = true;
            $("#logout_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(data)
        {
            if(data == 1)
            {
                toastr["success"]('ออกจากระบบเรียบร้อยแล้ว...');
                setTimeout(function(){location.href = path + "/backend"},2000);
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

function BuyShop(id)
{
    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=getDetailShop",
        data: "item_id=" + id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถโหลดข้อมูลสินค้าได้ในขณะนี้",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่พบสินค้านี้",
                    icon: "error",
                    button: true,
                });
            }
            else
            {
                var detailItem = data.split("|");
                swal(
                {
                    title: "ซื้อไอเทม",
                    text: "ยืนยันการซื้อ " + detailItem[1] + " ราคา " + detailItem[2] + " พ้อยท์",
                    icon: "warning",
                    buttons: {
                        cancel: "ยกเลิก",
                        true: "ยืนยันการซื้อ " + detailItem[1]
                    },
                    dangerMode: true,
                })
                .then((confirm) =>
                {
                    if(confirm)
                    {
                        $.ajax({
                            type: "POST",
                            url: "application/Controller/member.php?func=buyItemShop",
                            beforeSend: function() {
                                toastr["info"]('กรุณารอสักครู่...');
                            },
                            data: "item_id=" + id,
                            success: function(data)
                            {
                                toastr.clear();

                                if(data == 0)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่สามารถซื้อสินค้าได้ขณะนี้ กรุณาลองใหม่ภายหลัง",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(data == 1)
                                {
                                    swal(
                                    {
                                        title: "สำเร็จ !",
                                        text: "คุณได้ทำการซื้อ " + detailItem[1] + " เรียบร้อยแล้ว",
                                        icon: "success",
                                        button: true,
                                    })
                                    .then((ok_success_buy) =>
                                    {
                                        if(ok_success_buy)
                                        {
                                            location.reload();
                                        }
                                    });
                                }
                                else if(data == 2)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่พบสินค้านี้",
                                        icon: "error",
                                        button: true,
                                    })
                                    .then((ok_success_buy) =>
                                    {
                                        if(ok_success_buy)
                                        {
                                            location.reload();
                                        }
                                    });
                                }
                                else if(data == 3)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่สามารถเชื่อมต่อ Server ได้",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(data == 4)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่สามารถอัพเดทพ้อยท์ของ Player ได้",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(data == 5)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่สามารถเก็บประวัติการซื้อสินค้าได้",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(data == 6)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่สามารถซื้อได้เนื่องจากพ้อยท์ไม่เพียงพอ",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(data == 500)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "กรุณาเข้าสู่ระบบก่อนซื้อสินค้า",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่ทราบสาเหตุ",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                            }
                        })
                    }
                });
            }
        }
    })
}

function EditWalletAccount()
{
    var email = $('#email_wallet').val();
    var password = $('#password_wallet').val();

    if(email == "" || email == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอก Email ก่อนบันทึก",
            icon: "error",
            button: true,
        });

        return false;
    }
    else if(password == "" || password == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอก Password ก่อนบันทึก",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=EditWalletSetting",
        data: "email=" + email + "&password=" + password,
        beforeSend: function() {
            document.getElementById("walletSetting_btn").disabled = true;
            $("#walletSetting_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(data)
        {
            if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ตั้งค่าบัญชี Wallet สำเร็จ",
                    icon: "success",
                    button: true,
                })
                .then((ok_otp_wallet) =>
                {
                    if(ok_otp_wallet)
                    {
                        location.reload();
                    }
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถบันทึกข้อมูลได้",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณากรอก Email หรือ Password",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 500)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "คุณไม่ได้รับสิทธิ์ในการใช้งาน",
                    icon: "error",
                    button: true,
                });
            }

            document.getElementById("walletSetting_btn").disabled = false;
            $("#walletSetting_btn").html('<i class="fa fa-check"></i> บันทึก');
        }
    })
}

function getOTPAccessToken()
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=getOTPAccessToken",
        beforeSend: function()
        {
            document.getElementById("getAccessToken_btn").disabled = true;
            $("#getAccessToken_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(res)
        {
            console.log(res);
            var data = res.split("|");

            if(data[0] == 500)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "คุณไม่ได้รับสิทธิ์ในการใช้งาน",
                    icon: "error",
                    button: true,
                });
            }
            else if(data[0] == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถรับ OTP ได้ขณะนี้",
                    icon: "error",
                    button: true,
                });    
            }
            else if(data[0] == 1)
            {
                swal("OTP ถูกส่งไปที่เบอร์ "+ data[1] +" (Ref: "+ data[2] +")",
                {
                    content: "input",
                })
                .then((value) =>
                {
                    if(`${value}` != null)
                    {
                        $.ajax({
                            type: "POST",
                            url: "../application/Controller/backend.php?func=submitOTP",
                            data: "ref=" + data[2] + "&phone=" + data[1] + "&otp=" + `${value}`,
                            success: function(data)
                            {
                                if(data == 1)
                                {
                                    swal(
                                    {
                                        title: "สำเร็จ !",
                                        text: "รับ Access Token เรียบร้อยแล้ว",
                                        icon: "success",
                                        button: true,
                                    })
                                    .then((ok_otp_wallet) =>
                                    {
                                        if(ok_otp_wallet)
                                        {
                                            location.reload();
                                        }
                                    });
                                }
                                else if(data == 2)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "OTP ผิด หรือ ไม่สามารถรับ Access Token ได้ขณะนี้",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(data == 0)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่สามารถอัพเดท Access Token ลงฐานข้อมูลขณะนี้",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(data == 500)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "คุณไม่ได้รับสิทธิ์ในการใช้งาน",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                            }
                        })
                    }
                });  
            }

            document.getElementById("getAccessToken_btn").disabled = false;
            $("#getAccessToken_btn").html('<i class="fa fa-cloud"></i> รับ Access Token');
        }
    })
}

function redeemCode()
{
    var code = $('#input_code').val();

    if(code == "" || code == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "คุณยังไม่ได้กรอก Code",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=redeemcode",
        data: "code=" + code,
        beforeSend: function()
        {
            document.getElementById("code_btn").disabled = true;
            $("#code_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(data)
        {
            if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "คุณได้ทำการเติมโค้ด "+ code +" เรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "Code ถูกใช้งานไปแล้ว",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 3)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถเก็บข้อมูลการเติม Code ได้ขณะนี้",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 4)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถเชื่อมต่อ Server ได้",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 5)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่พบ Code ที่คุณกรอก",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 500)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณาเข้าสู่ระบบก่อน",
                    icon: "error",
                    button: true,
                });
            }
            else
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดการเติม Code ไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }

            document.getElementById("code_btn").disabled = false;
            $("#code_btn").html('<i class="fa fa-check"></i><br>ดำเนินการต่อ');
        }
    })
}

function receiveDiary()
{
    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=receiveDiary",
        beforeSend: function()
        {
            document.getElementById("diary_btn").disabled = true;
            $("#diary_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(data)
        {
            console.log(data);
            if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "เช็คชื่อรับของประจำวันเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((ok_receiveDiary) =>
                {
                    if(ok_receiveDiary)
                    {
                        location.reload();
                    }
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "คุณได้ทำการเช็คชื่อรับของประจำวันไปแล้ว",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 3)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถเพิ่มประวัติการเช็คชื่อรับของประจำวันได้",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 4)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถเพิ่มของไปยังกระเป๋าบน Webshop ได้",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "วันนี้ไม่มีเช็คชื่อรับของประจำวัน",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 500)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณาเข้าสู่ระบบก่อน",
                    icon: "error",
                    button: true,
                });
            }
            else
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }

            document.getElementById("diary_btn").disabled = false;
            $("#diary_btn").html('เช็คชื่อ !');
        }
    })
}