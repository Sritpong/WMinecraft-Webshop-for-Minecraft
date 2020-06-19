<?php
	require_once("../application/_config.php");
	require_once("../application/_getPlayer.php");	
	require_once("../application/_getInfoServer.php");
?>
<html>
	<head>
		<?php include_once 'template/taghead.php'; ?>
	</head>
	<body>
		<?php
			if(!isset($_SESSION['backend_uid']))
			{
				include_once("template/member/login.php");
			}
			else
			{
				?>
					<div class="wrapper">
					  <div id="pre-loader">
					      <img src="images/pre-loader/loader-01.svg" alt="">
					  </div>
					  <?php
					  	include_once("template/navbar.php");
					  ?>
					  <div class="container-fluid">
					    <div class="row">
					      <?php
					      	include_once("template/slidebar.php");
					      ?>
					      <div class="content-wrapper">
					        <div class="page-title">
					          <div class="row">
					          <div class="col-sm-6">
					           <h4 class="mb-0"> Page Title</h4>
					          </div>
					          <div class="col-sm-6">
					            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
					            <li class="breadcrumb-item"><a href="#" class="default-color">Home</a></li>
					            <li class="breadcrumb-item active">Page Title</li>
					            </ol>
					          </div>
					          </div>
					        </div> 
					        <div class="row">   
					          <div class="col-md-12 mb-30">     
					            <div class="card card-statistics h-100"> 
					              <div class="card-body">   
					                //BODY
					              </div>
					            </div>   
					          </div> 
					        </div> 
					        <?php
					        	include_once("template/endsite.php");
					        ?>
					      </div> 
					    </div>
					  </div>
					</div>
				<?php
			}
		?>
		<?php
			include_once("template/footer.php");
		?>
	</body>
</html>