<?php
	if(!isset($_SESSION['uid']))
	{
		?>
			<div class="card">
				<div class="card-header bg-info text-white">
					Login
				</div>
				<div class="card-body">
					<div id="alert_login"></div>
					<form name="login_frm" id="login_frm" method="POST" action="javascript:void(0);" autocomplete="off">
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
						<hr/>
						<button type="submit" name="login_btn" id="login_btn" class="btn btn-info btn-block" onclick="Login()">เข้าสู่ระบบ</button>
					</form>
				</div>
			</div>
		<?php
	}
?>