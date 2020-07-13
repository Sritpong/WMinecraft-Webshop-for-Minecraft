<?php
	$sql_getSetting = "SELECT * FROM settings WHERE settings_id = 1";
	$query_getSetting = query($sql_getSetting);
	$getSetting = $query_getSetting->fetch();
?>
<div class="card-title">
  ตั้งค่า Webshop
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-frm_settingSite">
  	<form id="frm_settingSite" name="frm_addCategory" method="POST">
        <div class="row">
          <div class="form-group col-4">
            <label for="settings_shop_name">ชื่อ Webshop</label>
            <input type="text" class="form-control" required id="settings_shop_name" name="settings_shop_name" value="<?php echo $getSetting['settings_shop_name']; ?>">
          </div>
          <div class="form-group col-4">
            <label for="settings_boardcast">ข้อความที่จะประกาศ</label>
            <input type="text" class="form-control" required id="settings_boardcast" name="settings_boardcast" value="<?php echo $getSetting['settings_boardcast']; ?>">
          </div>
          <div class="form-group col-4">
            <label for="settings_max_reg">จำกัด IP/Account [สมัครสมาชิก]</label>
            <input type="number" class="form-control" required id="settings_max_reg" name="settings_max_reg" value="<?php echo $getSetting['settings_max_reg']; ?>">
          </div>
          <div class="col-12">
            <button id="btn_editSettings" type="button" class="btn btn-outline-success btn-block" onclick="editSettings()">
              <i class="fa fa-floppy-o"></i> บันทึก
            </button>
          </div>
        </div>
    </form>
  </div>
</div>