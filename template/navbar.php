<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo $config['site']; ?>"><?php echo $config['server_name']; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
    <a class="nav-item nav-link active" href="<?php echo $config['site']; ?>">หน้าหลัก <span class="sr-only">(current)</span></a>
    <a class="nav-item nav-link" href="?page=shop">ร้านค้า</a>
    <a class="nav-item nav-link" href="?page=topup">เติมเงิน</a>
    <a class="nav-item nav-link" href="?page=rdmcode">เติมโค้ด</a>
    <a class="nav-item nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
    </div>
  </div>
</nav>