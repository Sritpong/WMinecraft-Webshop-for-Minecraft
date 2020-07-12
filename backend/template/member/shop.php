<div class="card-title">
  สินค้า
</div>
<div class="row">
  <div id="btn_addItem" class="col-12" style="display: block;">
    <button class="btn btn-outline-primary btn-block" onclick="showFrmAddItem()">
      เพิ่มสินค้า
    </button>
  </div>
  <div id="frm_addItem" class="col-12" style="display: none;">
    <button class="btn btn-outline-primary btn-block mb-3" onclick="HideFrmAddItem()">
      ซ่อน Form เพิ่มสินค้า
    </button>
    <hr/>
    <form name="add_ShopItem" method="POST">
      <div class="row">
        <div class="form-group col-6">
          <label for="item_name">ชื่อสินค้า</label>
          <input type="text" class="form-control" required id="item_name" name="item_name">
        </div>
        <div class="form-group col-6">
          <label for="item_img">รูป [URL]</label>
          <input type="text" class="form-control" required id="item_img" name="item_img">
        </div>
        <div class="form-group col-6">
          <label for="item_command">คำสั่ง</label>
          <input type="text" class="form-control" required id="item_command" name="item_command">
        </div>
        <div class="form-group col-6">
          <label for="item_price">ราคา</label>
          <input type="text" class="form-control" required id="item_price" name="item_price">
        </div>
        <div class="form-group col-6">
          <label for="item_recommend">สินค้าแนะนำ</label>
          <select name="item_recommend" id="item_recommend" class="form-control">
            <option value="0">ปิด</option>
            <option value="1">เปิด</option>
          </select>
        </div>
        <div class="form-group col-6">
          <label for="category_id">หมวดหมู่</label>
          <select name="category_id" id="category_id" class="form-control">
            <option value="0">-- กรุณาเลือก หมวดหมู่ --</option>
            <?php
              $c_q = query("SELECT * FROM category");
              while($c = $c_q->fetch())
              {
                ?>
                  <option value="<?php echo $c['category_id']; ?>"><?php echo $c['category_name']; ?></option>
                <?php
              }
            ?>
          </select>
        </div>
        <div class="form-group col-12">
          <label for="for_sv">เซิฟเวอร์</label>
          <select name="for_sv" id="for_sv" class="form-control">
            <option value="0">-- กรุณาเลือก Server --</option>
            <?php
              $sv_q = query("SELECT * FROM server");
              while($sv = $sv_q->fetch())
              {
                ?>
                  <option value="<?php echo $sv['server_id']; ?>"><?php echo $sv['server_name']; ?></option>
                <?php
              }
            ?>
          </select>
        </div>
        <div class="col-12">
          <button id="btn_addShopItem" type="button" class="btn btn-outline-success btn-block" onclick="addShopItem()">เพิ่มสินค้า</button>
        </div>
      </div>
    </form>
  </div>
</div>
<hr/>
<div class="row" id="frm_editItem" style="display: none;">
  <div class="col-12">
    <button class="btn btn-outline-primary btn-block mb-3" onclick="HideFrmEditItem()">
      ซ่อน Form แก้ไขสินค้า
    </button>
    <hr/>
    <form name="add_ShopItem" method="POST">
      <div class="row">
        <div class="form-group col-6">
          <label for="edit_item_name">ชื่อสินค้า</label>
          <input type="text" class="form-control" required id="edit_item_name" name="edit_item_name">
        </div>
        <div class="form-group col-6">
          <label for="edit_item_img">รูป [URL]</label>
          <input type="text" class="form-control" required id="edit_item_img" name="edit_item_img">
        </div>
        <div class="form-group col-6">
          <label for="edit_item_command">คำสั่ง</label>
          <input type="text" class="form-control" required id="edit_item_command" name="edit_item_command">
        </div>
        <div class="form-group col-6">
          <label for="edit_item_price">ราคา</label>
          <input type="text" class="form-control" required id="edit_item_price" name="edit_item_price">
        </div>
        <div class="form-group col-6">
          <label for="edit_item_recommend">สินค้าแนะนำ</label>
          <select name="edit_item_recommend" id="edit_item_recommend" class="form-control">
            <option value="0">ปิด</option>
            <option value="1">เปิด</option>
          </select>
        </div>
        <div class="form-group col-6">
          <label for="edit_category_id">หมวดหมู่</label>
          <select name="edit_category_id" id="edit_category_id" class="form-control">
            <option value="0">-- กรุณาเลือก หมวดหมู่ --</option>
            <?php
              $c_q = query("SELECT * FROM category");
              while($c = $c_q->fetch())
              {
                ?>
                  <option value="<?php echo $c['category_id']; ?>"><?php echo $c['category_name']; ?></option>
                <?php
              }
            ?>
          </select>
        </div>
        <div class="form-group col-12">
          <label for="edit_for_sv">เซิฟเวอร์</label>
          <select name="edit_for_sv" id="edit_for_sv" class="form-control">
            <option value="0">-- กรุณาเลือก Server --</option>
            <?php
              $sv_q = query("SELECT * FROM server");
              while($sv = $sv_q->fetch())
              {
                ?>
                  <option value="<?php echo $sv['server_id']; ?>"><?php echo $sv['server_name']; ?></option>
                <?php
              }
            ?>
          </select>
        </div>
        <div class="col-12">
          <button id="btn_editShopItem" type="button" class="btn btn-outline-success btn-block" onclick="editShopItem()">แก้ไขสินค้า</button>
        </div>
      </div>
    </form>
    <div class="col-12">
      <hr/>
    </div>
  </div>
</div>
<div class="row">
  <?php
    $sql_product = "SELECT * FROM (\n";

    if(isset($_GET['page']) && $_GET['page'] != 'shop')
    {
      $sql_product .= 'SELECT * FROM shop ORDER BY shop_id DESC';
    }
    elseif(!isset($_GET['page']))
    {
      $sql_product .= 'SELECT * FROM shop ORDER BY shop_id DESC';
    }
    else
    {
      $sql_product .= 'SELECT * FROM shop ';
    }

    if(isset($_GET['server']) && is_numeric($_GET['server']))
    {
      $sql_product .= ' WHERE server_id = "'.$_GET['server'].'"';
    }

    if(isset($_GET['category']) && is_numeric($_GET['category']))
    {
      if(isset($_GET['server']) && is_numeric($_GET['server']))
      {
        $sql_product .= ' AND category_id = "'.$_GET['category'].'"';
      }
      else
      {
        $sql_product .= ' WHERE category_id = "'.$_GET['category'].'"';
      }
    }

    if(isset($_GET['page']) && $_GET['page'] != 'shop')
    {
      $sql_product .= ' LIMIT 6';
    }
    elseif(!isset($_GET['page']))
    {
      $sql_product .= ' LIMIT 6';
    }

    $sql_product .= "\n) AS shop\n".
    "LEFT JOIN(\n".
    " SELECT server_id,server_name FROM server".
    ") AS server ON (server.server_id = shop.server_id)";

    $query_product = query($sql_product);

    if($query_product->rowcount() <= 0)
    {
      echo "<h5 class='col-md-12 text-center'>ไม่พบสินค้า</h5>";
    }
    else
    {
      while($product = $query_product->fetch())
      {
        ?>
          <div class="col-lg-3 col-md-3 col-xs-12" id="item_id_<?php echo $product['shop_id']; ?>">
              <div class="item mb-2" style="border-radius: 5px 5px 5px 5px;">
                  <div class="item-image">
                      <a class="item-image-price"><?php echo number_format($product['shop_price'], 2); ?> พ้อยท์</a>
                      <?php
                        if($product['shop_recommended'] == 1)
                        {
                          echo '<a class="item-image-new">สินค้าแนะนำ</a>';
                        }
                      ?>
                      <center>
                          <img src="<?php echo $product['shop_img']; ?>">
                      </center>
                      <a class="item-image-bottom text-center"><?php echo $product['shop_name']; ?></a>
                  </div>
                  <div class="item-info">
                      <div class="item-text">
                          <a><?php echo $product['shop_name']; ?></a>
                          <br/>
                          <small>
                            <a>
                              Server: <?php echo $product['server_name']; ?>
                            </a>
                          </small>
                          <button id="edit_item_<?php echo $product['shop_id']; ?>" class="btn btn-success w-100 mb-1 border-0" onclick="btn_editShopItem(<?php echo $product['shop_id']; ?>)">
                              <i class="fa fa-cart-arrow-down"></i> แก้ไข
                          </button>
                          <button id="del_item_<?php echo $product['shop_id']; ?>" class="btn btn-danger btn-sm" onclick="DelShopItem(<?php echo $product['shop_id']; ?>)">
                            <small>ลบ</small>
                          </button>
                      </div>
                  </div>
              </div>
          </div>
        <?php
      }
    }
  ?>
</div>