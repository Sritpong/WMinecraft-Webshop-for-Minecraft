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
					<form method="POST" id="code" action="javascript:void(0);">
					    <div class="input-group mb-3">
					        <div class="input-group-prepend">
					        	<span class="input-group-text bg-dark text-light"><i class="fa fa-key"></i></span>
					        </div>
					        <input type="text" class="form-control input-lg" placeholder="กรุณากรอก Code" name="input_code" id="input_code" style="text-align:center;">
					    </div>
					    <center>
					    	<button type="submit" name="code_btn" id="code_btn" class="btn btn-success" style="width:35%;" onclick="redeemCode()"><i class="fa fa-check"></i><br>ดำเนินการต่อ</button>
					    </center>
					</form>
				</div>
			</div>
		<?php
	}
	else
	{
		include_once("template/member/login.php");
	}
?>