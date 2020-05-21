<?php
	if(!isset($_SESSION['uid']))
	{
		?>
			<div class="card">
				<div class="card-header bg-primary text-white">
					Register
				</div>
				<div class="card-body">
					<div id="alert_register"></div>
					<form name="register_frm" id="register_frm" method="POST" action="javascript:void(0);" autocomplete="off">
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-user"></i>
								</span>
							</div>
							<input name="username_input" id="username_input" type="text" class="form-control" placeholder="ชื่อตัวละครในเกม">
						</div>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-lock"></i>
								</span>
							</div>
							<input name="password_input" id="password_input" type="password" class="form-control" placeholder="รหัสผ่านในเกม"/>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-lock"></i>
								</span>
							</div>
							<input name="confirmpassword_input" id="confirmpassword_input" type="password" class="form-control" placeholder="ยืนยันรหัสผ่านในเกม"/>
						</div>
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-envelope"></i>
								</span>
							</div>
							<input name="email_input" id="email_input" type="email" class="form-control" placeholder="ที่อยู่อีเมลล์ : [Example: somchai@gmail.com]" autocomplete="off" />
						</div>
						<hr/>
						<input name="path" id="path" type="hidden" value="<?php echo $config['site']; ?>"/>
						<button type="submit" id="button_chkregister" class="btn btn-primary btn-block" onclick="chkRegister()"><i class="fa fa-user-plus"></i> สมัครสมาชิก</button>
					</form>
				</div>
			</div>

			<!-- Modal Confirm Register -->
			<div class="modal fade" id="confirmRegModal" tabindex="-1" role="dialog" aria-labelledby="confirmRegModal" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">
								<i class="fa fa-user-plus"></i> ยืนยันการสมัครสมาชิก</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<div class="modal-body">
						<b>กรุณาตรวจสอบข้อมูลให้ถูกต้องการสมัครสมาชิก</b>
						<div id="modal_reg_username"></div>
						<div id="modal_reg_email"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">
							<i class="fa fa-times"></i> ยกเลิก
						</button>
						<button type="button" name="register_btn" id="register_btn" class="btn btn-primary" onclick="Register()">
							<i class="fa fa-check"></i> ยืนยันการสมัครสมาชิก
						</button>
					</div>
					</div>
				</div>
			</div>
		<?php
	}
	else
	{
		echo "เข้าสู่ระบบอยู่ในขณะนี้";
	}
?>