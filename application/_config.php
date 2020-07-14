<?php
	session_start();
	ini_set('display_errors', 0);
    date_default_timezone_set("Asia/Bangkok");
	
	$config = array(
		'site' => 'http://localhost/WMinecraft'
	);

	#MYSQL Config
	$mysql = array(
		'host' => 'localhost',
		'user' => 'root',
		'password' => '',
		'dbname' => 'wminecraft'
	);

	# ป้องกัน sql injection จาก $_GET
    foreach($_GET as $key => $value){
        $_GET[$key]=addslashes(strip_tags(trim($value)));
    }
    if(isset($_GET['id']) && $_GET['id'] !='')
    { 
        $_GET['id']=(int) $_GET['id'];
    }
    extract($_GET);
?>