<div class="card">
    <div class="card-body">
        <h6>
          <i class="fa fa-check"></i> เช็คชื่อรับของ
        </h6>
        <hr/>
        <div class="row">
            <?php
              $sql_diary = "SELECT\n".
              " diary.*,\n".
              " server.server_name,\n".
              " COUNT(diary.diary_id) AS count,\n".
              " COUNT(diary_logs.diary_logs_id) AS count_logs\n".
              "FROM\n".
              "(\n".
              " SELECT * FROM diary WHERE diary_date = :today\n".
              ") AS diary\n".
              "LEFT JOIN\n".
              "(\n".
              " SELECT * FROM server\n".
              ") AS server ON (server.server_id = diary.server_id)".
              "LEFT JOIN\n".
              "(\n".
              " SELECT * FROM diary_logs WHERE user_id = :uid\n".
              ") AS diary_logs ON (diary_logs.diary_id = diary.diary_id)";
              $query_diary = query($sql_diary, array(
                ':today' => date("Y-m-d"),
                ':uid' => $_SESSION['uid']
              ));
              $diary = $query_diary->fetch();
              //date("Y-m-d", strtotime("-31 day"))

              if($diary['count'] <= 0)
              {
                echo "<h5 class='col-md-12 text-center'>วันนี้ยังไม่มีให้เช็คชื่อ</h5>";
              }
              else
              {
                ?>
                  <div class="col-md-4">
                    <div class="item mb-2" style="border-radius: 5px 5px 5px 5px;">
                      <div class="item-image">
                        <center>
                          <img src="<?php echo $diary['diary_img']; ?>">
                        </center>
                      </div>
                    </div>
                  </div>
                  <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-0 text-success">
                      <?php echo "Server: ".$diary['server_name']; ?>
                    </strong>
                    <h3 class="mb-0">
                      <?php echo $diary['diary_name']; ?>
                    </h3>
                    <div class="mb-1 text-muted">
                      #เช็คชื่อประจำวันที่: <?php echo date_format(date_create($diary['diary_date']), 'd/m/Y'); ?>
                    </div>
                    <button id="diary_btn" class="btn btn-outline-primary btn-block btn-xs mt-2" <?php if($diary['count_logs'] > 0 || !isset($_SESSION['uid'])){ echo 'disabled'; } ?> onclick="receiveDiary()">
                      เช็คชื่อ !
                    </button>
                  </div>
                <?php
              }
            ?>
        </div>
    </div>
</div>