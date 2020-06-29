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
              <button id="addItemRandombox_btn" type="button" class="btn btn-success btn-block" onclick="addItemRandombox(<?php echo $randomboxSelect['randombox_id']; ?>)">เพิ่มไอเทม</button>
            </div>
          </form>
        <?php
      }
    ?>
  </div>
</div>