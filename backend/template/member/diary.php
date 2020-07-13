<div class="card-title">
  Diary
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
  	<form id="frm_addDiary" name="frm_addDiary" method="POST">
        <div class="row">
        	<div class="form-group col-6">
	            <label for="diary_name">ชื่อไอเทม/สินค้า</label>
	            <input name="diary_name" id="diary_name" type="text" class="form-control">
	        </div>
	        <div class="form-group col-6">
	            <label for="diary_command">คำสั่ง</label>
	            <input name="diary_command" id="diary_command" type="text" class="form-control">
	        </div>
	        <div class="form-group col-12">
	            <label for="diary_img">รูปภาพ [URL]</label>
	            <input name="diary_img" id="diary_img" type="text" class="form-control">
	        </div>
	        <div class="form-group col-6">
	          <label for="diary_server">เซิฟเวอร์</label>
	          <select name="diary_server" id="diary_server" class="form-control">
	            <option value="0">-- กรุณาเลือก Server --</option>
	            <?php
	              $sv_q = query("SELECT * FROM server");
	              while($sv = $sv_q->fetch())
	              {
	                ?>
	                  <option value="<?php echo $sv['server_id']; ?>"><?php echo $sv['server_name']; ?></option>
	                <?php
	              }
	            ?>
	          </select>
	        </div>
          	<div class="form-group col-6">
            	<label for="diary_datepicker">วันที่</label>
            	<input name="diary_datepicker" id="diary_datepicker" class="form-control" data-date-format="dd/mm/yyyy">
         	 </div>
          	<div class="col-12">
            	<button id="btn_addDiary" type="button" class="btn btn-outline-success btn-block" onclick="addDiary()">
              		เพื่มเช็คชื่อรายวัน
            	</button>
          	</div>
        </div>
	</form>
	<hr/>
	<a href="<?php echo $config['site']; ?>/?page=diary" target="_blank" class="btn btn-info btn-block">
		ดูของเช็คชื่อรายวัน วันนี้
	</a>
  </div>
</div>