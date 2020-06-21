<?php
	require_once("../_config.php");
	require_once("../_pdo.php");
	require_once("../_getDetailDevice.php");

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
						$status_id = '1';

						//* SET SESSION
						$_SESSION['backend_uid'] = $password_info['id'];
						$_SESSION['backend_username'] = slug($password_info['username']);
						$_SESSION['backend_realname'] = slug($password_info['realname']);
						$_SESSION['backend_rankname'] = $password_info['wm_rank_name'];

						echo '1';
					}
					else
					{
						$status_id = '3';
						echo '3';
					}
				}
				else
				{
					$status_id = '2';
					echo '2';
				}

				$sql_insertLoginLogs = "INSERT INTO backend_login_logs ".
				"(backend_login_logs_browser,backend_login_logs_os,user_id,login_logs_status_id) VALUES ".
				"(:browser,:os,:uid,:status_id)";
				query($sql_insertLoginLogs, array(
					':browser' => $user_browser,
					':os' => $user_os,
					':uid' => $password_info['id'],
					':status_id' => $status_id
				));
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
		elseif($g == 'getDetailDashboard')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$thisday = date('Y-m-d');

				$sql_countPlayer = "SELECT COUNT(id) AS count FROM authme";
				$query_countPlayer = query($sql_countPlayer);
				$countPlayer = $query_countPlayer->fetch();

				$sql_countPlayerLogin = "SELECT *, COUNT(login_logs_id) AS count FROM login_logs WHERE DATE(time_reg) = :thisday GROUP BY user_id";
				$query_countPlayerLogin = query($sql_countPlayerLogin, array(
					':thisday' => $thisday
				));
				$countPlayerLogin = $query_countPlayerLogin->rowcount();

				$sql_getTopup = "SELECT IFNULL(SUM(refill_logs_amount), 0) AS sum FROM refill_logs WHERE DATE(time_reg) = :thisday";
				$query_getTopup = query($sql_getTopup, array(
					':thisday' => $thisday
				));
				$getTopup = $query_getTopup->fetch();

				$sql_getAllShop = "SELECT COUNT(shop_id) AS count FROM shop";
				$query_getAllShop = query($sql_getAllShop);
				$getAllShop = $query_getAllShop->fetch();

				$sql_getShopLogsToday = "SELECT COUNT(shop_logs_id) AS count FROM shop_logs WHERE DATE(time_reg) = :thisday";
				$query_getShopLogsToday = query($sql_getShopLogsToday, array(
					':thisday' => $thisday
				));
				$getShopLogsToday = $query_getShopLogsToday->fetch();

				echo number_format($countPlayer['count'])."|".number_format($countPlayerLogin)."|".number_format($getTopup['sum'],2).
				"|".number_format($getAllShop['count'])."|".number_format($getShopLogsToday['count']);
			}
			else
			{
				echo '0';
			}
		}
		elseif($g == 'EditWalletSetting')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if(!empty($_POST['email']) && !empty($_POST['password']))
				{
					$sql_updateWalletAcc = "UPDATE wallet_account SET email = :email, password = :password WHERE id = 1";
					$query_updateWalletAcc = query($sql_updateWalletAcc, array(
						':email' => $_POST['email'],
						':password' => $_POST['password']
					));

					if($query_updateWalletAcc)
					{
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
			else
			{
				echo '500';
			}
		}
		elseif($g == 'getOTPAccessToken')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_wallet = 'SELECT email,password,access_token FROM wallet_account WHERE id = 1';
			    $query_wallet = query($sql_wallet);

			    if($query_wallet->rowcount() == 1)
			    {
			    	$f_wallet = $query_wallet->fetch();
			    	$wallet_email = $f_wallet['email'];
			    	$wallet_password = $f_wallet['password'];
			    	$wallet_access_token = $f_wallet['access_token'];
			    }

			    require_once(__DIR__ . '/../Wallet/_loginTW.php');
				$tw_getstatus = new TrueWallet($wallet_email, $wallet_password);
				$requestOTP = $tw_getstatus->RequestLoginOTP();

				if($requestOTP['code'] == "MAS-200")
				{
					$phone_number = $requestOTP['data']['mobile_number'];
					$otp_ref = $requestOTP['data']['otp_reference'];
					echo '1|'.$phone_number."|".$otp_ref;
				}
				else
				{
					echo '0';
				}
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'submitOTP')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_wallet = 'SELECT email,password FROM wallet_account WHERE id = 1';
			    $query_wallet = query($sql_wallet);

			    if($query_wallet->rowcount() == 1)
			    {
			    	$f_wallet = $query_wallet->fetch();
			    	$wallet_email = $f_wallet['email'];
			    	$wallet_password = $f_wallet['password'];
			    }

			    require_once(__DIR__ . '/../Wallet/_loginTW.php');
				$tw_getstatus = new TrueWallet($wallet_email, $wallet_password);
				$submitOTP = $tw_getstatus->SubmitLoginOTP($_POST['otp'],$_POST['phone'],$_POST['ref']);

				if($submitOTP['code'] == "MAS-200")
				{
					$sql_updateAccessToken = "UPDATE wallet_account SET access_token = :access_token WHERE id = 1";
					$query_updateAccessToken = query($sql_updateAccessToken, array(
						':access_token' => $submitOTP['data']['access_token']
					));

					if($query_updateAccessToken)
					{
						echo '1';
					}
					else
					{
						echo '0';
					}
				}
				else
				{
					echo '2';
				}
			}
			else
			{
				echo '500';
			}
		}
	}
	else
	{
		echo '405';
	}
?>