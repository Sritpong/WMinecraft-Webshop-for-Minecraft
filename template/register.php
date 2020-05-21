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
							<input name="email_input" id="email_input" type="email" class="form-control" placeholder="ที่อยู่อีเมลล์ : [Example: somchai@gmail.com]"/>
						</div>
						<hr/>
						<input name="path" id="path" type="hidden" value="<?php echo $settings['site']; ?>"/>
						<button type="submit" name="login_btn" id="login_btn" class="btn btn-primary btn-block" onclick="Register()"><i class="fa fa-user-plus"></i> สมัครสมาชิก</button>
					</form>
				</div>
			</div>
		<?php
	}
?>