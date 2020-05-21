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
		elseif($g == 'register')
		{
			// echo $_POST['password']." ".$_POST['confirmpassword']." ".$_POST['email'];
			if(strlen($_POST['username']) < 4)
			{
				echo '0';
			}
			elseif(strlen($_POST['password']) < 4)
			{
				echo '1';
			}
			elseif($_POST['password'] != $_POST['confirmpassword'])
			{
				echo '2';
			}
			elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{
				echo '3';
			}
			else
			{
				function createSalt($length)
				{
					srand(date("s")); 
					$chars = "abcdefghigklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; 
					$ret_str = ""; 
					$num = strlen($chars); 
					for($i=0;$i<$length;$i++)
					{ 
						$ret_str.= $chars[rand()%$num];
					} 
					return $ret_str;
				}

				function hashpw($orgPassword)
				{
					$salt = createSalt(16);
					$hashedPassword = "\$SHA\$".$salt."\$".hash('sha256',hash('sha256',$orgPassword).$salt);
					return $hashedPassword;
				}

				$check_ip = query("SELECT * FROM authme WHERE ip = :ip",array(':ip' => $_SERVER['REMOTE_ADDR']));
				$numrow_ip = $check_ip->rowcount();
				if($numrow_ip > $settings['max_reg'])
				{
					echo '4';
				}
				else
				{
					$check = query("SELECT * FROM authme WHERE username = :username",array(':username' => $_POST['username']));
					$numrow = $check->rowcount();
					if($numrow > 0)
					{
						echo '5';
					}
					else
					{
						$insert = query("INSERT INTO authme (username,realname,password,ip,email) VALUES(:username,:realname,:password,:ip,:email)",array(':username'=>strtolower($_POST['username']),':realname'=>$_POST['username'],':password'=>hashpw($_POST['password']),':ip'=>$_SERVER['REMOTE_ADDR'],':email'=>$_POST['email']));
						if($insert)
						{
							echo '7';
						}
						else
						{
							echo '6';
						}
					}
				}
			}
		}
		elseif($g == 'logout')
		{
			session_destroy();

			echo '1';
		}
	}
	else
	{
		echo '405';
	}
?>