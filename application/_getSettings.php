<?php
	$sql_settings = "SELECT * FROM settings WHERE settings_id = :sid LIMIT 1";
	$query_settings = query($sql_settings,array(":sid" => '1'));

	if($query_settings->rowcount() != 0)
	{
		$settings = $query_settings->fetch();
	}
	else
	{
		exit("ไม่พบการต้ังค่าของ Webshop");
	}
?>