<?php
	use Maythiwat\WalletAPI;
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
				if($numrow_ip > $config['max_reg'])
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
		elseif($g == 'topup')
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

		    if($wallet_access_token == null || empty($wallet_access_token))
		    {
		    	echo '0';
		    }
		    elseif($_POST['transaction_wallet'] == '' || empty($_POST['transaction_wallet']) || $_POST['transaction_wallet'] == null)
		    {
		    	echo '1';
		    }
		    else
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
					$sql_updatePoints = 'UPDATE authme SET points = points+":updatepoints" WHERE id = ":uid_player" LIMIT 1';
					if(query($sql_updatePoints,array('updatepoints' => $ftam_u, ':uid_player' => $_SESSION['uid'])))
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
					echo '3';
				}
		    }
		}
	}
	else
	{
		echo '405';
	}
?>