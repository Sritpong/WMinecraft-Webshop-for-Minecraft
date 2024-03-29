<?php
  if(isset($_GET['page']) && $_GET['page'] != 'shop')
  {
    $title_shop = '<i class="fa fa-shopping-cart"></i> Shop - สินค้าใหม่ 6 รายการ';
  }
  elseif(!isset($_GET['page']))
  {
    $title_shop = '<i class="fa fa-shopping-cart"></i> Shop - สินค้าใหม่ 6 รายการ';
  }
  else
  {
    $title_shop = '<i class="fa fa-shopping-cart"></i> Shop';
  }
?>
<div class="card">
    <div class="card-body">
        <h6>
            <?php echo $title_shop; ?>
        </h6>
        <hr/>
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
                    <div class="col-lg-4 col-md-6 col-xs-6">
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
                                    <button id="buy_item_<?php echo $product['shop_id']; ?>" onclick="BuyShop(<?php echo $product['shop_id'] ?>,'1')" class="btn btn-success w-100 mb-1 border-0">
                                        <i class="fa fa-cart-arrow-down"></i> ซื้อ
                                    </button>
                                    <button id="inventory_item_<?php echo $product['shop_id']; ?>" class="btn btn-secondary btn-sm" onclick="BuyShop(<?php echo $product['shop_id'] ?>,'2')">
                                      <small>เก็บเข้ากระเป๋าผู้เล่น</small>
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
    </div>
</div>