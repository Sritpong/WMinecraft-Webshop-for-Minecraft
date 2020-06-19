<div class="wrapper">
	<div id="pre-loader">
	    <img src="images/pre-loader/loader-01.svg" alt="">
	</div>
	<section class="height-100vh d-flex align-items-center page-section-ptb login" style="background-image: url(images/login-bg.jpg);" >
		<div class="container">
			<div class="row justify-content-center no-gutters vertical-align">
				<div class="col-lg-4 col-md-6 login-fancy-bg bg">
					<div class="login-fancy">	
						<p class="mb-20 text-white" style="font-size:28px">
							ระบบหลังร้าน จัดการ Webshop Minecraft
						</p>
						<p class="mb-20 text-white" style="font-size:16px">
							สำหรับเรียกดูภาพรวมของ Webshop
							<br/>
							- รายการซื้อสินค้าทั้งหมด
							<br/>
							- รายการเติมเงินทั้งหมด
							<br/>
							- จัดการระบบหลังร้าน
							<br/>
							- อื่นๆ
						</p>
						 <p class="pos-bot text-white pb-30">
							Design & System by WMinecraft
						</p>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 bg-white">
					<div class="login-fancy pb-40 clearfix">
						<h3 class="mb-30">
							เข้าสู่ระบบหลังร้าน
						</h3>
						<div id="alert_login"></div>
						<form name="login_frm" id="login_frm" method="POST" action="javascript:void(0);" autocomplete="off">
							<div class="section-field mb-20">
								<label class="mb-10" for="username_input">
									Username* 
								</label>
								<input name="username_input" id="username_input" type="text" class="web form-control" placeholder="ชื่อตัวละครในเกม">
							</div>
							<div class="section-field mb-20">
								<label class="mb-10" for="password_input">
									Password* 
								</label>
								<input name="password_input" id="password_input" type="password" class="password form-control" placeholder="รหัสผ่านในเกม"/>
							</div>
							<input name="path" id="path" type="hidden" value="<?php echo $config['site']; ?>/backend"/>
							<button type="submit" name="login_btn" id="login_btn" class="button" onclick="LoginBackend()">
								<i class="fa fa-sign-in"></i> เข้าสู่ระบบ
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>