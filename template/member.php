<div class="card">
	<div class="card-header bg-info text-white">
		<i class="fa fa-user"></i> User
	</div>
	<div class="card-body">

<?php
	if(isset($_SESSION['uid']))
	{
		?>
			<div class="row">
				<div class="col-md-6 col-xs-12 text-center">
					<img src="https://minotar.net/cube/<?php echo $player['realname']; ?>/100" alt="<?php echo $player['realname']; ?>"/>
				</div>
				<div class="col-md-6 col-xs-12 text-center">
					Player: <b><?php echo $player['realname']; ?></b>
					<div id="player_points">Points: <b><?php echo $player['points']; ?></b></div>
					<?php
						if(isset($chkPlayerOnline) && $chkPlayerOnline == true)
						{
							echo 'Status: <label class="text-success"><b>Online</b></label>';
						}
						else
						{
							echo 'Status: <label class="text-danger"><b>Offline</b></label>';
						}
					?>
				</div>
			</div>
			<hr/>
			<button id="logout_btn" type="button" class="btn btn-danger btn-block" onclick="Logout('<?php echo $config['site']; ?>')"><i class="fa fa-sign-out"></i> ออกจากระบบ</button>
		<?php
	}
	else
	{
		?>
			<div class="alert alert-warning text-center mt-2">
				กรุณาเข้าสู่ระบบ
			</div>
			<center>
				<a href="<?php echo $config['site']; ?>?page=login"><button type="button" class="btn btn-primary btn-xs">เข้าสู่ระบบ</button></a>
				<a href="<?php echo $config['site']; ?>?page=register"><button type="button" class="btn btn-info btn-xs">สมัครสมาชิก</button></a>
			</center>
		<?php
	}
?>
	</div>
</div>