<?php
	use Maythiwat\WalletAPI;
	require_once("../_config.php");
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
			$sql = "SELECT * FROM authme WHERE username = :username";
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
					$status_id = '1';

					//* SET SESSION
					$_SESSION['uid'] = $password_info['id'];
					$_SESSION['username'] = slug($password_info['username']);
					$_SESSION['realname'] = slug($password_info['realname']);

					echo '1';
				}
				else
				{
					$status_id = '2';
					echo '2';
				}

				$sql_insertLoginLogs = "INSERT INTO login_logs (login_logs_browser,login_logs_os,user_id,login_logs_status_id) VALUES ".
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
		elseif($g == 'register')
		{
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

				function slug($str)
				{
					//$str = strtolower(trim($str));
					$str = preg_replace('/[^A-Za-z0-9-]/', '-', $str);
					$str = preg_replace('/-+/', " ", $str);
					return $str;
				}

				$check_ip = query("SELECT * FROM authme WHERE ip = :ip",array(':ip' => $_SERVER['REMOTE_ADDR']));
				$numrow_ip = $check_ip->rowcount();
				if($numrow_ip > $config['max_reg'])
				{
					echo '4';
				}
				else
				{
					$check = query("SELECT * FROM authme WHERE username = :username",array(':username' => slug($_POST['username'])));
					$numrow = $check->rowcount();
					if($numrow > 0)
					{
						echo '5';
					}
					else
					{
						$insert = query("INSERT INTO authme (username,realname,password,ip,email) VALUES(:username,:realname,:password,:ip,:email)",array(':username'=>strtolower(slug($_POST['username'])),':realname'=>slug($_POST['username']),':password'=>hashpw($_POST['password']),':ip'=>$_SERVER['REMOTE_ADDR'],':email'=>$_POST['email']));
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
			unset($_SESSION['uid']);
			unset($_SESSION['username']);
			unset($_SESSION['realname']);

			echo '1';
		}
		elseif($g == 'topup')
		{
    		if(!isset($_SESSION['uid']))
    		{
    			echo '6';
    		}
    		elseif(!is_numeric($_POST['transaction_wallet']))
    		{
    			echo '7';
    		}
    		else
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

			    if($wallet_access_token == null || empty($wallet_access_token) || $wallet_access_token == "")
			    {
			    	echo '0';
			    }
			    elseif($_POST['transaction_wallet'] == '' || empty($_POST['transaction_wallet']) || $_POST['transaction_wallet'] == null)
			    {
			    	echo '1';
			    }
			    else
			    {
			    	$sql_countTransaction = 'SELECT refill_logs_id FROM refill_logs WHERE refill_logs_transaction = :refill_transaction';
			    	$query_countTransaction = query($sql_countTransaction,array(':refill_transaction' => $_POST['transaction_wallet']));

			    	if($query_countTransaction->rowcount() > 0)
			    	{
			    		echo '9';
			    	}
			    	else
			    	{
			    		require_once(__DIR__ . '/../Wallet/_loginTW.php');
						$tw_getstatus = new TrueWallet($wallet_email, $wallet_password);
						$tw_getstatus->setAccessToken($wallet_access_token);
						$data_getstatus = $tw_getstatus->GetProfile();

						if($data_getstatus["code"] == 'UPC-200')
						{
							require_once(__DIR__ . '/../Wallet/_truewallet.php');
			    			$tw = new WalletAPI();

							/* Time Settings */
							$now_datetime = date('d/m/Y H:i');
							$today_day =  date("d");
							$today_month = date("m");
							$today_year =  date("Y");
							$today_year_s = $today_year - 1;
							$today_use_check_s = $today_year_s."-".$today_month."-".$today_day;
							$today_year_e = $today_year + 1;
							$today_use_check_e = $today_year_e."-".$today_month."-".$today_day;
							/* END Time Settings */

			    			$token = $wallet_access_token;


			    			/* START GET TRANSACTION */
			    			$activities = $tw->FetchActivities($token, $today_use_check_s, $today_use_check_e);
							foreach($activities as $arr)
			                {
			                    if($arr['original_action'] == 'creditor')
			                    {
			                        $data = $tw->FetchTxDetail($token, $arr['report_id']);
			                        $flr = $data['data'];
			                        $fti = $flr['section4']['column2']['cell1']['value'];
			                        $ftam = $flr['amount'];
			                        $ftm = $flr['personal_message']['value'];
			                        $ftphone = $flr['ref1'];
			                        $fttime = $flr['section4']['column1']['cell1']['value'];

			                        if($fti == $_POST['transaction_wallet'])
									{
										$fti_u = $fti; // หมายเลขอ้างอิง
										$ftam_u = $ftam; // จำนวนเงิน
										$ftm_u = $ftm; // ข้อความ
										$ftphone_u = $ftphone; // เบอร์ที่โอนมา
										$fttime_u = $fttime; // วันที่และเวลาที่ทำรายการ
										break;
									}
			                    }
			                }
							/* END GET TRANSACTION */

							if(isset($fti_u) && $fti_u == $_POST['transaction_wallet'])
							{
								$sql_insertLogs = 'INSERT INTO refill_logs (refill_logs_transaction,refill_logs_amount,refill_type_id,user_id) VALUES (:refill_transaction,:refill_amount,:refill_type_id,:uid)';
								$query_insertLogs = query($sql_insertLogs,array(':refill_transaction' => $fti_u,':refill_amount' => $ftam_u, ':refill_type_id' => 1, ':uid' => $_SESSION['uid']));
								if($query_insertLogs)
								{
									$sql_updatePoints = 'UPDATE authme SET points = points+:updatepoints WHERE id = :uid LIMIT 1';
									$query_updatePoints = query($sql_updatePoints,array(':updatepoints' => $ftam_u, ':uid' => $_SESSION['uid']));
									if($query_updatePoints)
									{
										echo '2|'.number_format($ftam_u, 2).'|'.$ftphone_u;
									}
									else
									{
										echo '4';
									}
								}
								else
								{
									echo '8';
								}
							}
							else
							{
								echo '3';
							}
						}
						else
						{
							echo '5|'.$data_getstatus["code"];
						}
			    	}
			    }
    		}
		}
	}
	else
	{
		echo '405';
	}
?>