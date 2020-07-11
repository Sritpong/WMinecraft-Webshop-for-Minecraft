<?php
  $sql_getRandombox = "SELECT * FROM randombox";
  $query_getRandombox = query($sql_getRandombox);
?>
<div class="card-title">
  กล่องสุ่ม
</div>
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
    <div id="btn_addRandomBox" class="col-12" style="display: block;">
      <button class="btn btn-outline-primary btn-block" onclick="showFrmAddRandombox()">
        เพิ่มกล่องสุ่ม
      </button>
      <hr/>
    </div>
    <div id="frm_addRandombox" class="col-12" style="display: none;">
      <button class="btn btn-outline-primary btn-block mb-3" onclick="hideFrmAddRandombox()">
        ซ่อน Form เพิ่มกล่องสุ่ม
      </button>
      <hr/>
      <form id="add_randombox" name="add_randombox" method="POST">
        <div class="row">
          <div class="form-group col-6">
            <label for="randombox_name">ชื่อกล่องสุ่ม</label>
            <input type="text" class="form-control" required id="randombox_name" name="randombox_name">
          </div>
          <div class="form-group col-6">
            <label for="randombox_price">สุ่มครั้งละ (พ้อยท์)</label>
            <input type="text" class="form-control" required id="randombox_price" name="randombox_price">
          </div>
          <div class="form-group col-12">
            <label for="randombox_img">รูป [URL]</label>
            <input type="text" class="form-control" required id="randombox_img" name="randombox_img">
          </div>
          <div class="col-12">
            <button id="btn_addRandomBox" type="button" class="btn btn-outline-success btn-block" onclick="addRandombox()">
              เพิ่มกล่องสุ่ม
            </button>
          </div>
        </div>
      </form>
      <hr/>
    </div>
    <?php
      if($query_getRandombox->rowCount() > 0)
      {
        ?>
          <div class="container">
            <div class="row">
            <?php
              while($randombox = $query_getRandombox->fetch())
              {
                ?>
                  <div class="col-md-3">
                    <div class="bg-light gift_cont_box" style="background-color:#EBEBEB;margin-bottom:20px; padding">
                        <center>
                          <img src="<?php
                            if(!empty($randombox['randombox_img']))
                            {
                              $img_data = $randombox['randombox_img'];
                              $img_data = explode(",", $img_data);
                              echo $img_data[0];
                            }
                            else
                            {
                              echo $config['site'].'/img/blank.png';
                            } 
                          ?>
                          " style="height:150px; width:150px; margin-bottom:10px;">
                      </center>
                      <b><center style="margin-bottom:5px;"><?php echo $randombox['randombox_name']; ?>
                      <br/>
                      สุ่มครั้งละ <?php echo number_format($randombox['randombox_price']); ?> บาท</center></b>
                      <a href="?page=additemRandombox&id=<?php echo $randombox['randombox_id']; ?>" class="btn btn-success btn-block"><b>เลือกกล่องสุ่มนี้</b></a>
                    </div>
                  </div>
                <?php
              }
            ?>
            </div>
          </div>
        <?php
      }
      else
      {
        echo "<h5 class='col-md-12 text-center'>ยังไม่มีกล่องสุ่ม</h5>";
      }
    ?>
  </div>
</div>