<?php
	require_once("application/_config.php");
	require_once("application/_getPlayer.php");
?>
<html>
	<head>
		<?php include_once 'template/taghead.php'; ?>
	</head>
	<body>
		<?php include_once 'template/navbar.php'; ?>
		<div class="container mt-3">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header bg-success text-white">
							Webshop : <?php echo $config['server_name']; ?>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-4 col-xs-12 mb-3">
									<?php
										include_once 'template/member.php';
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
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $config['site'] ?>/js/ZyanJS.js"></script>
		<script src="<?php echo $config['site'] ?>/build/toastr.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	</body>
</html>