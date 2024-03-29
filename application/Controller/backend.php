<?php
	require_once("../_config.php");
	require_once("../_pdo.php");
	require_once("../_getDetailDevice.php");

	if(isset($_GET['func']))
	{
		$g = $_GET['func']; // SET $_GET var;

		if($g == 'login')
		{
			$username = $_POST['username'];
			$sql = "SELECT authme.*, wm_rank.wm_rank_name FROM\n".
			"(\n".
			"	SELECT * FROM authme WHERE username = :username\n".
			") AS authme\n".
			"LEFT JOIN\n".
			"(\n".
			"	SELECT * FROM wm_rank\n".
			") AS wm_rank ON (wm_rank.wm_rank_id = authme.wm_rank_id)";
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
					if($password_info['wm_rank_id'] == 2)
					{
						$status_id = '1';

						//* SET SESSION
						$_SESSION['backend_uid'] = $password_info['id'];
						$_SESSION['backend_username'] = $password_info['username'];
						$_SESSION['backend_realname'] = $password_info['realname'];
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
				if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['mutiple']))
				{
					$sql_updateWalletAcc = "UPDATE wallet_account SET email = :email, password = :password, ".
					"mutiple = :mutiple WHERE id = 1";
					$query_updateWalletAcc = query($sql_updateWalletAcc, array(
						':email' => $_POST['email'],
						':password' => $_POST['password'],
						':mutiple' => $_POST['mutiple']
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
					$sql_updateAccessToken = "UPDATE wallet_account SET phone = :phone, access_token = :access_token, name = :full_name WHERE id = 1";
					$query_updateAccessToken = query($sql_updateAccessToken, array(
						':phone' => $_POST['phone'],
						':access_token' => $submitOTP['data']['access_token'],
						':full_name' => $submitOTP['data']['full_name']
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
		elseif($g == 'addItemRandombox')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if(!is_numeric($_POST['percent']))
				{
					echo '0';
				}
				else
				{
					$ran_itemID = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,6);
				    $sql_add_itemRandombox = 'INSERT INTO randombox_item (randombox_item_name,randombox_item_img,'.
				    'randombox_item_command,randombox_item_code,randombox_id,server_id) VALUES ('.
				    ':name,:img,:command,:code,:randombox_id,:server_id)';

				    for($i = 0; $i < $_POST['percent']; $i++)
				    {
				      query($sql_add_itemRandombox, array(
				      	':name' => $_POST['name'],
				      	':img' => $_POST['img'],
				      	':command' => $_POST['command'],
				      	':code' => $ran_itemID,
				      	':randombox_id' => $_POST['randombox_id'],
				      	':server_id' => $_POST['server']
				      ));
				    }

				    echo '1';
				}
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'delRandomboxItem')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if(!isset($_POST['randomboxItemID']) || empty($_POST['randomboxItemID']) || $_POST['randomboxItemID'] == "")
				{
					exit('2');
				}

				$sql_del = "DELETE FROM randombox_item WHERE randombox_item_code = :randombox_item_code";
				$query_del = query($sql_del, array(
					':randombox_item_code' => $_POST['randomboxItemID']
				));

				if($query_del)
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
				echo '500';
			}
		}
		elseif($g == 'addShopItem')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if($_POST['item_name'] == "" || !isset($_POST['item_name']) || empty($_POST['item_name']) || 
				$_POST['item_img'] == "" || !isset($_POST['item_img']) || empty($_POST['item_img']) || 
				$_POST['item_command'] == "" || !isset($_POST['item_command']) || empty($_POST['item_command']) || 
				$_POST['item_price'] == "" || !isset($_POST['item_price']) || empty($_POST['item_price']) || 
				$_POST['item_recommend'] == "" || !isset($_POST['item_recommend']) ||
				$_POST['category_id'] == "" || !isset($_POST['category_id']) || empty($_POST['category_id']) || 
				$_POST['server_id'] == "" || !isset($_POST['server_id']) || empty($_POST['server_id']) || 
				!is_numeric($_POST['item_price']) || !is_numeric($_POST['category_id']) || !is_numeric($_POST['server_id']))
				{
					echo '0';
				}
				else
				{
					$sql_insertShopItem = "INSERT INTO shop (shop_name,shop_img,shop_command,shop_price,shop_recommended,".
					"category_id,server_id) VALUES (:shop_name,:shop_img,:shop_command,:shop_price,:shop_recommended,".
					":category_id,:server_id)";
					$query_insertShopItem = query($sql_insertShopItem, array(
						':shop_name' => $_POST['item_name'],
						':shop_img' => $_POST['item_img'],
						':shop_command' => $_POST['item_command'],
						':shop_price' => $_POST['item_price'],
						':shop_recommended' => $_POST['item_recommend'],
						':category_id' => $_POST['category_id'],
						':server_id' => $_POST['server_id']
					));

					if($query_insertShopItem)
					{
						echo '1';
					}
					else
					{
						echo '2';
					}
				}
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'delShopItem')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if(!isset($_POST['shopId']) || empty($_POST['shopId']) || $_POST['shopId'] == "")
				{
					echo '0';
				}
				else
				{
					$sql_delShopItem = "DELETE FROM shop WHERE shop_id = :shopId";
					$query_delShopItem = query($sql_delShopItem, array(
						':shopId' => $_POST['shopId']
					));

					if($query_delShopItem)
					{
						echo '1';
					}
					else
					{
						echo '2';
					}
				}
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'getDetailShopItem')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if(!isset($_POST['shopId']) || empty($_POST['shopId']) || $_POST['shopId'] == "")
				{
					echo '0';
				}
				else
				{
					$sql_getDetail = "SELECT * FROM shop WHERE shop_id = :shopId";
					$query_getDetail = query($sql_getDetail, array(
						':shopId' => $_POST['shopId']
					));

					if($query_getDetail->rowcount() <= 0)
					{
						echo '1';
					}
					else
					{
						$detail = $query_getDetail->fetch();

						echo $detail['shop_name']."|".$detail['shop_img']."|".$detail['shop_command']."|".$detail['shop_price']."|".$detail['shop_id'];
					}
				}
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'addRandombox')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if(!isset($_POST['name']) || empty($_POST['name']) || $_POST['name'] == "")
				{
					exit('0');
				}

				if(!isset($_POST['price']) || empty($_POST['price']) || $_POST['price'] == "")
				{
					exit('0');
				}

				if(!isset($_POST['img']) || empty($_POST['img']) || $_POST['img'] == "")
				{
					exit('0');
				}

				$sql_addRandombox = "INSERT INTO randombox (randombox_name,randombox_img,randombox_price) VALUES (".
				":name,:img,:price)";
				$query_addRandombox = query($sql_addRandombox, array(
					':name' => $_POST['name'],
					':img' => $_POST['img'],
					':price' => $_POST['price']
				));

				if($query_addRandombox)
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
				echo '500';
			}
		}
		elseif($g == 'delItemRandombox')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if(!isset($_POST['id']) || empty($_POST['id']) || $_POST['id'] == "")
				{
					exit('0');
				}

				$sql_delRandombox = "DELETE FROM randombox WHERE randombox_id = :id";
				$query_delRandombox = query($sql_delRandombox, array(
					':id' => $_POST['id']
				));

				if($query_delRandombox)
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
				echo '500';
			}
		}
		elseif($g == 'addServer')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_addServer = "INSERT INTO server (server_name,server_ip,server_port,server_password) VALUES (".
				":name,:ip,:port,:password)";
				$query_addServer = query($sql_addServer, array(
					':name' => $_POST['name'],
					':ip' => $_POST['ip'],
					':port' => $_POST['port'],
					':password' => $_POST['password']
				));

				if($query_addServer)
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
				echo '500';
			}
		}
		elseif($g == 'delServer')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_delServer = "DELETE FROM server WHERE server_id = :server_id";
				$query_delServer = query($sql_delServer, array(
					':server_id' => $_POST['id']
				));

				if($query_delServer)
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
				echo '500';
			}
		}
		elseif($g == 'addCategory')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_addCategory = "INSERT INTO category (category_name) VALUES (:category_name)";
				$query_addCategory = query($sql_addCategory, array(
					':category_name' => $_POST['category_name']
				));

				if($query_addCategory)
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
				echo '500';
			}
		}
		elseif($g == 'delCategory')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_delCategory = "DELETE FROM category WHERE category_id = :category_id";
				$query_delCategory = query($sql_delCategory, array(
					':category_id' => $_POST['id']
				));

				if($query_delCategory)
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
				echo '500';
			}
		}
		elseif($g == 'addDiary')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_addDiary = "INSERT INTO diary (diary_name,diary_command,diary_img,diary_date,server_id) ".
				"VALUES (:diary_name,:diary_command,:diary_img,:diary_date,:server_id)";
				$query_addDiary = query($sql_addDiary, array(
					':diary_name' => $_POST['diary_name'],
					':diary_command' => $_POST['diary_command'],
					':diary_img' => $_POST['diary_img'],
					':diary_date' => date_format(date_create(str_replace('/', '-', $_POST['diary_date'])), 'Y-m-d'),
					':server_id' => $_POST['diary_server']
				));

				if($query_addDiary)
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
				echo '500';
			}
		}
		elseif($g == 'addCode')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if($_POST['code_type'] == 3 && is_numeric($_POST['code_type']) && is_numeric($_POST['code_limit']))
				{
					$code_limit = $_POST['code_limit'];
				}
				else
				{
					$code_limit = 1;
				}

				$sql_checkCode = "SELECT * FROM code WHERE code_value = :code_value";
				$query_checkCode = query($sql_checkCode, array(
					':code_value' => $_POST['code_value']
				));

				if($query_checkCode->rowcount() <= 0)
				{
					$sql_addCode = "INSERT INTO code (code_value,code_command,code_type,code_redeem_amount,server_id)".
					"VALUES (:code_value,:code_command,:code_type,:code_limit,:server_id)";
					$query_addCode = query($sql_addCode, array(
						':code_value' => $_POST['code_value'],
						':code_command' => $_POST['code_command'],
						':code_type' => $_POST['code_type'],
						':code_limit' => $code_limit,
						':server_id' => $_POST['server_id']
					));

					if($query_addCode)
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
		elseif($g == 'delCode')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_delCode = "DELETE FROM code WHERE code_id = :code_id";
				$query_delCode = query($sql_delCode, array(
					':code_id' => $_POST['id']
				));

				if($query_delCode)
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
				echo '500';
			}
		}
		elseif($g == 'editShopItem')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if($_POST['item_id'] == "" || !isset($_POST['item_id']) || empty($_POST['item_id']) ||
				$_POST['item_name'] == "" || !isset($_POST['item_name']) || empty($_POST['item_name']) || 
				$_POST['item_img'] == "" || !isset($_POST['item_img']) || empty($_POST['item_img']) || 
				$_POST['item_command'] == "" || !isset($_POST['item_command']) || empty($_POST['item_command']) || 
				$_POST['item_price'] == "" || !isset($_POST['item_price']) || empty($_POST['item_price']) || 
				$_POST['item_recommend'] == "" || !isset($_POST['item_recommend']) ||
				$_POST['category_id'] == "" || !isset($_POST['category_id']) || empty($_POST['category_id']) || 
				$_POST['server_id'] == "" || !isset($_POST['server_id']) || empty($_POST['server_id']) || 
				!is_numeric($_POST['item_price']) || !is_numeric($_POST['category_id']) || !is_numeric($_POST['server_id']))
				{
					echo '0';
				}
				else
				{
					$sql_updateShopItem = "UPDATE shop SET shop_name = :shop_name, shop_img = :shop_img, ".
					"shop_command = :shop_command, shop_price = :shop_price, shop_recommended = :shop_recommended, ".
					"category_id = :category_id, server_id = :server_id WHERE shop_id = :shop_id";
					$query_updateShopItem = query($sql_updateShopItem, array(
						':shop_name' => $_POST['item_name'],
						':shop_img' => $_POST['item_img'],
						':shop_command' => $_POST['item_command'],
						':shop_price' => $_POST['item_price'],
						':shop_recommended' => $_POST['item_recommend'],
						':category_id' => $_POST['category_id'],
						':server_id' => $_POST['server_id'],
						':shop_id' => $_POST['item_id']
					));

					if($query_updateShopItem)
					{
						echo '1';
					}
					else
					{
						echo '2';
					}
				}
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'updateSettings')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_updateSettings = "UPDATE settings SET settings_shop_name = :shop_name, settings_boardcast = :boardcast, ".
				"settings_max_reg = :max_reg, settings_line_token = :line_token WHERE settings_id = 1";
				$query_updateSettings = query($sql_updateSettings, array(
					':shop_name' => $_POST['shop_name'],
					':boardcast' => $_POST['boardcast'],
					':max_reg' => $_POST['max_reg'],
					':line_token' => $_POST['line_token']
				));

				if($query_updateSettings)
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
				echo '500';
			}
		}
		elseif($g == 'editTruemoney')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if(empty($_POST['id']) || !isset($_POST['id']) || $_POST['id'] == "")
				{
					exit('4');
				}

				if(empty($_POST['points']) || !is_numeric($_POST['points']))
				{
					exit('0');
				}

				if(empty($_POST['rp']) || !is_numeric($_POST['rp']))
				{
					exit('1');
				}

				$points = str_replace(',', '', number_format($_POST['points'], 2));
				$rp = str_replace(',', '', number_format($_POST['rp'], 2));

				$sql_updateTruemoney = "UPDATE truemoney SET points = :points, rp = :rp WHERE id = :id";
				$query_updateTruemoney = query($sql_updateTruemoney, array(
					':points' => $_POST['points'],
					':rp' => $_POST['rp'],
					':id' => $_POST['id']
				));

				if($query_updateTruemoney)
				{
					echo '2';
				}
				else
				{
					echo '3';
				}
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'delWalletRP')
		{
			if(isset($_SESSION['backend_uid']))
			{
				$sql_delWalletRP = "DELETE FROM wallet_rp WHERE wallet_rp_id = :wallet_rp_id";
				$query_delWalletRP = query($sql_delWalletRP, array(
					':wallet_rp_id' => $_POST['id']
				));

				if($query_delWalletRP)
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
				echo '500';
			}
		}
		elseif($g == 'addWalletRP')
		{
			if(isset($_SESSION['backend_uid']))
			{
				if(empty($_POST['points']) || $_POST['points'] == "" || 
				empty($_POST['rp']) || $_POST['rp'] == "" || 
				!is_numeric($_POST['points']) || !is_numeric($_POST['rp']))
				{
					exit('0');
				}

				$sql_checkWalletRP = "SELECT * FROM wallet_rp WHERE wallet_rp_topup = :wallet_rp_topup LIMIT 1";
				$query_checkWalletRP = query($sql_checkWalletRP, array(
					':wallet_rp_topup' => str_replace(',', '', number_format($_POST['points'], 2))
				));

				if($query_checkWalletRP->rowcount() > 0)
				{
					exit('3');
				}

				$sql_addWalletRP = "INSERT INTO wallet_rp (wallet_rp_topup,wallet_rp_reward) VALUES ".
				"(:wallet_rp_topup,:wallet_rp_reward)";
				$query_addWalletRP = query($sql_addWalletRP, array(
					':wallet_rp_topup' => $_POST['points'],
					':wallet_rp_reward' => $_POST['rp']
				));

				if($query_addWalletRP)
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
				echo '500';
			}
		}
	}
	else
	{
		echo '405';
	}
?>