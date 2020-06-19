<?php
	use Maythiwat\WalletAPI;
	require_once("../_config.php");

	if(isset($_GET['func']))
	{
		$g = $_GET['func']; // SET $_GET var;

		if($g == 'login')
		{
			function slug($str)
			{
				//$str = strtolower(trim($str));
				$str = preg_replace('/[^A-Za-z0-9-]/', '-', $str);
				$str = preg_replace('/-+/', " ", $str);
				return $str;
			}

			$username = $_POST['username'];
			$sql = "SELECT authme.*, wm_rank.wm_rank_name FROM\n".
			"(\n".
			"	SELECT * FROM authme WHERE username = :username\n".
			") AS authme\n".
			"LEFT JOIN\n".
			"(\n".
			"	SELECT * FROM wm_rank\n".
			") AS wm_rank ON (wm_rank.wm_rank_id = authme.wm_rank_id)";
			$a = query($sql,array(':username' => slug($username)));
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
					if($password_info['wm_rank_id'] == 2)
					{
						//* SET SESSION
						$_SESSION['backend_uid'] = $password_info['id'];
						$_SESSION['backend_username'] = slug($password_info['username']);
						$_SESSION['backend_realname'] = slug($password_info['realname']);
						$_SESSION['backend_rankname'] = $password_info['wm_rank_name'];

						echo '1';
					}
					else
					{
						echo '3';
					}
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
		elseif($g == 'logout')
		{
			unset($_SESSION['backend_uid']);
			unset($_SESSION['backend_username']);
			unset($_SESSION['backend_realname']);
			unset($_SESSION['backend_rankname']);

			echo '1';
		}
	}
	else
	{
		echo '405';
	}
?>