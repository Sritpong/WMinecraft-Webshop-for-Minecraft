<?php
	if(isset($_SESSION['uid']))
	{
		echo "MEMBER DETAIL";
	}
	else
	{
		include_once 'template/login.php';
	}
?>