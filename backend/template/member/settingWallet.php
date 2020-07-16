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
            Email/Phone number
          </label>
          <input name="email_wallet" id="email_wallet" type="text" class="web form-control" placeholder="กรุณากรอก Email" value="<?php echo $detailWallet['email']; ?>">
        </div>
        <div class="section-field col-6 mb-20">
          <label class="mb-10" for="password_wallet">
            Password
          </label>
          <input name="password_wallet" id="password_wallet" type="password" class="web form-control" placeholder="กรุณากรอก Password" value="<?php echo $detailWallet['password']; ?>">
        </div>
        <div class="section-field col-2 mb-20">
          <label class="mb-10" for="mutiple_wallet">
            Mutiple
          </label>
          <input name="mutiple_wallet" id="mutiple_wallet" type="text" class="web form-control" placeholder="กรุณากรอกจำนวนการคูณ" value="<?php echo $detailWallet['mutiple']; ?>">
        </div>
        <div class="section-field col-4 mb-20">
          <label class="mb-10" for="phone_wallet">
            Phone number
          </label>
          <input name="phone_wallet" id="phone_wallet" type="text" class="web form-control" value="<?php echo $detailWallet['phone']; ?>" readonly>
        </div>
        <div class="section-field col-6 mb-20">
          <label class="mb-10" for="name_wallet">
            Name
          </label>
          <input name="name_wallet" id="name_wallet" type="text" class="web form-control" value="<?php echo $detailWallet['name']; ?>" readonly>
        </div>
        <div class="section-field col-12 mb-20">
          <label class="mb-10" for="token_wallet">
            Access Token
          </label>
          <input name="token_wallet" id="token_wallet" type="text" class="web form-control" value="<?php echo substr($detailWallet['access_token'], 0, -10)."**********"; ?>" readonly>
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
    <h3 class="mt-3">Wallet Reward Points</h3>
    <hr/>
    <form id="frm_addWalletRP" name="frm_addWalletRP" method="POST">
      <div class="row">
        <div class="form-group col-6">
          <label for="wallet_rp_topup">เมื่อเติม (บาท)</label>
          <input type="text" class="form-control" required id="wallet_rp_topup" name="wallet_rp_topup">
        </div>
        <div class="form-group col-6">
          <label for="wallet_rp_receive">ได้รับ (RP)</label>
          <input type="text" class="form-control" required id="wallet_rp_receive" name="wallet_rp_receive">
        </div>
        <div class="col-12">
          <button id="btn_addServer" type="button" class="btn btn-outline-success btn-block" onclick="addWalletRP()">
            เพิ่ม
          </button>
        </div>
      </div>
    </form>
    <table id="wallet_rp_table" class="table table-striped nowrap table-sm" style="width:100%;">
      <thead>
        <tr>
            <th>ลำดับ</th>
            <th>เติม (บาท)</th>
            <th>ได้รับ (RP)</th>
            <th>#</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql_walletRP = "SELECT * FROM wallet_rp";
          $query_walletRP = query($sql_walletRP);

            if($query_walletRP->rowcount() <= 0)
            {
              ?>
                <tr>
                  <td colspan="4" class="text-center">
                    ยังไม่มียอดที่ได้รับ RP
                  </td>
                </tr>
              <?php
            }
            else
            {
              while($walletRP = $query_walletRP->fetch())
              {
                ?>
                  <tr id="walletRP_tr_<?php echo $walletRP['wallet_rp_id']; ?>">
                    <td>
                      <?php echo $walletRP['wallet_rp_id']; ?>
                    </td>
                    <td>
                      <?php echo $walletRP['wallet_rp_topup']; ?>
                    </td>
                    <td>
                      <?php echo $walletRP['wallet_rp_reward']; ?>
                    </td>
                    <td>
                      <button class="btn btn-outline-danger" onclick="delWaleltRP(<?php echo $walletRP['wallet_rp_id']; ?>)">
                        ลบ #<?php echo $walletRP['wallet_rp_id']; ?>
                      </button>
                  </tr>
                <?php
              }
            }
        ?>
      </tbody>
    </table>
    <h3 class="mt-3">TrueMoney Reward Points</h3>
    <hr/>
    <table id="truemoney_table" class="table table-striped nowrap table-sm" style="width:100%;">
      <thead>
        <tr>
            <th>ลำดับ</th>
            <th>เมื่อเติม (บาท)</th>
            <th>ได้รับ (Points)</th>
            <th>ได้รับ (RP)</th>
            <th>#</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql_truemoney = "SELECT * FROM truemoney";
          $query_truemoney = query($sql_truemoney);

            if($query_truemoney->rowcount() <= 0)
            {
              ?>
                <tr>
                  <td colspan="5" class="text-center">
                    ยังไม่มียอดของ TrueMoney
                  </td>
                </tr>
              <?php
            }
            else
            {
              while($truemoney = $query_truemoney->fetch())
              {
                ?>
                  <form name="frm_editTruemoney_<?php echo $truemoney['id']; ?>" id="frm_editTruemoney_<?php echo $truemoney['id']; ?>" method="POST" action="javascript:void(0);" autocomplete="off">
                    <tr>
                      <td>
                        <?php echo $truemoney['id']; ?>
                      </td>
                      <td>
                        <?php echo $truemoney['amount']; ?>
                      </td>
                      <td>
                        <input name="editTruemoney_points_<?php echo $truemoney['id']; ?>" id="editTruemoney_points_<?php echo $truemoney['id']; ?>" type="text" class="web form-control" value="<?php echo $truemoney['points']; ?>">
                      </td>
                      <td>
                        <input name="editTruemoney_rp_<?php echo $truemoney['id']; ?>" id="editTruemoney_rp_<?php echo $truemoney['id']; ?>" type="text" class="web form-control" value="<?php echo $truemoney['rp']; ?>">
                      </td>
                      <td>
                        <button id="btn_editTruemoney_<?php echo $truemoney['id']; ?>" class="btn btn-outline-success" onclick="editTruemoney(<?php echo $truemoney['id']; ?>)">
                          แก้ไข #<?php echo $truemoney['id']; ?>
                        </button>
                    </tr>
                  </form>
                <?php
              }
            }
        ?>
      </tbody>
    </table>
  </div>
</div>