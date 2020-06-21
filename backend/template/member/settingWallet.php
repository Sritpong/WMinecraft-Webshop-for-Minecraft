<?php
  $sql_getDetailWallet = "SELECT * FROM wallet_account WHERE id = 1";
  $query_getDetailWallet = query($sql_getDetailWallet);
  $detailWallet = $query_getDetailWallet->fetch();
?>
<div class="card-title">
  ตั้งค่าบัญชี Wallet
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
    <form name="walletSetting_frm" id="walletSetting_frm" method="POST" action="javascript:void(0);" autocomplete="off">
      <div class="row">
        <div class="section-field col-6 mb-20">
          <label class="mb-10" for="email_wallet">
            Email
          </label>
          <input name="email_wallet" id="email_wallet" type="text" class="web form-control" placeholder="กรุณากรอก Email" value="<?php echo $detailWallet['email']; ?>">
        </div>
        <div class="section-field col-6 mb-20">
          <label class="mb-10" for="password_wallet">
            Password
          </label>
          <input name="password_wallet" id="password_wallet" type="password" class="web form-control" placeholder="กรุณากรอก Password" value="<?php echo $detailWallet['password']; ?>">
        </div>
        <div class="section-field col-12 mb-20">
          <label class="mb-10" for="token_wallet">
            Access Token
          </label>
          <input name="token_wallet" id="token_wallet" type="text" class="web form-control" value="<?php echo $detailWallet['access_token'] ?>" readonly>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6">
          <button type="submit" name="walletSetting_btn" id="walletSetting_btn" class="button btn-block" onclick="EditWalletAccount()">
            <i class="fa fa-check"></i> บันทึก
          </button>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-6">
          <button type="submit" name="getAccessToken_btn" id="getAccessToken_btn" class="button btn-block" onclick="getOTPAccessToken()">
            <i class="fa fa-cloud"></i> รับ Access Token
          </button>
        </div>
      </div>
    </form>
  </div>
  <div class="col-xl-6 col-lg-12 col-md-12">
    
  </div>
</div>