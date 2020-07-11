<?php
	require_once("../application/_config.php");
	require_once("../application/_pdo.php");
	require_once("../application/_getPlayer.php");	
	require_once("../application/_getInfoServer.php");
?>
<html>
	<head>
		<?php include_once 'template/taghead.php'; ?>
	</head>
	<body>
		<input name="path" id="path" type="hidden" value="<?php echo $config['site']; ?>"/>
		<?php
			if(!isset($_SESSION['backend_uid']))
			{
				include_once("template/member/login.php");
			}
			else
			{
				if(isset($_GET['page']))
				{
					$p = $_GET['page'];

					if($p == 'dashboard')
					{
						$title = "Dashboard";
						$file = "template/member/dashboard";
					}
					elseif($p == 'settingWallet')
					{
						$title = "Wallet Setting";
						$file = "template/member/settingWallet";
					}
					elseif($p == 'randombox')
					{
						$title = "Random Box";
						$file = "template/member/randombox";
					}
					elseif($p == 'additemRandombox')
					{
						$title = "Add Item Random Box";
						$file = "template/member/additemRandombox";
					}
					elseif($p == 'loginLogs')
					{
						$title = "Login Logs";
						$file = "template/member/login_logs";
					}
					elseif($p == 'shopLogs')
					{
						$title = "Shop Logs";
						$file = "template/member/shop_logs";
					}
					elseif($p == 'refillLogs')
					{
						$title = "Refill Logs";
						$file = "template/member/refill_logs";
					}
					elseif($p == 'manageShop')
					{
						$title = "Manage Shop";
						$file = "template/member/shop";
					}
					elseif($p == 'server')
					{
						$title = "Manage Server";
						$file = "template/member/server";
					}
					else
					{
						$title = "Dashboard";
						$file = "template/member/dashboard";
					}
				}
				else
				{
					$title = "Dashboard";
					$file = "template/member/dashboard";
				}
				?>
					<div class="wrapper">
					  <div id="pre-loader">
					      <img src="images/pre-loader/loader-01.svg" alt="">
					  </div>
					  <?php
					  	include_once("template/navbar.php");
					  ?>
					  <div class="container-fluid">
					    <div class="row">
					      <?php
					      	include_once("template/slidebar.php");
					      ?>
					      <div class="content-wrapper">
					        <div class="page-title">
								<div class="row">
									<div class="col-sm-6">
										<h4 class="mb-0">
											<?php echo $title; ?>
										</h4>
									</div>
									<div class="col-sm-6">
										<ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
											<li class="breadcrumb-item"><a href="<?php echo $config['site']."/Backend"; ?>" class="default-color">Home</a></li>
											<li class="breadcrumb-item active"><?php echo $title; ?></li>
										</ol>
									</div>
								</div>
					        </div> 
					        <div class="row">   
								<div class="col-md-12 mb-30">     
									<div class="card card-statistics h-100"> 
										<div class="card-body">   
											<?php
												$lastDateOfThisMonth = strtotime('last day of this month');
												$lastDay = date('d', $lastDateOfThisMonth) + 1;
												$date = date('Y-m-', $lastDateOfThisMonth).$lastDay;
												
												include_once($file.".php");
											?>
										</div>
									</div>   
								</div> 
					        </div>
					        <?php
					        	include_once("template/endsite.php");
					        ?>
					      </div> 
					    </div>
					  </div>
					</div>
				<?php
			}
			include_once("template/footer.php");
			if(isset($_GET['page']))
			{
				$p = $_GET['page'];

				if($p == 'dashboard')
				{
					?>
						<script type="text/javascript" src="<?php echo $config['site'] ?>/backend/js/DashboardZyanJS.js"></script>
					<?php
				}
				else
				{
					?>
						<script type="text/javascript" src="<?php echo $config['site'] ?>/backend/js/DashboardZyanJS.js"></script>
					<?php
				}
			}
			else
			{
				?>
					<script type="text/javascript" src="<?php echo $config['site'] ?>/backend/js/DashboardZyanJS.js"></script>
				<?php
			}
		?>
	</body>
</html>