<?php
  if(!isset($_SESSION['uid']))
  {
    include_once('template/member/login.php');
  }
  else
  {
    $sql_getRandombox = "SELECT * FROM randombox";
    $query_getRandombox = query($sql_getRandombox);
    ?>
      <div class="card">
        <div class="card-body">
            <h6>
                <i class="fa fa-gift"></i> กล่องสุ่ม
            </h6>
            <hr/>
            <div class="row">
              <div class="col-xl-12 col-lg-12 col-md-12 mb-10">
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
                              <div class="col-md-6">
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
                                  <b>
                                    <center style="margin-bottom:5px;">
                                      <?php echo $randombox['randombox_name']; ?>
                                    </center>
                                  </b>
                                  <button class="btn btn-outline-success btn-block" onclick="randombox(<?php echo $randombox['randombox_id']; ?>)">
                                    สุ่มเลย <?php echo number_format($randombox['randombox_price'], 2); ?> พ้อยท์ !
                                  </button>
                                </div>
                              </div>
                            <?php
                          }
                        ?>
                        </div>
                      </div>
                    <?php
                  }
                ?>
              </div>
            </div>
          </div>
      </div>
    <?php
  }
?>