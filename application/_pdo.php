<?php
	if(!isset($mysql))
	{
		exit;
	}

	try
	{
		$engine = new PDO("mysql:host=".$mysql['host']."; dbname=".$mysql['dbname'].";charset=utf8", $mysql['user'], $mysql['password']);
		$engine->exec("set names utf8");
	}
	catch (PDOException $e)
	{
		exit('<b>DB Err-> </b>'.$e->getMessage());
	}

	function query($sql,$array=array())
	{
		global $engine;
		$q = $engine->prepare($sql);
		$q->execute($array);
		return $q;
	}
?>