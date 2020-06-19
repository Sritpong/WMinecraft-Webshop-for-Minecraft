<?php
	// Player ID: $_SESSION['uid'], Player Username: $_SESSION['username'], Player Realname: $_SESSION['realname']

	if(isset($_SESSION['uid']))
	{
		$sql_getPlayer = "SELECT * FROM authme WHERE id = :uid LIMIT 1";
		$query_getPlayer = query($sql_getPlayer,array(":uid" => $_SESSION['uid']));

		if($query_getPlayer->rowcount() != 0)
		{
			$player = $query_getPlayer->fetch();
		}
		else
		{
			unset($_SESSION['uid']);
			unset($_SESSION['username']);
			unset($_SESSION['realname']);
		}
	}

	if(isset($_SESSION['backend_uid']))
	{
		$sql_getPlayer = "SELECT * FROM authme WHERE id = :uid LIMIT 1";
		$query_getPlayer = query($sql_getPlayer,array(":uid" => $_SESSION['backend_uid']));

		if($query_getPlayer->rowcount() != 0)
		{
			$admin = $query_getPlayer->fetch();
		}
		else
		{
			unset($_SESSION['uid']);
			unset($_SESSION['username']);
			unset($_SESSION['realname']);
		}
	}
?>