<?php
	require_once("application/_config.php");
	require_once("application/_pdo.php");

	$sql_authme = "SELECT * FROM authmee ORDER BY id ASC";
	$query_authme = query($sql_authme);

	while($authme = $query_authme->fetch())
	{
		// $sql_insertAuthme = "INSERT INTO authme (username,realname,password,ip,email,points) VALUES ".
		// "(:username,:realname,:password,:ip,:email,:points)";
		// $query_insertAuthme = query($sql_insertAuthme, array(
		// 	':username' => $authme['username'],
		// 	':realname' => $authme['realname'],
		// 	':password' => $authme['password'],
		// 	':ip' => $authme['ip'],
		// 	':email' => $authme['email'],
		// 	':points' => $authme['points']
		// ));

		// if($query_insertAuthme)
		// {
		// 	echo "SUCCESS (Username: ".$authme['username'].")<br/>";
		// }
		// else
		// {
		// 	echo "FAILED (Username: ".$authme['username'].")<br/>";
		// }

		// $sql_updatePoints = "UPDATE authme SET points +:updatepoints WHERE username = :username";
		// $query_updatePoints = query($sql_updatePoints, array(
		// 	':updatepoints' => $authme['points'],
		// 	':username' => $authme['username']
		// ));
	}
?>