<nav class="navbar navbar-expand-lg bg-white shadow mb-3" style="border-radius: 15px 15px 15px 15px;">
  <button class="navbar-toggler text-dark" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="fa fa-list-ul"></span>
    <small>
      เปิด/ปิด เมนู
    </small>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <ul class="navbar-nav mr-auto pt-3 pt-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $config['site']; ?>"><img src="menu/main.png" style="width:20px;height:20px;">
            <span class="pull-right">
              <span id="xnav-upp">&nbsp;&nbsp;<b>หน้าหลัก</b></span>
            </span>
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $config['site']; ?>/?page=topup"><img src="menu/topup.png" style="width:20px;height:20px;">
            <span class="pull-right">
              <span id="xnav-upp">&nbsp;&nbsp;<b>เติมเงิน</b></span>
            </span>
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $config['site']; ?>/?page=shop"><img src="menu/shop.png" style="width:20px;height:20px;">
            <span class="pull-right">
              <span id="xnav-upp">&nbsp;&nbsp;<b>ร้านค้า</b></span>
            </span>
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $config['site']; ?>/?page=code"><i class="fa fa-barcode text-info mt-1"></i>
            <span class="pull-right">
              <span id="xnav-upp">&nbsp;&nbsp;<b>เติมโค้ด</b></span>
            </span>
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $config['site']; ?>/?page=diary">
            <i class="fa fa-check text-success mt-1"></i>
            <span class="pull-right">
              <span id="xnav-upp">&nbsp;&nbsp;<b>เช็คชื่อรายวัน</b></span>
            </span>
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $config['site']; ?>/?page=backpack">
            <i class="fa fa-gift text-danger mt-1"></i>
            <span class="pull-right">
              <span id="xnav-upp">&nbsp;&nbsp;<b>กระเป๋าผู้เล่น</b></span>
            </span>
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo $config['site']; ?>/?page=randombox">
            <i class="fa fa-gift text-warning mt-1"></i>
            <span class="pull-right">
              <span id="xnav-upp">&nbsp;&nbsp;<b>สุ่มกล่อง</b></span>
            </span>
            <span class="sr-only">(current)</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>