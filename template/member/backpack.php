<?php
  if(!isset($_SESSION['uid']))
  {
    include_once('template/member/login.php');
  }
  else
  {
    ?>
      <div class="card">
        <div class="card-body">
            <h6>
                <i class="fa fa-gift"></i> กระเป๋าผู้เล่น
                <div class="pull-right">
                  <span class="badge badge-pill badge-danger">กรุณาออนไลน์ใน Server ก่อนจะกดรับด้วย</span>
                </div>
            </h6>
            <hr/>
              <?php
                $sql_backpack = "SELECT\n".
                " backpack.*,\n".
                " server.server_name\n".
                "FROM\n".
                "(\n".
                " SELECT * FROM backpack WHERE backpack_status = 0 AND user_id = :uid\n".
                ") AS backpack\n".
                "LEFT JOIN\n".
                "(\n".
                " SELECT * FROM server\n".
                ") AS server ON (server.server_id = backpack.server_id)";
                $query_backpack = query($sql_backpack, array(
                  ':uid' => $_SESSION['uid']
                ));
              ?>
              <table id="backpack_table" class="table table-striped nowrap table-sm" style="width:100%;">
                <thead>
                  <tr>
                      <th>#</th>
                      <th>ชื่อ</th>
                      <th>คนที่ส่งให้</th>
                      <th>เซิฟเวอร์</th>
                      <th>วันที่</th>
                      <th>รับ</th>
                  </tr>
                </thead>
                <tbody id="tbody_backpack_table">
                  <?php
                    while($backpack = $query_backpack->fetch())
                    {
                      ?>
                        <tr>
                          <td>
                            <img src="<?php echo $backpack['backpack_img']; ?>" class="rounded mx-auto d-block" width="40" height="40">
                          </td>
                          <td>
                            <?php echo $backpack['backpack_name']; ?>
                          </td>
                          <td>
                            <?php
                              if($backpack['backpack_gift_status'] == 1)
                              {
                                echo $backpack['backpack_gift_player'];
                              }
                              else
                              {
                                echo "-";
                              }
                            ?>
                          </td>
                          <td>
                            <?php echo $backpack['server_name']; ?>
                          </td>
                          <td>
                            <?php echo date_format(date_create($backpack['time_reg']), 'd/m/Y'); ?>
                          </td>
                          <td>
                            <button id="receiveBackpack_<?php echo $backpack['backpack_id']; ?>" class="btn btn-primary btn-block btn-sm my-1" onclick="receiveBackpack(<?php echo $backpack['backpack_id']; ?>)">
                              รับ..
                            </button>
                          </td>
                        </tr>
                      <?php
                    }
                  ?>
                </tbody>
              </table>
          </div>
      </div>
    <?php
  }
?>