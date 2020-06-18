<?php
	if(!isset($_SESSION['uid']))
	{
		include_once('template/member/login.php');
	}
	else
	{
		?>
			<div class="card">
				<div class="card-body">
					<h6>
						<i class="fa fa fa-credit-card"></i> Wallet Topup
					</h6>
					<hr/>
					<form name="wallet_topup" id="wallet_topup" method="POST" action="javascript:void(0);" autocomplete="off">
						<div class="input-group mb-2">
							<div class="input-group-prepend">
								<span class="input-group-text">
									Transaction:
								</span>
							</div>
							<input name="transaction_wallet" id="transaction_wallet" type="text" class="form-control" placeholder="เลขอ้างอิง 14 หลัก"/>
						</div>
					</form>
				</div>
				<div class="card-footer text-right">
					<button id="btn_topup" type="button" class="btn btn-outline-success btn-xs" onclick="Topup()"><i class="fa fa-slack"></i> เติมเงิน</button>
				</div>
			</div>
		<?php
	}
?>