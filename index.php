<?php
	require_once("application/_config.php");
	require_once("application/_pdo.php");
	require_once("application/_getPlayer.php");	
	require_once("application/_getSettings.php");
	require_once("application/_getInfoServer.php");
?>
<html>
	<head>
		<?php include_once 'template/taghead.php'; ?>
	</head>
	<body>
		<input name="path" id="path" type="hidden" value="<?php echo $config['site']; ?>"/>
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
								Webshop : <?php echo $settings['settings_shop_name']; ?>
							</h5>
							<hr/>
							<div class="row">
								<div class="col-md-4 col-xs-12 mb-3">
									<?php
										include_once('template/member.php');
										include_once('template/status_server.php');
										include_once('template/player_search.php');
									?>
								</div>
								<div class="col-md-8 col-xs-12">
									<?php
										include_once("template/boardcast.php");

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
												include_once('template/member/shop.php');
											}
											elseif($p == 'code')
											{
												include_once('template/member/code.php');
											}
											elseif($p == 'diary')
											{
												include_once('template/member/diary.php');
											}
											elseif($p == 'backpack')
											{
												include_once('template/member/backpack.php');
											}
											elseif($p == 'randombox')
											{
												include_once('template/member/randombox.php');
											}
											elseif($p == 'player')
											{
												include_once('template/player.php');
											}
											else
											{
												include_once('template/member/shop.php');
											}
										}
										else
										{
											include_once('template/member/shop.php');
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row my-3">
				<div class="col-12 text-center">
					<b><small>Copyright &copy; <?php echo date('Y'); ?> WMinecraft All Rights Reserved.</small></b><br/>
					Design & System by <a href="https://fb.com/jamebies" target="_blank">Sritpong</a> | <a href="<?php echo $config['site']."/Backend"; ?>">Backend</a>
				</div>
			</div>
		</div>
		<?php
			include_once("template/footer.php");
		?>
		<script type="text/javascript">
			$(function()
			{
				$('[data-toggle="tooltip"]').tooltip();
			});
		</script>
	</body>
</html>
