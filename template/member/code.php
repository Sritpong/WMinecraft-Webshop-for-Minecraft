<?php
	if(isset($_SESSION['uid']))
	{
		?>
			<div class="card">
				<div class="card-body">
					<h6>
						<i class="fa fa-barcode"></i> Redeem Code
					</h6>
					<hr/>
					Coding...
				</div>
			</div>
		<?php
	}
	else
	{
		include_once("template/member/login.php");
	}
?>