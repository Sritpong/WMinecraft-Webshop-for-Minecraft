<nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <!-- logo -->
  <div class="text-left navbar-brand-wrapper">
    <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo-dark.png" alt="" ></a>
    <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-icon-dark.png" alt=""></a>
  </div>
  <!-- Top bar left -->
  <ul class="nav navbar-nav mr-auto">
    <li class="nav-item">
      <a id="button-toggle" class="button-toggle-nav inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu ti-align-right"></i></a>
    </li>
  </ul>
  <!-- top bar right -->
  <ul class="nav navbar-nav ml-auto">
    <li class="nav-item fullscreen">
      <a id="btnFullscreen" href="#" class="nav-link" ><i class="ti-fullscreen"></i></a>
    </li>
    <li class="nav-item dropdown ">
      <a class="nav-link top-nav" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <i class="ti-bell"></i>
        <span class="badge badge-danger notification-status"> </span>
      </a>
      <div class="dropdown-menu dropdown-menu-right dropdown-big dropdown-notifications">
        <div class="dropdown-header notifications">
          <strong>Notifications</strong>
          <span class="badge badge-pill badge-warning">05</span>
        </div>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">New registered user <small class="float-right text-muted time">Just now</small> </a>
      </div>
    </li>
    <li class="nav-item dropdown mr-30">
      <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <img src="https://minotar.net/avatar/<?php echo $_SESSION['backend_realname']; ?>" alt="avatar">
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-header">
          <div class="media">
            <div class="media-body">
              <h5 class="mt-0 mb-0">
                <?php
                  echo $admin['realname'];
                ?>  
              </h5>
              <span>
                <?php
                  echo $admin['email'];
                ?>
              </span>
            </div>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#"><i class="text-info ti-settings"></i>ตั้งค่าเว็บช็อป</a>
        <button id="logout_btn" type="button" class="dropdown-item" onclick="LogoutBackend('<?php echo $config['site']; ?>')"><i class="text-danger ti-unlock"></i>ออกจากระบบ</button>
      </div>
    </li>
  </ul>
</nav>