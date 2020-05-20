<?php
	require_once("../_config.php");

	if(isset($_GET['func']))
	{
		$g = $_GET['func']; // SET $_GET var;

		if($g == 'login')
		{
			$username = $_POST['username'];
			$sql = "SELECT * FROM authme WHERE username = :username";
			$a = query($sql,array(':username' => $username));
			$a_num = $a->rowcount();
			if($a_num == 1)
			{
				$password_info = $a->fetch();
				$sha_info = explode("$",$password_info['password']);
				$salt = $sha_info[2];
				$sha256_password = hash('sha256', $_POST['password']);
				$sha256_password .= $sha_info[2];

				if(strcasecmp(trim($sha_info[3]),hash('sha256', $sha256_password)) == 0)
				{
					//* SET SESSION
					$_SESSION['uid'] = $password_info['id'];
					$_SESSION['username'] = $password_info['username'];
					$_SESSION['realname'] = $password_info['realname'];

					echo '1';
				}
				else
				{
					echo '2';
				}
			}
			else
			{
				echo '0';
			}
		}
	}
	else
	{
		echo '405';
	}
?>