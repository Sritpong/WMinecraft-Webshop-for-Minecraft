<?php
	session_start();
	
	$settings = Array (
		'site' => 'http://localhost/WMinecraft',
		'server_name' => 'WMinecraft'
	);

	#MYSQL Config
	$mysql = Array (
		'host' => 'localhost',
		'user' => 'root',
		'password' => '',
		'database' => ''
	);

	if(!isset($mysql)){exit;}
	try
	{
		$engine = new PDO("mysql:host=".$mysql['host']."; dbname=".$mysql['dbname'].";charset=utf8", $mysql['user'], $mysql['password']);
		$engine->exec("set names utf8");
	}
	catch (PDOException $e)
	{
		echo '<b>DB Err-> </b>'.$e->getMessage();
		exit;
	}

	function query($sql,$array=array())
	{
		global $engine;
		$q = $engine->prepare($sql);
		$q->execute($array);
		return $q;
	}

?>