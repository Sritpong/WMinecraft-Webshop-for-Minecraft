<?php
	if(!isset($_SESSION['uid']))
	{
		include_once('template/member/login.php');
	}
	else
	{
		?>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-xs-12 mb-3 text-center">
					<img src="<?php echo $config['site']; ?>/img/truewallet.png"/>
					<div class="badge badge-success py-3" style="font-size: 18px;">
						<?php
							$sql_accWallet = "SELECT phone,name FROM wallet_account WHERE id = 1";
							$query_accWallet = query($sql_accWallet);

							$accWallet = $query_accWallet->fetch();
							if($accWallet['phone'] != "" || $accWallet['name'] != "")
							{
								?>
									หากเติมด้วยการโอนเงิน Wallet<br/>
									โอนเงินมาที่เบอร์: <?php echo $accWallet['phone']; ?><br/>
									<small>ชื่อบัญชี: <?php echo $accWallet['name']; ?></small>
								<?php
							}
							else
							{
								?>
									กรุณาตั้งค่าบัญชี Wallet ในระบบหลังบ้านก่อน
								<?php
							}
						?>
						
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-xs-12 mb-3">
					<div class="card">
						<div class="card-body">
							<h6>
								<i class="fa fa fa-credit-card"></i> Wallet Topup
							</h6>
							<hr/>
							<form name="wallet_topup" id="wallet_topup" method="POST" action="javascript:void(0);" autocomplete="off">
								<div class="form-group mb-2">
									<label for="transaction_wallet">Transaction</label>
									<input name="transaction_wallet" id="transaction_wallet" type="text" class="form-control" placeholder="เลขอ้างอิง 14 หลัก"/>
								</div>
							</form>
						</div>
						<div class="card-footer text-right">
							<button id="btn_topup" type="submit" class="btn btn-outline-success btn-xs" onclick="Topup()"><i class="fa fa-slack"></i> เติมด้วย TrueWallet</button>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-xs-12 mb-3">
					<div class="card">
						<div class="card-body">
							<h6>
								<i class="fa fa fa-credit-card"></i> Truemoney Topup
							</h6>
							<hr/>
							<form name="truemoney_topup" id="truemoney_topup" method="POST" action="javascript:void(0);" autocomplete="off">
								<div class="form-group mb-2">
									<label for="truemoney_password">Truemoney Password</label>
									<input name="truemoney_password" id="truemoney_password" type="text" class="form-control" placeholder="รหัสบัตรทรูมันนี่"/>
								</div>
							</form>
						</div>
						<div class="card-footer text-right">
							<button id="btn_topupTMN" type="submit" class="btn btn-outline-success btn-xs" onclick="topupTMN()"><i class="fa fa-slack"></i> เติมด้วย TrueMoney</button>
						</div>
					</div>
				</div>
			</div>
			
		<?php
		include_once('template/member/history_topup.php');
	}
?>