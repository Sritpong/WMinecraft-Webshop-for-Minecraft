<div class="card-title">
  โค้ด
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
  	<form id="frm_addCode" name="frm_addCode" method="POST">
        <div class="row">
          <div class="form-group col-6">
            <label for="code_value">โค้ด</label>
            <input type="text" class="form-control" required id="code_value" name="code_value">
          </div>
          <div class="form-group col-6">
            <label for="code_command">คำสั่ง</label>
            <input type="text" class="form-control" required id="code_command" name="code_command">
          </div>
          <div class="form-group col-6">
            <label for="code_type">ชนิดของโค้ด</label>
            <select name="code_type" id="code_type" class="form-control">
              <option value="1" selected>กรอกได้ครั้งเดียว คนเดียว</option>
              <option value="2">กรอกได้ 1 คน/ครั้ง ไม่จำกัดว่ากี่คน</option>
              <option value="3">กรอกได้ 1 คน/ครั้ง จำกัดว่ากี่คน</option>
            </select>
          </div>
          <div class="form-group col-6">
            <label for="code_redeem_amount">จำกัดจำนวนคน (ในกรณีเลือกชนิดของโค้ดเป็นแบบ กรอกได้ 1 คน/ครั้ง จำกัดว่ากี่คน)</label>
            <input type="number" class="form-control" required id="code_redeem_amount" name="code_redeem_amount" value="0">
          </div>
          <div class="form-group col-12">
            <label for="code_server">เซิฟเวอร์</label>
            <select name="code_server" id="code_server" class="form-control">
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
          <div class="col-12">
            <button id="btn_addCode" type="button" class="btn btn-outline-success btn-block" onclick="addCode()">
              เพิ่มโค้ด
            </button>
          </div>
        </div>
	</form>
	<hr/>
  	<table id="code_table" class="table table-striped nowrap table-sm" style="width:100%;">
      <thead>
        <tr>
            <th>ลำดับ</th>
            <th>โค้ด</th>
            <th>คำสั่ง</th>
            <th>ชนิดของโค้ด</th>
            <th>จำกัดจำนวนคน</th>
            <th>เซิฟเวอร์</th>
            <th>#</th>
        </tr>
      </thead>
      <tbody>
        <?php
        	$sql_code = "SELECT\n".
          " *\n".
          "FROM\n".
          "(\n".
          " SELECT * FROM `code`\n".
          ") AS code\n".
          "LEFT JOIN\n".
          "(\n".
          " SELECT server_id,server_name FROM `server`\n".
          ") AS server ON (server.server_id = code.server_id)";
        	$query_code = query($sql_code);

          	if($query_code->rowcount() <= 0)
          	{
          	  ?>
          	    <tr>
          	      <td colspan="7" class="text-center">
          	        ยังไม่มี Code
          	      </td>
          	    </tr>
          	  <?php
          	}
          	else
          	{
          	  while($code = $query_code->fetch())
          	  {
          	    ?>
          	      <tr>
          	        <td>
          	          <?php echo $code['code_id']; ?>
          	        </td>
          	        <td>
          	          <?php echo $code['code_value']; ?>
          	        </td>
          	        <td>
          	          <input type="text" class="form-control" value="<?php echo $code['code_command']; ?>" readonly>
          	        </td>
          	        <td>
          	          <?php
                        if($code['code_type'] == 1)
                        {
                          echo "กรอกได้ครั้งเดียว คนเดียว";
                        }
                        elseif($code['code_type'] == 2)
                        {
                          echo "กรอกได้ 1 คน/ครั้ง ไม่จำกัดว่ากี่คน";
                        }
                        elseif($code['code_type'] == 3)
                        {
                          echo "กรอกได้ 1 คน/ครั้ง จำกัดว่ากี่คน";
                        }
                      ?>
          	        </td>
          	        <td>
                      <?php echo $code['code_redeem_amount']; ?>
                    </td>
                    <td>
                      <?php echo $code['server_name']; ?>
                    </td>
          	        <td>
          	        	<button class="btn btn-outline-danger" onclick="delCode(<?php echo $code['code_id']; ?>)">
          	        		ลบ Code #<?php echo $code['code_id']; ?>
          	        	</button>
          	      </tr>
          	    <?php
          	  }
          	}
        ?>
      </tbody>
    </table>
  </div>
</div>