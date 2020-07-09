<div class="side-menu-fixed">
  <div class="scrollbar side-menu-bg">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
      <li> 
        <a href="<?php echo $config['site']; ?>/Backend">
          <i class="fa fa-dashboard"></i><span class="right-nav-text">ภาพรวม </span>
        </a>  
      </li>
      <!-- menu title -->
      <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">การใช้งาน Webshop</li>
      <!-- menu item Elements-->
      <li>
        <a href="javascript:void(0);" data-toggle="collapse" data-target="#history">
          <div class="pull-left"><i class="fa fa-history"></i><span class="right-nav-text">ประวัติการใช้งาน</span></div>
          <div class="pull-right"><i class="ti-plus"></i></div><div class="clearfix"></div>
        </a>
        <ul id="history" class="collapse" data-parent="#sidebarnav">
          <li>
            <a href="?page=loginLogs">
              ประวัติการเข้าสู่ระบบ
            </a>
          </li>
          <li>
            <a href="?page=shopLogs">
              ประวัติการซื้อของ
            </a>
          </li>
          <li>
            <a href="?page=refillLogs">
              ประวัติการเติมเงิน
            </a>
          </li>
        </ul>
      </li>
      <!-- menu title -->
      <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">จัดการ Webshop</li>
      <!-- menu item Elements-->
      <li>
        <a href="?page=manageShop">
          <i class="fa fa-sliders"></i><span class="right-nav-text">จัดการสินค้า</span>
        </a>
      </li>
      <li> 
        <a href="?page=randombox">
          <i class="fa fa-sliders"></i><span class="right-nav-text">จัดการกล่องสุ่ม</span>
        </a>  
      </li>
      <!-- menu title -->
      <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">ตั้งค่า Webshop</li>
      <!-- menu item Elements-->
      <li> 
        <a href="?page=settingWallet">
          <i class="fa fa-sliders"></i><span class="right-nav-text">ตั้งค่าบัญชี Wallet</span>
        </a>  
      </li>
    </ul>
  </div> 
</div> 