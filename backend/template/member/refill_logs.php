<?php
  $sql_refillLogs = "SELECT\n".
  " refill_logs.refill_logs_id,\n".
  " refill_logs.refill_logs_transaction,\n".
  " refill_logs.refill_logs_amount,\n".
  " refill_logs.time_reg,\n".
  " authme.realname,\n".
  " refill_type.refill_type_name\n".
  "FROM\n".
  "(\n".
  " SELECT * FROM refill_logs\n".
  ") AS refill_logs\n".
  "LEFT JOIN\n".
  "(\n".
  " SELECT id,username,realname FROM authme\n".
  ") AS authme ON (refill_logs.user_id = authme.id)\n".
  "LEFT JOIN\n".
  "(\n".
  " SELECT * FROM refill_type\n".
  ") AS refill_type ON (refill_logs.refill_type_id = refill_type.refill_type_id)\n".
  "ORDER BY refill_logs.time_reg DESC";

  $query_refillLogs = query($sql_refillLogs);
?>
<div class="card-title">
  <i class="fa fa-history"></i> ประวัติการเติมเงิน
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
    <table id="refilLogs_Table" class="table table-striped nowrap table-sm" style="width:100%;">
      <thead>
        <tr>
            <th>ลำดับ</th>
            <th>ชื่อผู้เล่น</th>
            <th>ระบบ</th>
            <th>หมายเลขอ้างอิง</th>
            <th>จำนวน (บาท)</th>
            <th>วันเวลา</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if($query_refillLogs->rowcount() <= 0)
          {
            ?>
              <tr>
                <td colspan="6" class="text-center">
                  ยังไม่มีประวัติการเติมเงิน
                </td>
              </tr>
            <?php
          }
          else
          {
            while($reillLogs = $query_refillLogs->fetch())
            {
              ?>
                <tr>
                  <td>
                    <?php echo $reillLogs['refill_logs_id']; ?>
                  </td>
                  <td>
                    <?php echo $reillLogs['realname']; ?>
                  </td>
                  <td>
                    <?php echo $reillLogs['refill_type_name']; ?>
                  </td>
                  <td>
                    <?php echo $reillLogs['refill_logs_transaction']; ?>
                  </td>
                  <td>
                    <?php echo $reillLogs['refill_logs_amount']; ?>
                  </td>
                  <td>
                    <?php echo $reillLogs['time_reg']; ?>
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