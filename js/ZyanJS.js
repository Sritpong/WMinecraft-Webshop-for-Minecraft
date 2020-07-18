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

                setTimeout(function(){location.href = document.getElementById("path").value},3000);
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
    });
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

                setTimeout(function(){location.href = document.getElementById("path").value + '/?page=login'}, 3000);
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
    });
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
    });
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
        url: "application/Controller/wallet.php?func=topup",
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

                swal(
                {
                    title: "สำเร็จ !",
                    text: "คุณได้ทำการเติมเงิน " + res[1] + " บาท",
                    icon: "success",
                    button: true,
                })
                .then((ok_topupWallet) =>
                {
                    if(ok_topupWallet)
                    {
                        location.reload();
                    }
                });
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
                toastr["error"]('หมายเลขอ้างอิงนี้ถูกใช้งานไปแล้ว !');
            }

            document.getElementById("btn_topup").disabled = false;
            $("#btn_topup").html('<i class="fa fa-slack"></i> เติมด้วย TrueWallet');
        }
    });
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
    });
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
    });
}

function BuyShop(id,type)
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
                var textShow = "";

                if(type == 1)
                {
                    textShow = "ยืนยันการซื้อ " + detailItem[1] + " ราคา " + detailItem[2] + " พ้อยท์";
                }
                else if(type == 2)
                {
                    textShow = "ยืนยันการซื้อ " + detailItem[1] + " ราคา " + detailItem[2] + " พ้อยท์ (เก็บเข้าคลัง)";
                }

                swal(
                {
                    title: "ซื้อไอเทม",
                    text: textShow,
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
                        if(type == 1)
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
                        else if(type == 2)
                        {
                            $.ajax({
                                type: "POST",
                                url: "application/Controller/member.php?func=buyItemShopInventory",
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
                                            text: "ไม่สามารถซื้อได้เนื่องจากพ้อยท์ไม่เพียงพอ",
                                            icon: "error",
                                            button: true,
                                        });
                                    }
                                    else if(data == 4)
                                    {
                                        swal(
                                        {
                                            title: "เกิดข้อผิดพลาด !",
                                            text: "ไม่สามารถเพิ่มสินค้าเข้ากระเป๋าผู้เล่นได้",
                                            icon: "error",
                                            button: true,
                                        });
                                    }
                                    else if(data == 5)
                                    {
                                        swal(
                                        {
                                            title: "เกิดข้อผิดพลาด !",
                                            text: "ไม่สามารถอัพเดทพ้อยท์ของ Player ได้",
                                            icon: "error",
                                            button: true,
                                        });
                                    }
                                    else if(data == 6)
                                    {
                                        swal(
                                        {
                                            title: "เกิดข้อผิดพลาด !",
                                            text: "ไม่สามารถเก็บประวัติการซื้อสินค้าได้",
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
                    }
                });
            }
        }
    });
}

function EditWalletAccount()
{
    var email = $('#email_wallet').val();
    var password = $('#password_wallet').val();
    var mutiple = $('#mutiple_wallet').val();

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

    if(password == "" || password == undefined)
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

    if(mutiple == "" || mutiple == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกช่อง Mutiple (จำนวนการคูณเวลาเติมเงิน)",
            icon: "error",
            button: true,
        });

        return false;
    }
    if(mutiple == "0")
    {
        mutiple = "1";
    }


    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=EditWalletSetting",
        data: "email=" + email + "&password=" + password + "&mutiple=" + mutiple,
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
                    text: "กรุณากรอก Email, Password หรือ จำนวนการคูณเวลาเติมเงิน",
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
    });
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
    });
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
    });
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
    });
}

function receiveBackpack(id)
{
    if(id == "" || id == undefined)
    {
        return false;
    }

     $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=receiveBackpack",
        data: "backpack_id=" + id,
        beforeSend: function()
        {
            document.getElementById("receiveBackpack_" + id).disabled = true;
            $("#receiveBackpack_" + id).html('<i class="fa fa-spinner fa-spin fa-lg"></i>');
        },
        success: function(data)
        {
            if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ระบบได้ทำการส่งเข้าไปใน Server เรียบร้อยแล้ว",
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
                    text: "ของชิ้นนี้คุณรับไปแล้ว",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 3)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถอัพเดทสถานะของได้ กรุณาลองใหม่ภายหลัง",
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

            document.getElementById("receiveBackpack_" + id).disabled = false;
            $("#receiveBackpack_" + id).html('รับ..');
        }
    });
}

function addItemRandombox(id)
{
    var name = $("#item_name").val();
    var percent = $("#item_percent").val();
    var img = $("#item_img").val();
    var command = $("#item_command").val();
    var server = $("#for_sv").val();
    
    if(name == "" || name == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกชื่อไอเทม",
            icon: "error",
            button: true,
        });
        return false;
    }

    if(percent == "" || percent == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอก %",
            icon: "error",
            button: true,
        });
        return false;
    }

    if(img == "" || img == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอก URL รูปภาพ",
            icon: "error",
            button: true,
        });
        return false;
    }

    if(command == "" || command == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกคำสั่ง",
            icon: "error",
            button: true,
        });
        return false;
    }

    if(server == "" || server == "0" || server == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือก Server",
            icon: "error",
            button: true,
        });
        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=addItemRandombox",
        data: "randombox_id=" + id + "&name=" + name + "&percent=" + percent +
        "&img=" + img + "&command=" + command + "&server=" + server,
        beforeSend: function() {
            document.getElementById("addItemRandombox_btn").disabled = true;
            $("#addItemRandombox_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(data)
        {
            if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "เพิ่มไอเทมลงกล่องสุ่มเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((ok_addItemRandombox) =>
                {
                    if(ok_addItemRandombox)
                    {
                        location.reload();
                    }
                });
            }
            else if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณากรอก Percent ให้เป็นตัวเลขเท่านั้น !",
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

            document.getElementById("addItemRandombox_btn").disabled = false;
            $("#addItemRandombox_btn").html('เพิ่มไอเทม');
        }
    });
}

function randombox(id)
{
    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=getDetailRandomBox",
        data: "randombox_id=" + id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่มีกล่องสุ่มนี้",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่มีไอเทมในกล่องสุ่มนี้",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กล่องสุ่มนี้ไม่ได้เปิดใช้งาน",
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
                var detail = data.split("|");
                swal(
                {
                    title: "สุ่มไอเทม",
                    text: "ยืนยันการสุ่มกล่อง " + detail[1] + " ราคา " + detail[2] + " พ้อยท์",
                    icon: "warning",
                    buttons: {
                        cancel: "ยกเลิก",
                        true: "ยืนยันการสุ่ม " + detail[1]
                    },
                    dangerMode: true,
                })
                .then((confirm) =>
                {
                    if(confirm)
                    {
                        $.ajax({
                            type: "POST",
                            url: "application/Controller/member.php?func=RandomBox",
                            data: "randombox_id=" + id,
                            success: function(res)
                            {
                                if(res == 0)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่มีกล่องสุ่มนี้",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(res == 1)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่มีไอเทมในกล่องสุ่มนี้",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(res == 3)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่สามารถเพิ่มของที่สุ่มได้เข้ากระเป๋าผู้เล่นได้",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(res == 4)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "ไม่สามารถหักพ้อยท์ได้ขณะนี้ กรุณาสุ่มใหม่ภายหลัง",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else if(res == 5)
                                {
                                    swal(
                                    {
                                        title: "เกิดข้อผิดพลาด !",
                                        text: "พ้อยท์ของคุณไม่เพียงพอต่อการสุ่มกล่องนี้",
                                        icon: "error",
                                        button: true,
                                    });
                                }
                                else
                                {
                                    var split_result = res.split("|");
                                    if(split_result[0] == '2')
                                    {
                                        swal(
                                        {
                                            title: "สำเร็จ !",
                                            text: "คุณสุ่มได้ " + split_result[1] + " ของจะส่งเข้ากระเป๋าผู้เล่น",
                                            icon: "success",
                                            button: true,
                                        })
                                        .then((ok_receiveRandombox) =>
                                        {
                                            if(ok_receiveRandombox)
                                            {
                                                location.reload();
                                            }
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
                                }
                            }
                        });
                    }
                });
            }
        }
    });
}

function searchPlayer()
{
    var elements_form = document.getElementById("player_search").elements;
    var submit = [];

    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var player_search = submit[0];

    if(player_search == '')
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกชื่อผู้เล่นที่จะค้นหา",
            icon: "error",
            button: true,
        });
        return false;
    }

    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=searchPlayer",
        beforeSend: function(){
            document.getElementById("button_search_player").disabled = true;
            $("#button_search_player").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        data: "search_username=" + player_search,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาด",
                    icon: "error",
                    button: true,
                });

                document.getElementById("button_search_player").disabled = false;
                $("#button_search_player").html('<i class="fa fa-search"></i> ค้นหา');
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ชื่อผู้เล่นห้ามว่าง",
                    icon: "error",
                    button: true,
                });

                document.getElementById("button_search_player").disabled = false;
                $("#button_search_player").html('<i class="fa fa-search"></i> ค้นหา');
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่พบชื่อผู้เล่นนี้",
                    icon: "error",
                    button: true,
                });

                document.getElementById("button_search_player").disabled = false;
                $("#button_search_player").html('<i class="fa fa-search"></i> ค้นหา');
            }
            else if(data == 3)
            {
                setTimeout(function(){location.href = document.getElementById("path").value + "/?page=player"},3000);
            }
            else
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาด ไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });

                document.getElementById("button_search_player").disabled = false;
                $("#button_search_player").html('<i class="fa fa-search"></i> ค้นหา');
            }
        }
    });
}

function report()
{
    var elements_form = document.getElementById("report_frm").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var descr = submit[0];
    var img = submit[1];

    if(descr == "" || descr == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกรายละเอียด",
            icon: "error",
            button: true,
        });
        return false;
    }

    $.ajax({
        type: "POST",
        url: "application/Controller/member.php?func=reportPlayer",
        beforeSend: function(){
            document.getElementById("report_btn").disabled = true;
            $("#report_btn").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        data: "descr=" + descr + "&img=" + img + "&uid=" + $('#uid_person').val(),
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "แจ้งรายงานเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((ok_sendReport) =>
                {
                    location.reload();
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถแจ้งรายงานได้ขณะนี้",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 3)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถแจ้งรายงานตัวเองได้",
                    icon: "error",
                    button: true,
                });
            }
            else
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณาเข้าสู่ระบบก่อน",
                    icon: "error",
                    button: true,
                });
            }
            document.getElementById("report_btn").disabled = false;
            $("#report_btn").html('แจ้งรายงาน');
        }
    });
}

function delRandomboxItem(id)
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=delRandomboxItem",
        data: "randomboxItemID="+ id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ลบไอเทมในกล่องสุ่มเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((ok_sendReport) =>
                {
                    location.reload();
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดในการลบไอเทม",
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
        }
    });
}

function addShopItem()
{
    var item_name = $('#item_name').val();
    var item_img = $('#item_img').val();
    var item_command = $('#item_command').val();
    var item_price = $('#item_price').val();
    var item_recommend = $('#item_recommend').val();
    var category_id = $('#category_id').val();
    var server_id = $('#for_sv').val();

    if(item_name == "" || item_name == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกชื่อสินค้า",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(item_img == "" || item_img == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอก URL รูปภาพของสินค้า",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(item_command == "" || item_command == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกคำสั่ง",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(item_price == "" || item_price == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกราคาของสินค้า",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(item_recommend == "" || item_recommend == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกสินค้าแนะนำให้ถูกต้อง",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(category_id == "" || category_id == "0" || category_id == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกหมวดหมู่",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(server_id == "" || server_id == "0" || server_id == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกเซิฟเวอร์",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=addShopItem",
        data: "item_name=" + item_name + "&item_img=" + item_img + "&item_command=" + item_command +
        "&item_price=" + item_price + "&item_recommend=" + item_recommend + "&category_id=" + category_id +
        "&server_id=" + server_id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณากรอกข้อมูลให้ถูกต้อง",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "เพิ่มสินค้าเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((ok_addShopItem) =>
                {
                    location.reload();
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถเพิ่มข้อมูลเข้าฐานข้อมูลได้ขณะนี้",
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
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
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
        }
    });
}

function showFrmAddItem()
{
    document.getElementById("btn_addItem").style.display = "none";
    document.getElementById("frm_addItem").style.display = "block";
}

function HideFrmAddItem()
{
    document.getElementById("btn_addItem").style.display = "block";
    document.getElementById("frm_addItem").style.display = "none";
}

function HideFrmEditItem()
{
    document.getElementById("frm_editItem").style.display = "none";
}

function DelShopItem(id)
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=delShopItem",
        data: "shopId=" + id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ลบสินค้าเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                });

                $("#item_id_" + id).html("");
                document.getElementById("item_id_" + id).style.display = "none";
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่ทราบลบไอเทมได้ในขณะนี้",
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
        }
    });
}

function btn_editShopItem(id)
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=getDetailShopItem",
        data: "shopId=" + id,
        success: function(data)
        {
            var res = data.split("|");

            document.getElementById("edit_item_name").value = res[0];
            document.getElementById("edit_item_img").value = res[1];
            document.getElementById("edit_item_command").value = res[2];
            document.getElementById("edit_item_price").value = res[3];
            document.getElementById("edit_item_id").value = res[4];

            document.getElementById("frm_editItem").style.display = "block";
        }
    });
}

function editShopItem()
{
    var item_id = $('#edit_item_id').val();
    var item_name = $('#edit_item_name').val();
    var item_img = $('#edit_item_img').val();
    var item_command = $('#edit_item_command').val();
    var item_price = $('#edit_item_price').val();
    var item_recommend = $('#edit_item_recommend').val();
    var category_id = $('#edit_category_id').val();
    var server_id = $('#edit_for_sv').val();

    if(item_id == "" || item_id == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "เกิดข้อผิดพลาด ไม่พบ ID สินค้า",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(item_name == "" || item_name == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกชื่อสินค้า",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(item_img == "" || item_img == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอก URL รูปภาพของสินค้า",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(item_command == "" || item_command == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกคำสั่ง",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(item_price == "" || item_price == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกราคาของสินค้า",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(item_recommend == "" || item_recommend == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกสินค้าแนะนำให้ถูกต้อง",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(category_id == "" || category_id == "0" || category_id == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกหมวดหมู่",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(server_id == "" || server_id == "0" || server_id == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกเซิฟเวอร์",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=editShopItem",
        data: "item_id=" + item_id + "&item_name=" + item_name + "&item_img=" + item_img + "&item_command=" + item_command +
        "&item_price=" + item_price + "&item_recommend=" + item_recommend + "&category_id=" + category_id +
        "&server_id=" + server_id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณากรอกข้อมูลให้ถูกต้อง",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "แก้ไขสินค้าเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((ok_editShopItem) =>
                {
                    location.reload();
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "ไม่สามารถอัพเดทข้อมูลเข้าฐานข้อมูลได้ขณะนี้",
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
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
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
        }
    });
}

function showFrmAddRandombox()
{
    document.getElementById("frm_addRandombox").style.display = "block";
    document.getElementById("btn_addRandomBox").style.display = "none";
}

function hideFrmAddRandombox()
{
    document.getElementById("frm_addRandombox").style.display = "none";
    document.getElementById("btn_addRandomBox").style.display = "block";
}

function addRandombox()
{
    var elements_form = document.getElementById("add_randombox").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var nameRandombox = submit[0];
    var priceRandombox = submit[1];
    var imgRandombox = submit[2];

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=addRandombox",
        data: "name=" + nameRandombox + "&price=" + priceRandombox + "&img=" + imgRandombox,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณากรอกข้อมูลให้ครบทุกช่อง",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "เพิ่มกล่องสุ่มเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_addRandombox) =>
                {
                    location.reload();
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดในการเพิ่มกล่องสุ่ม",
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
        }
    });
}

function delItemRandombox(id)
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=delItemRandombox",
        data: "id=" + id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ลบกล่องสุ่มนี้เรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_delRandombox) =>
                {
                    location.href = document.getElementById("path").value + "/backend/?page=randombox";
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
        }
    });
}

function addServer()
{
    var elements_form = document.getElementById("frm_addServer").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var server_name = submit[0];
    var server_ip = submit[1];
    var server_port = submit[2];
    var server_password = submit[3];

    if(server_name == "" || server_name == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกชื่อเซิฟเวอร์",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(server_ip == "" || server_ip == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกไอพีเซิฟเวอร์",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(server_port == "" || server_port == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกพอร์ต Rcon",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(server_password == "" || server_password == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกรหัสผ่าน Rcon",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=addServer",
        data: "name=" + server_name + "&ip=" + server_ip + "&port=" + server_port + "&password=" + server_password,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "เพิ่ม Server เรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_addServer) =>
                {
                    location.reload();
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
        }
    });
}

function delServer(id)
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=delServer",
        data: "id=" + id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ลบ Server เรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_delServer) =>
                {
                    location.reload();
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
        }
    });
}

function addCategory()
{
    var elements_form = document.getElementById("frm_addCategory").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var category_name = submit[0];

    if(category_name == "" || category_name == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกชื่อหมวดหมู่",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=addCategory",
        data: "category_name=" + category_name,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "เพิ่มหมวดหมู่เรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_addCategory) =>
                {
                    location.reload();
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
        }
    });
}

function delCategory(id)
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=delCategory",
        data: "id=" + id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ลบหมวดหมู่เรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_delCategory) =>
                {
                    location.reload();
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
        }
    });
}

function addDiary()
{
    var elements_form = document.getElementById("frm_addDiary").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var diary_name = submit[0];
    var diary_command = submit[1];
    var diary_img = submit[2];
    var diary_server = submit[3];
    var diary_date = submit[4];

    if(diary_name == "" || diary_name == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกชื่อไอเทม/สินค้า",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(diary_command == "" || diary_command == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกคำสั่ง",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(diary_img == "" || diary_img == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอก URL รูปภาพ",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(diary_server == "0" || diary_server == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกเซิฟเวอร์",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(diary_date == "" || diary_date == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกวันที่",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=addDiary",
        data: "diary_name=" + diary_name + "&diary_command=" + diary_command +
        "&diary_img=" + diary_img + "&diary_server=" + diary_server + "&diary_date=" + diary_date,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "เพิ่มเช็คชื่อรายวันเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((ok_addDiary) =>
                {
                    location.reload();
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
        }
    });
}

function addCode()
{
    var elements_form = document.getElementById("frm_addCode").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var code_value = submit[0];
    var code_command = submit[1];
    var code_type = submit[2];
    var code_limit = submit[3];
    var server_id = submit[4];

    if(code_value == "" || code_value == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกโค้ด",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(code_command == "" || code_command == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกคำสั่ง",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(code_type == "" || code_type == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกชนิดของโค้ด",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(code_type == "3" && code_limit == "" || code_type == "3" && code_limit == "0" || code_type == "3" && code_limit == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกจำกัดจำนวนคนให้ถูกต้อง",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(server_id == "0" || server_id == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณาเลือกเซิฟเวอร์",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=addCode",
        data: "code_value=" + code_value + "&code_command=" + code_command +
        "&code_type=" + code_type + "&code_limit=" + code_limit + "&server_id=" + server_id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "เพิ่มโค้ด " + code_value + " เรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((ok_addCode) =>
                {
                    location.reload();
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "มีโค้ด " + code_value + " ในระบบแล้ว",
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
        }
    });
}

function delCode(id)
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=delCode",
        data: "id=" + id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ลบโค้ดเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_delCode) =>
                {
                    location.reload();
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
        }
    });
}

function editSettings()
{
    var elements_form = document.getElementById("frm_settingSite").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var shop_name = submit[0];
    var boardcast_message = submit[1];
    var max_reg = submit[2];

    if(shop_name == "" || shop_name == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกชื่อ Webshop",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(boardcast_message == "" || boardcast_message == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกข้อความที่จะประกาศ",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(max_reg == "0" || max_reg == "" || max_reg == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณา จำกัด IP/Account [สมัครสมาชิก] ให้ถูกต้อง",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=updateSettings",
        data: "shop_name=" + shop_name + "&boardcast=" + boardcast_message + "&max_reg=" + max_reg,
        success: function(data)
        {
           if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ตั้งค่า Webshop เรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_updateSettings) =>
                {
                    location.reload();
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
        }
    });
}

function topupTMN()
{
    var tmn_password = $('#truemoney_password').val();
    if(tmn_password == '')
    {
        toastr["error"]('กรุณากรอกรหัสบัตรทรูมันนี่ !');
        return false;
    }
    else if(tmn_password.length <= 13)
    {
        toastr["error"]('กรุณากรอกรหัสบัตรทรูมันนี่ให้ถูกต้อง !');
        return false;
    }

    $.ajax({
        type: "POST",
        url: "application/Controller/wallet.php?func=topupTMN",
        data: "truemoney_password=" + tmn_password,
        beforeSend: function() {
            document.getElementById("btn_topupTMN").disabled = true;
            $("#btn_topupTMN").html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(data)
        {
            var res = data.split("|");

            if(res[0] == 1)
            {
                document.getElementById("truemoney_password").value = "";

                swal(
                {
                    title: "สำเร็จ !",
                    text: "คุณได้ทำการเติมเงิน " + res[1] + " บาท",
                    icon: "success",
                    button: true,
                })
                .then((ok_topupTMN) =>
                {
                    if(ok_topupTMN)
                    {
                        location.reload();
                    }
                });
            }
            else if(res[0] == 2)
            {
                toastr["error"]('กรุณากรอกหมายเลขอ้างอิงให้ถูกต้อง !');
            }
            else if(res[0] == 0)
            {
                toastr["error"]('กรุณาตั้งค่าระบบเติมเงิน [Admin]');
            }
            else if(res[0] == 3)
            {
                toastr["error"]('เกิดข้อผิดพลาดไม่ทราบสาเหตุ !');
            }
            else if(res[0] == 4)
            {
                toastr["error"]('เกิดข้อผิดพลาด รหัสบัตรเงินสดทรูมันนี่ไม่ถูกต้อง !');
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
                toastr["error"]('รหัสบัตรทรูมันนี่ถูกใช้งานแล้ว หรือ รหัสบัตรทรูมันนี่ผิด !');
            }
            else if(res[0] == 9)
            {
                toastr["error"]('เกิดข้อผิดพลาดในการบันทึกประวัติการเติมเงิน !');
            }

            document.getElementById("btn_topupTMN").disabled = false;
            $("#btn_topupTMN").html('<i class="fa fa-slack"></i> เติมด้วย TrueMoney');
        }
    });
}

function editTruemoney(id)
{
    var elements_form = document.getElementById("frm_editTruemoney_" + id).elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var points = submit[0];
    var rp = submit[1];

    if(points == "" || points == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกพ้อยท์ที่จะได้รับ",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(rp == "" || rp == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอก RP ที่จะได้รับ",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=editTruemoney",
        data: "id=" + id + "&points=" + points + "&rp=" + rp,
        beforeSend: function() {
            document.getElementById("btn_editTruemoney_" + id).disabled = true;
            $("#btn_editTruemoney_" + id).html('<i class="fa fa-spinner fa-spin fa-lg"></i> กรุณารอสักครู่...');
        },
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณากรอกช่องพ้อยท์ที่จะได้รับ หากเป็น 0 ให้กรอก 0.00",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณากรอกช่อง RP ที่จะได้รับ หากเป็น 0 ให้กรอก 0.00",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "แก้ไขเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((ok_editTruemoney) => 
                {
                    location.reload();
                });
            }
            else if(data == 3)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 4)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
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

            document.getElementById("btn_editTruemoney_" + id).disabled = false;
            $("#btn_editTruemoney_" + id).html('แก้ไข #' + id);
        }
    });
}

function delWaleltRP(id)
{
    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=delWalletRP",
        data: "id=" + id,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "ลบเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_delWalletRP) =>
                {
                    $('#walletRP_tr_' + id).html("");
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
        }
    });
}

function addWalletRP()
{
    var elements_form = document.getElementById("frm_addWalletRP").elements;
    var submit = [];
    for(var i = 0 ; i < elements_form.length; i++)
    {
        var item = elements_form.item(i);
        submit.push(item.value);
    }

    var points = submit[0];
    var rp = submit[1];

    if(points == "" || points == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอกพ้อยท์ที่เติม",
            icon: "error",
            button: true,
        });

        return false;
    }

    if(rp == "" || rp == undefined)
    {
        swal(
        {
            title: "เกิดข้อผิดพลาด !",
            text: "กรุณากรอก RP ที่จะได้รับ",
            icon: "error",
            button: true,
        });

        return false;
    }

    $.ajax({
        type: "POST",
        url: "../application/Controller/backend.php?func=addWalletRP",
        data: "points=" + points + "&rp=" + rp,
        success: function(data)
        {
            if(data == 0)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "กรุณากรอกให้ครบทุกช่อง",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 1)
            {
                swal(
                {
                    title: "สำเร็จ !",
                    text: "เพิ่มเรียบร้อยแล้ว",
                    icon: "success",
                    button: true,
                })
                .then((okay_addWalletRP) =>
                {
                    location.reload();
                });
            }
            else if(data == 2)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "เกิดข้อผิดพลาดไม่ทราบสาเหตุ",
                    icon: "error",
                    button: true,
                });
            }
            else if(data == 3)
            {
                swal(
                {
                    title: "เกิดข้อผิดพลาด !",
                    text: "มียอดนี้อยู่ในระบบแล้ว",
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
        }
    });
}