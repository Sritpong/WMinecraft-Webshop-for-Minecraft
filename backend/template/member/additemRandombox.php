<?php
  if(isset($_GET['id']))
  {
    $sql_getRandomboxSelect = "SELECT\n".
    " randombox.*,\n".
    " COUNT(randombox_item.randombox_item_id) AS count\n".
    "FROM\n".
    "(\n".
    " SELECT * FROM randombox WHERE randombox_id = :id\n".
    ") AS randombox\n".
    "LEFT JOIN\n".
    "(\n".
    " SELECT * FROM randombox_item GROUP BY randombox_item_code\n".
    ") AS randombox_item ON (randombox_item.randombox_id = randombox.randombox_id)";
    $query_getRandomboxSelect = query($sql_getRandomboxSelect, array(
      ':id' => $_GET['id']
    ));
    $randomboxSelect = $query_getRandomboxSelect->fetch();
  }
?>
<div class="card-title">
  เพิ่มไอเทม - <?php echo $randomboxSelect['randombox_name']; ?>
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
    <?php
      if(isset($_GET['id']))
      {
        ?>
          <form name="add_item" method="POST">
            <div class="row">
              <div class="form-group col-6">
                <label for="item_name">ชื่อไอเทม</label>
                <input type="text" class="form-control" required id="item_name" name="item_name">
              </div>
              <div class="form-group col-6">
                <label for="item_percent">% ในการออก (ตัวเลขเท่านั้น)</label>
                <input type="text" class="form-control" required id="item_percent" name="item_percent">
              </div>
              <div class="form-group col-12">
                <label for="item_img">รูป [URL]</label>
                <input type="text" class="form-control" required id="item_img" name="item_img">
              </div>
              <div class="form-group col-6">
                <label for="item_command">คำสั่ง</label>
                <input type="text" class="form-control" required id="item_command" name="item_command">
              </div>
              <div class="form-group col-6">
                <label for="for_sv">Server</label>
                <select name="for_sv" id="for_sv" class="form-control">
                  <option value="0">-- กรุณาเลือก Server --</option>
                  <?php
                    $sv_q = query("SELECT * FROM server");
                    while($sv = $sv_q->fetch())
                    {
                      ?>
                        <option value="<?php echo $sv['server_id'] ?>"><?php echo $sv['server_name'] ?></option>
                      <?php
                    }
                  ?>
                </select>
              </div>
              <button id="addItemRandombox_btn" type="button" class="btn btn-outline-success btn-block" onclick="addItemRandombox(<?php echo $randomboxSelect['randombox_id']; ?>)">เพิ่มไอเทม</button>
            </div>
          </form>
        <?php
      }
    ?>
    <hr/>
    <div class="card my-3">
      <div class="card-header bg-success text-white">ไอเทม <small>[คลิกที่รูปไอเทมเพื่อลบ]</small></div>
      <div class="card-body">
        <div class="row">
        <?php
          $sql_item = "SELECT\n".
          " *\n".
          "FROM\n".
          "(\n".
          " SELECT * FROM randombox_item WHERE randombox_id = :randombox_id\n".
          " GROUP BY randombox_item_code ORDER BY randombox_item_id DESC\n".
          ") AS randombox_item\n".
          "LEFT JOIN\n".
          "(\n".
          " SELECT\n".
          "   randombox_item_id,\n".
          "   randombox_item_code,\n".
          "   COUNT(randombox_item_code) AS percent\n".
          " FROM randombox_item GROUP BY randombox_item_code\n".
          ") AS percent ON (randombox_item.randombox_item_id = percent.randombox_item_id)";
          $query_item = query($sql_item, array(
            ':randombox_id' => $_GET['id']
          ));
            if($query_item->rowCount() > 0)
            {
              while($item = $query_item->fetch())
              {
                ?>
                    <div class="col-md-3">
                      <a onclick="delRandomboxItem('<?php echo $item['randombox_item_code']; ?>')">
                        <img src="<?php echo $item['randombox_item_img']; ?>" class="img-thumbnail rounded mx-auto d-block" alt="<?php echo $item['randombox_item_name']; ?>" data-toggle="tooltip" data-html="true" data-placement="top" title="<?php echo $item['randombox_item_name']."<br/>โอกาศที่จะได้รับ: ".$item['percent']."%<br/><b><small>คลิกที่รูปเพื่อลบออก</small></b>"; ?>">
                      </a>
                    </div>
                <?php
              }
            }
            else
            {
              echo "<div class='col-12 text-center'><b>ไม่มีไอเทมในกล่องสุ่มนี้</b></div>";
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>