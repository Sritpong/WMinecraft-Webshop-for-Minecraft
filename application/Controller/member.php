<?php
	require_once("../_config.php");
	require_once("../_pdo.php");
	require_once("../_getPlayer.php");
	require_once("../_getSettings.php");
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
				if($numrow_ip > $settings['settings_max_reg'])
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
		elseif($g == 'getDetailShop')
		{
			if(isset($_POST['item_id']))
			{
				$sql_getDetailShop = "SELECT\n".
				"	shop.shop_id,\n".
				"	shop.shop_name,\n".
				"	shop.shop_img,\n".
				"	shop.shop_price,\n".
				"	category.category_name,\n".
				"	server.server_name\n".
				"FROM\n".
				"(\n".
				"	SELECT * FROM `shop` WHERE shop_id = :shop_id\n".
				") AS shop\n".
				"LEFT JOIN\n".
				"(\n".
				"	SELECT * FROM `category`\n".
				") AS category ON (category.category_id = shop.category_id)\n".
				"LEFT JOIN\n".
				"(\n".
				"	SELECT * FROM `server`\n".
				") AS server ON (server.server_id = shop.server_id)";
				$query_getDetailShop = query($sql_getDetailShop, array(
					':shop_id' => $_POST['item_id']
				));
				
				if($query_getDetailShop->rowcount() > 0)
				{
					$getDetailShop = $query_getDetailShop->fetch();

					echo $getDetailShop['shop_id']."|".$getDetailShop['shop_name']."|".
					number_format($getDetailShop['shop_price'],2)."|".$getDetailShop['category_name'].
					"|".$getDetailShop['server_name'];
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
		elseif($g == 'buyItemShop')
		{
			if(!isset($_SESSION['uid']))
			{
				echo '500';
			}
			else
			{
				if(isset($_POST['item_id']))
				{
					$sql_getDetailShop = "SELECT\n".
					"	shop.shop_id,\n".
					"	shop.shop_name,\n".
					"	shop.shop_price,\n".
					"	shop.shop_command,\n".
					"	server.server_name,\n".
					"	server.server_ip,\n".
					"	server.server_port,\n".
					"	server.server_password\n".
					"FROM\n".
					"(\n".
					"	SELECT * FROM `shop` WHERE shop_id = :shop_id\n".
					") AS shop\n".
					"LEFT JOIN\n".
					"(\n".
					"	SELECT * FROM `category`\n".
					") AS category ON (category.category_id = shop.category_id)\n".
					"LEFT JOIN\n".
					"(\n".
					"	SELECT * FROM `server`\n".
					") AS server ON (server.server_id = shop.server_id)";
					$query_getDetailShop = query($sql_getDetailShop, array(
						':shop_id' => $_POST['item_id']
					));

					if($query_getDetailShop->rowcount() > 0)
					{
						$shop = $query_getDetailShop->fetch();

						if($player['points'] >= $shop['shop_price'])
						{
							$rcon_ip = $shop['server_ip'];
							$rcon_port = $shop['server_port'];
							$rcon_password = $shop['server_password'];

							require_once('../_rcon.php');
							$rcon = new Rcon($rcon_ip, $rcon_port, $rcon_password, '3');
							if($rcon->connect())
							{
								$sql_updatePointsPlayer = "UPDATE authme SET points = points-'".$shop['shop_price']."' WHERE id = :uid";
								$query_updatePointsPlayer = query($sql_updatePointsPlayer, array(
									':uid' => $_SESSION['uid']
								));

								if($query_updatePointsPlayer)
								{
									$sql_insertShopLogs = "INSERT INTO shop_logs (shop_id,user_id) VALUES (".
									":shop_id,:uid".
									")";
									$query_insertShopLogs = query($sql_insertShopLogs, array(
										':shop_id' => $shop['shop_id'],
										':uid' => $_SESSION['uid']
									));

									if($query_insertShopLogs)
									{
										$command = str_replace("<player>", $player['username'], $shop['shop_command']);
								        $exp = explode('<and>',$command);

								        foreach($exp as &$val)
		                                {
		                                    $rcon->sendCommand($val);
		                                }

		                                echo '1';
									}
									else
									{
										echo '5';
									}
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
						else
						{
							echo '6';
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
		}
		elseif($g == 'buyItemShopInventory')
		{
			if(!isset($_SESSION['uid']))
			{
				echo '500';
			}
			else
			{
				if(isset($_POST['item_id']))
				{
					$sql_getDetailShop = "SELECT\n".
					"	shop.shop_id,\n".
					"	shop.shop_name,\n".
					"	shop.shop_img,\n".
					"	shop.shop_price,\n".
					"	shop.shop_command,\n".
					"	shop.server_id\n".
					"FROM\n".
					"(\n".
					"	SELECT * FROM `shop` WHERE shop_id = :shop_id\n".
					") AS shop";
					$query_getDetailShop = query($sql_getDetailShop, array(
						':shop_id' => $_POST['item_id']
					));

					if($query_getDetailShop->rowcount() > 0)
					{
						$shop = $query_getDetailShop->fetch();

						if($player['points'] >= $shop['shop_price'])
						{
							$sql_updatePointsPlayer = "UPDATE authme SET points = points-'".$shop['shop_price']."' WHERE id = :uid";
							$query_updatePointsPlayer = query($sql_updatePointsPlayer, array(
								':uid' => $_SESSION['uid']
							));

							if($query_updatePointsPlayer)
							{
								$sql_insertShopLogs = "INSERT INTO shop_logs (shop_id,user_id) VALUES (".
								":shop_id,:uid".
								")";
								$query_insertShopLogs = query($sql_insertShopLogs, array(
									':shop_id' => $shop['shop_id'],
									':uid' => $_SESSION['uid']
								));

								if($query_insertShopLogs)
								{
									$sql_insertItemToInventory = "INSERT INTO backpack (backpack_name,backpack_command,backpack_img,".
				            		"user_id,server_id) VALUES (:backpack_name,:backpack_command,:backpack_img,:uid,:server_id)";
				            		$query_insertItemToInventory = query($sql_insertItemToInventory, array(
				            			':backpack_name' => $shop['shop_name'],
				            			':backpack_command' => $shop['shop_command'],
				            			':backpack_img' => $shop['shop_img'],
				            			':uid' => $_SESSION['uid'],
				            			':server_id' => $shop['server_id']
				            		));
									if($query_insertItemToInventory)
									{
										echo '1';
									}
									else
									{
										echo '4';
									}
								}
								else
								{
									echo '6';
								}
							}
							else
							{
								echo '5';
							}
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
		}
		elseif($g == 'redeemcode')
		{
			if(isset($_SESSION['uid']))
			{
				$sql_check_c = "SELECT\n".
				"	code.*,\n".
				"	server.server_ip,\n".
				"	server.server_port,\n".
				"	server.server_password,\n".
				"	COUNT(code_logs.code_logs_id) AS count,\n".
				"	COUNT(count_redeem.code_logs_id) AS count_redeem\n".
				"FROM\n".
				"(\n".
				"	SELECT * FROM code WHERE BINARY code_value = :code\n".
				") AS code\n".
				"LEFT JOIN\n".
				"(\n".
				"	SELECT * FROM server\n".
				") AS server ON (server.server_id = code.server_id)\n".
				"LEFT JOIN\n".
				"(\n".
				"	SELECT * FROM code_logs\n".
				") AS code_logs ON (code_logs.code_id = code.code_id)\n".
				"LEFT JOIN\n".
				"(\n".
				"	SELECT * FROM code_logs WHERE user_id = :uid\n".
				") AS count_redeem ON (code_logs.code_id = code.code_id)\n".
				"LIMIT 1";
				$check_c_q = query($sql_check_c, array(
					':code' => $_POST['code'],
					':uid' => $_SESSION['uid']
				));

				if($check_c_q->rowcount() != 1)
				{
					echo '0';
				}
				else
				{
					$code = $check_c_q->fetch();

					if($code['code_type'] == 1)
					{
						if($code['count'] == 0)
						{
							$sql_insertLogsCode = "INSERT INTO code_logs (code_id,user_id) VALUES ".
							"(:code_id,:uid)";
							$query_insertLogsCode = query($sql_insertLogsCode, array(
								':code_id' => $code['code_id'],
								':uid' => $_SESSION['uid']
							));

							if($query_insertLogsCode)
							{
								$rcon_ip = $code['server_ip'];
								$rcon_port = $code['server_port'];
								$rcon_password = $code['server_password'];

								require_once('../_rcon.php');
								$rcon = new Rcon($rcon_ip, $rcon_port, $rcon_password, '3');
								if($rcon->connect())
								{
									$command = str_replace("<player>", $player['username'], $code['code_command']);
							        $exp = explode('<and>',$command);

							        foreach($exp as &$val)
	                                {
	                                    $rcon->sendCommand($val);
	                                }

	                                echo '1';
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
						else
						{
							echo '2';
						}
					}
					elseif($code['code_type'] == 2)
					{
						if($code['count_redeem'] == 0)
						{
							$sql_insertLogsCode = "INSERT INTO code_logs (code_id,user_id) VALUES ".
							"(:code_id,:uid)";
							$query_insertLogsCode = query($sql_insertLogsCode, array(
								':code_id' => $code['code_id'],
								':uid' => $_SESSION['uid']
							));

							if($query_insertLogsCode)
							{
								$rcon_ip = $code['server_ip'];
								$rcon_port = $code['server_port'];
								$rcon_password = $code['server_password'];

								require_once('../_rcon.php');
								$rcon = new Rcon($rcon_ip, $rcon_port, $rcon_password, '3');
								if($rcon->connect())
								{
									$command = str_replace("<player>", $player['username'], $code['code_command']);
							        $exp = explode('<and>',$command);

							        foreach($exp as &$val)
	                                {
	                                    $rcon->sendCommand($val);
	                                }

	                                echo '1';
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
						else
						{
							echo '2';
						}
					}
					elseif($code['code_type'] == 3)
					{
						if($code['count'] < $code['code_redeem_amount'] && $code['count_redeem'] == 0)
						{
							$sql_insertLogsCode = "INSERT INTO code_logs (code_id,user_id) VALUES ".
							"(:code_id,:uid)";
							$query_insertLogsCode = query($sql_insertLogsCode, array(
								':code_id' => $code['code_id'],
								':uid' => $_SESSION['uid']
							));

							if($query_insertLogsCode)
							{
								$rcon_ip = $code['server_ip'];
								$rcon_port = $code['server_port'];
								$rcon_password = $code['server_password'];

								require_once('../_rcon.php');
								$rcon = new Rcon($rcon_ip, $rcon_port, $rcon_password, '3');
								if($rcon->connect())
								{
									$command = str_replace("<player>", $player['username'], $code['code_command']);
							        $exp = explode('<and>',$command);

							        foreach($exp as &$val)
	                                {
	                                    $rcon->sendCommand($val);
	                                }

	                                echo '1';
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
						else
						{
							echo '2';
						}
					}
					else
					{
						echo '5';
					}
				}
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'receiveDiary')
		{
			if(isset($_SESSION['uid']))
			{
				$sql_diary = "SELECT\n".
				"	diary.*,\n".
				"	server.server_name,\n".
				"	server.server_ip,\n".
				"	server.server_port,\n".
				"	server.server_password,\n".
				"	COUNT(diary.diary_id) AS count,\n".
				"	COUNT(diary_logs.diary_logs_id) AS count_logs\n".
				"FROM\n".
				"(\n".
				"	SELECT * FROM diary WHERE diary_date = :today\n".
				"	ORDER BY diary_id DESC LIMIT 1\n".
				") AS diary\n".
				"LEFT JOIN\n".
				"(\n".
				"	SELECT * FROM server\n".
				") AS server ON (server.server_id = diary.server_id)\n".
				"LEFT JOIN\n".
				"(\n".
				"	SELECT * FROM diary_logs WHERE user_id = :uid\n".
				") AS diary_logs ON (diary_logs.diary_id = diary.diary_id)";
				$query_diary = query($sql_diary, array(
					':today' => date("Y-m-d"),
					':uid' => $_SESSION['uid']
	            ));
	            $diary = $query_diary->fetch();

	            if($diary['count'] <= 0)
	            {
	            	echo "0";
	            }
	            elseif($diary['count_logs'] > 0)
	            {
	            	echo "2";
	            }
	            else
	            {
	            	$sql_insertLogsDiary = "INSERT INTO diary_logs (diary_id,user_id) VALUES (:diary_id,:uid)";
	            	$query_insertLogsDiary = query($sql_insertLogsDiary, array(
	            		':diary_id' => $diary['diary_id'],
	            		':uid' => $_SESSION['uid']
	            	));

	            	if($query_insertLogsDiary)
	            	{
	            		$sql_insertBackpack = "INSERT INTO backpack (backpack_name,backpack_command,backpack_img,".
	            		"user_id,server_id) VALUES (:backpack_name,:backpack_command,:backpack_img,:uid,:server_id)";
	            		$query_insertBackpack = query($sql_insertBackpack, array(
	            			':backpack_name' => $diary['diary_name'],
	            			':backpack_command' => $diary['diary_command'],
	            			':backpack_img' => $diary['diary_img'],
	            			':uid' => $_SESSION['uid'],
	            			':server_id' => $diary['server_id']
	            		));

	            		if($query_insertBackpack)
	            		{
	            			echo '1';
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
			else
			{
				echo '500';
			}
		}
		elseif($g == 'receiveBackpack')
		{
			if(isset($_SESSION['uid']))
			{
				$backpack_id = $_POST['backpack_id'];		
                $sql_backpack = "SELECT\n".
                " backpack.*,\n".
                " server.*\n".
                "FROM\n".
                "(\n".
                " SELECT * FROM backpack WHERE user_id = :uid AND backpack_id = :backpack_id\n".
                ") AS backpack\n".
                "LEFT JOIN\n".
                "(\n".
                " SELECT * FROM server\n".
                ") AS server ON (server.server_id = backpack.server_id)";
                $query_backpack = query($sql_backpack, array(
                  ':uid' => $_SESSION['uid'],
                  ':backpack_id' => $backpack_id
                ));

    			if($query_backpack->rowcount() <= 0)
    			{
    				echo '0';
    			}
    			else
    			{
    				$backpack = $query_backpack->fetch();
    				
    				if($backpack['backpack_status'] == 1)
    				{
    					echo '2';
    				}
    				else
    				{
    					$rcon_ip = $backpack['server_ip'];
						$rcon_port = $backpack['server_port'];
						$rcon_password = $backpack['server_password'];

						require_once('../_rcon.php');
						$rcon = new Rcon($rcon_ip, $rcon_port, $rcon_password, '3');
						if($rcon->connect())
						{
							$sql_updateStatusBackpack = "UPDATE backpack SET backpack_status = 1 WHERE backpack_id = :backpack_id";
	    					$query_updateStatusBackpack = query($sql_updateStatusBackpack, array(
	    						':backpack_id' => $backpack_id
	    					));

	    					if($query_updateStatusBackpack)
	    					{
	    						$command = str_replace("<player>", $player['username'], $backpack['backpack_command']);
						        $exp = explode('<and>',$command);

						        foreach($exp as &$val)
	                            {
	                                $rcon->sendCommand($val);
	                            }

	                            echo '1';
	    					}
	    					else
	    					{
	    						echo '3';
	    					}
						}
						else
						{
							echo '4';
						}
    				}
    			}
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'getDetailRandomBox')
		{
			if(isset($_SESSION['uid']))
			{
				$sql_getRandomboxSelect = "SELECT\n".
			    " randombox.*,\n".
			    " COUNT(randombox.randombox_id) AS count_randombox,\n".
			    " COUNT(randombox_item.randombox_item_id) AS count\n".
			    "FROM\n".
			    "(\n".
			    " SELECT * FROM randombox WHERE randombox_id = :id\n".
			    ") AS randombox\n".
			    "LEFT JOIN\n".
			    "(\n".
			    " SELECT * FROM randombox_item GROUP BY randombox_item_code\n".
			    ") AS randombox_item ON (randombox_item.randombox_id = randombox.randombox_id)";
			    $query_getRandomboxSelect = query($sql_getRandomboxSelect, array(
			      ':id' => $_POST['randombox_id']
			    ));
			    $randomboxSelect = $query_getRandomboxSelect->fetch();

			    if($randomboxSelect['count_randombox'] <= 0)
			    {
			    	echo '0';
			    }
			    elseif($randomboxSelect['count'] <= 0)
			    {
			    	echo '1';
			    }
			    elseif($randomboxSelect['randombox_status'] == 0)
			    {
			    	echo '2';
			    }
			    else
			    {
			    	echo $randomboxSelect['randombox_id']."|".$randomboxSelect['randombox_name']."|".
			    	$randomboxSelect['randombox_price'];
			    }
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'RandomBox')
		{
			if(isset($_SESSION['uid']))
			{
				$sql_randombox = "SELECT\n".
				"	COUNT(randombox.randombox_id) AS count_randombox,\n".
				"	COUNT(randombox_item.randombox_item_id) AS count,\n".
				"	randombox.randombox_price,\n".
				"	randombox_item.*\n".
				"FROM\n".
				"(\n".
				"	SELECT * FROM randombox WHERE randombox_id = :id\n".
				") AS randombox\n".
				"LEFT JOIN\n".
				"(\n".
				"	SELECT * FROM randombox_item ORDER BY RAND() LIMIT 1\n".
				") AS randombox_item ON (randombox_item.randombox_id = randombox.randombox_id)";
				$query_randombox = query($sql_randombox, array(
			      ':id' => $_POST['randombox_id']
			    ));
			    $randombox = $query_randombox->fetch();

			    if($randombox['count_randombox'] <= 0)
			    {
			    	echo '0';
			    }
			    elseif($randombox['count'] <= 0)
			    {
			    	echo '1';
			    }
			    else
			    {
			    	if($player['points'] >= $randombox['randombox_price'])
			    	{
			    		$sql_updatePointsPlayer = "UPDATE authme SET points = points-'".$randombox['randombox_price']."' WHERE id = :uid";
						$query_updatePointsPlayer = query($sql_updatePointsPlayer, array(
							':uid' => $_SESSION['uid']
						));

						if($query_updatePointsPlayer)
						{
							$sql_insertBackpack = "INSERT INTO backpack (backpack_name,backpack_command,backpack_img,".
		            		"user_id,server_id) VALUES (:backpack_name,:backpack_command,:backpack_img,:uid,:server_id)";
		            		$query_insertBackpack = query($sql_insertBackpack, array(
		            			':backpack_name' => $randombox['randombox_item_name'],
		            			':backpack_command' => $randombox['randombox_item_command'],
		            			':backpack_img' => $randombox['randombox_item_img'],
		            			':uid' => $_SESSION['uid'],
		            			':server_id' => $randombox['server_id']
		            		));

		            		if($query_insertBackpack)
		            		{
		            			echo '2|'.$randombox['randombox_item_name'];
		            		}
		            		else
		            		{
		            			echo '3';
		            		}
						}
						else
						{
							echo '4';
						}
			    	}
			    	else
			    	{
			    		echo '5';
			    	}
			    }
			}
			else
			{
				echo '500';
			}
		}
		elseif($g == 'searchPlayer')
		{
			if(!isset($_POST['search_username']))
			{
				echo '0';
			}
			elseif($_POST['search_username'] == "")
			{
				echo '1';
			}
			else
			{
				$sql_searchPlayer = "SELECT * FROM authme WHERE username = :username";
				$query_searchPlayer = query($sql_searchPlayer, array(
					':username' => $_POST['search_username']
				));

				if($query_searchPlayer->rowcount() <= 0)
				{
					echo '2';
				}
				else
				{
					$searchPlayer = $query_searchPlayer->fetch();
					$_SESSION['search_Player'] = $searchPlayer['realname'];

					echo '3';
				}
			}
		}
		elseif($g == 'reportPlayer')
		{
			if(isset($_SESSION['uid']))
			{
				if(!isset($_POST['descr']) || !isset($_POST['img']) || $_POST['descr'] == "" || empty($_POST['descr']) || !isset($_POST['uid']) || $_POST['uid'] == "" || empty($_POST['uid']))
				{
					echo '0';
				}
				else
				{
					if($_POST['uid'] == $_SESSION['uid'])
					{
						exit('3');
					}
					
					$sql_sendReport = "INSERT INTO report (report_uid_reporter,report_uid_person,report_descr,report_img) VALUES (".
					":uid_reporter,:uid_person,:report_descr,:report_img)";
					$query_sendReport = query($sql_sendReport, array(
						':uid_reporter' => $_SESSION['uid'],
						':uid_person' => $_POST['uid'],
						':report_descr' => $_POST['descr'],
						':report_img' => $_POST['img']
					));

					if($query_sendReport)
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
	}
	else
	{
		echo '405';
	}
?>