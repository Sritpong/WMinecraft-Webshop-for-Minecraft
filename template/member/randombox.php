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
                            $sql_itemRandombox = "SELECT\n".
                            " randombox_item.*,\n".
                            " server.server_name\n".
                            "FROM\n".
                            "(\n".
                            " SELECT * FROM randombox_item WHERE randombox_id = :randombox_id GROUP BY randombox_item_code\n".
                            ") AS randombox_item\n".
                            "LEFT JOIN\n".
                            "(\n".
                            " SELECT server_id, server_name FROM server\n".
                            ") AS server ON (server.server_id = randombox_item.server_id)";
                            $query_itemRandombox = query($sql_itemRandombox, array(
                              ':randombox_id' => $randombox['randombox_id']
                            ));
                            $tooltipTitle = "<b>List ของในกล่องสุ่มนี้</b>";
                            if($query_itemRandombox->rowCount() <= 0)
                            {
                              $tooltipTitle .= "<br/>ไม่มีไอเทมในกล่องสุ่มนี้";
                            }
                            else
                            {
                              while($itemRandombox = $query_itemRandombox->fetch())
                              {
                                $tooltipTitle .= "<br/>- <b>".$itemRandombox['randombox_item_name']."</b> <small>[Server: ".
                                $itemRandombox['server_name']."]</small>";
                              }
                            }

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
                                      " style="height:150px; width:150px; margin-bottom:10px;" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<?php echo $tooltipTitle; ?>">
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