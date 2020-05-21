<div class="card">
	<div class="card-header bg-info text-white">
		<i class="fa fa-user"></i> User
	</div>
	<div class="card-body">

<?php
	if(isset($_SESSION['uid']))
	{
		?>
			<div class="text-center">
				<img src="https://minotar.net/cube/<?php echo $player['realname']; ?>/100" alt="<?php echo $player['realname']; ?>"/>
			</div>
		<?php
	}
	else
	{
		?>
			<div class="alert alert-warning text-center mt-2">
				กรุณาเข้าสู่ระบบ
			</div>
			<center>
				<a href="<?php echo $settings['site']; ?>?page=login"><button type="button" class="btn btn-primary btn-xs">เข้าสู่ระบบ</button></a>
				<a href="<?php echo $settings['site']; ?>?page=register"><button type="button" class="btn btn-info btn-xs">สมัครสมาชิก</button></a>
			</center>
		<?php
	}
?>
	</div>
</div>