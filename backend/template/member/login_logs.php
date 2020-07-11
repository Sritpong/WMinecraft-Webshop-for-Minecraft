<?php
  $sql_loginLogs = "SELECT\n".
  " login_logs.*,\n".
  " authme.realname\n".
  "FROM\n".
  "(\n".
  " SELECT * FROM login_logs\n".
  ") AS login_logs\n".
  "LEFT JOIN\n".
  "(\n".
  " SELECT id,username,realname FROM authme\n".
  ") AS authme ON (login_logs.user_id = authme.id)\n".
  "ORDER BY login_logs.login_logs_id ASC";

  $query_loginLogs = query($sql_loginLogs);
?>
<div class="card-title">
  <i class="fa fa-sign-in"></i> ประวัติการเข้าสู่ระบบ
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
    <table id="loginLogs_table" class="table table-striped nowrap table-sm" style="width:100%;">
      <thead>
        <tr>
            <th>ลำดับ</th>
            <th>ชื่อผู้เล่น</th>
            <th>เข้าสู่ระบบจาก</th>
            <th>วันเวลา</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if($query_loginLogs->rowcount() <= 0)
          {
            ?>
              <tr>
                <td colspan="4">
                  ยังไม่มีประวัติการเข้าสู่ระบบ
                </td>
              </tr>
            <?php
          }
          else
          {
            while($loginLogs = $query_loginLogs->fetch())
            {
              ?>
                <tr>
                  <td>
                    <?php echo $loginLogs['login_logs_id']; ?>
                  </td>
                  <td>
                    <?php echo $loginLogs['realname']; ?>
                  </td>
                  <td>
                    <?php echo $loginLogs['login_logs_browser']."/".$loginLogs['login_logs_os']; ?>
                  </td>
                  <td>
                    <?php echo $loginLogs['time_reg']; ?>
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