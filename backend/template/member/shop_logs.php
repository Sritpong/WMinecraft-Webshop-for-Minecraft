<?php
  $sql_shopLogs = "SELECT\n".
  " shop_logs.*,\n".
  " authme.realname,\n".
  " shop.shop_name,\n".
  " server.server_name\n".
  "FROM\n".
  "(\n".
  " SELECT * FROM shop_logs\n".
  ") AS shop_logs\n".
  "LEFT JOIN\n".
  "(\n".
  " SELECT id,username,realname FROM authme\n".
  ") AS authme ON (shop_logs.user_id = authme.id)\n".
  "LEFT JOIN\n".
  "(\n".
  " SELECT shop_id,shop_name,server_id FROM shop\n".
  ") AS shop ON (shop.shop_id = shop_logs.shop_id)\n".
  "LEFT JOIN\n".
  "(\n".
  " SELECT server_id,server_name FROM server\n".
  ") AS server ON (server.server_id = shop.server_id)\n".
  "ORDER BY shop_logs.shop_logs_id DESC";

  $query_shopLogs = query($sql_shopLogs);
?>
<div class="card-title">
  <i class="fa fa-history"></i> ประวัติการซื้อสินค้า
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
    <table id="shopLogs_Table" class="table table-striped nowrap table-sm" style="width:100%;">
      <thead>
        <tr>
            <th>ลำดับ</th>
            <th>ชื่อผู้เล่น</th>
            <th>ชื่อสินค้า</th>
            <th>ชื่อเซิฟเวอร์</th>
            <th>วันเวลา</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if($query_shopLogs->rowcount() <= 0)
          {
            ?>
              <tr>
                <td colspan="5">
                  ยังไม่มีประวัติการซื้อสินค้า
                </td>
              </tr>
            <?php
          }
          else
          {
            while($shopLogs = $query_shopLogs->fetch())
            {
              ?>
                <tr>
                  <td>
                    <?php echo $shopLogs['shop_logs_id']; ?>
                  </td>
                  <td>
                    <?php echo $shopLogs['realname']; ?>
                  </td>
                  <td>
                    <?php echo $shopLogs['shop_name']; ?>
                  </td>
                  <td>
                    <?php echo $shopLogs['server_name']; ?>
                  </td>
                  <td>
                    <?php echo $shopLogs['time_reg']; ?>
                  </td>
                </tr>
              <?php
            }
          }
        ?>
      </tbody>
    </table>
  </div>
</div>