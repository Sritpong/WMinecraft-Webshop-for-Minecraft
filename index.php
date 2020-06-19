<?php
	require_once("application/_config.php");
	require_once("application/_getPlayer.php");	
	require_once("application/_getInfoServer.php");
?>
<html>
	<head>
		<?php include_once 'template/taghead.php'; ?>
	</head>
	<body>
		<div class="container" style="margin-top: 50px;">
			<div class="row">
				<div class="col-12">
					<?php include_once("template/navbar.php"); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card shadow">
						<div class="card-body">
							<h5>
								Webshop : <?php echo $config['server_name']; ?>
							</h5>
							<hr/>
							<div class="row">
								<div class="col-md-4 col-xs-12 mb-3">
									<?php
										include_once('template/member.php');
										include_once('template/status_server.php');
									?>
								</div>
								<div class="col-md-8 col-xs-12">
									<?php
										if(isset($_GET['page']))
										{
											$p = $_GET['page'];

											if($p == 'login')
											{
												include_once('template/member/login.php');
											}
											elseif($p == 'register')
											{
												include_once('template/member/register.php');
											}
											elseif($p == 'topup')
											{
												include_once('template/member/topup.php');
											}
											elseif($p == 'shop')
											{
												include_once('template/product.php');
											}
											elseif($p == 'code')
											{
												include_once('template/member/code.php');
											}
										}
										else
										{
											// include_once('template/status_server.php');
										}
									?>
									<!-- <div class="col-lg-4 col-md-6 col-xs-6">
            <div class="item mb-2" style="border-radius: 5px 5px 5px 5px;">
              <div class="item-image">
              <a class="item-image-price">50.00 บาท</a>
              <center><img src="http://103.91.205.83/item/1169.png"></center>
              <a class="item-image-bottom text-center">ยศ Diamond</a>
            </div>
              <div class="item-info">
                <div class="item-text">
				  <a>ชื่อ</a>
                  <a href="?page=confirm&id=0" class="btn btn-success w-100 mb-1 border-0">ซื้อสินค้า</a>
                  <a href="?page=confirm&id=0" class="btn btn-danger btn-sm"><i class="fa fa-gift"></i> ส่งของขวัญ</a>
                </div>
              </div>
            </div>
              </div>  -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row my-3">
				<div class="col-12 text-center">
					&copy; Design & System by WMinecraft
				</div>
			</div>
		</div>
		<?php
			include_once("template/footer.php");
		?>
	</body>
</html>