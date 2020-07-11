<div class="card-title">
  Server
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
  	<form id="frm_addServer" name="frm_addServer" method="POST">
        <div class="row">
          <div class="form-group col-6">
            <label for="server_name">ชื่อเซิฟเวอร์</label>
            <input type="text" class="form-control" required id="server_name" name="server_name">
          </div>
          <div class="form-group col-6">
            <label for="server_ip">ไอพีเซิฟเวอร์</label>
            <input type="text" class="form-control" required id="server_ip" name="server_ip">
          </div>
          <div class="form-group col-12">
            <label for="server_port">พอร์ต Rcon</label>
            <input type="text" class="form-control" required id="server_port" name="server_port">
          </div>
          <div class="form-group col-12">
            <label for="server_password">รหัสผ่าน Rcon</label>
            <input type="text" class="form-control" required id="server_password" name="server_password">
          </div>
          <div class="col-12">
            <button id="btn_addServer" type="button" class="btn btn-outline-success btn-block" onclick="addServer()">
              เพิ่มเซิฟเวอร์
            </button>
          </div>
        </div>
	</form>
	<hr/>
  	<table id="shopLogs_Table" class="table table-striped nowrap table-sm" style="width:100%;">
      <thead>
        <tr>
            <th>ลำดับ</th>
            <th>ชื่อเซิฟเวอร์</th>
            <th>ไอพี</th>
            <th>พอร์ต Rcon</th>
            <th>รหัสผ่าน Rcon</th>
            <th>#</th>
        </tr>
      </thead>
      <tbody>
        <?php
        	$sql_server = "SELECT * FROM server";
        	$query_server = query($sql_server);

          	if($query_server->rowcount() <= 0)
          	{
          	  ?>
          	    <tr>
          	      <td colspan="6" class="text-center">
          	        ยังไม่มี Server
          	      </td>
          	    </tr>
          	  <?php
          	}
          	else
          	{
          	  while($server = $query_server->fetch())
          	  {
          	    ?>
          	      <tr>
          	        <td>
          	          <?php echo $server['server_id']; ?>
          	        </td>
          	        <td>
          	          <?php echo $server['server_name']; ?>
          	        </td>
          	        <td>
          	          <?php echo $server['server_ip']; ?>
          	        </td>
          	        <td>
          	          <?php echo $server['server_port']; ?>
          	        </td>
          	        <td>
          	          <?php echo $server['server_password']; ?>
          	        </td>
          	        <td>
          	        	<button class="btn btn-outline-danger">
          	        		ลบ Server #<?php echo $server['server_id']; ?>
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