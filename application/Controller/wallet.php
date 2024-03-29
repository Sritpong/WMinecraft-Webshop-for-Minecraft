<?php
	use WMinecraft\WalletAPI;
	require_once("../_config.php");
	require_once("../_pdo.php");

	if(isset($_GET['func']))
	{
		$g = $_GET['func']; // SET $_GET var;

		if($g == 'CJWallet')
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

		    if($wallet_email == null || empty($wallet_email) || $wallet_email == "" || $wallet_password == null || empty($wallet_password) || $wallet_password == "" || $wallet_access_token == null || empty($wallet_access_token) || $wallet_access_token == "")
		    {
		    	echo '0';
		    }
		    else
		    {
		    	require_once(__DIR__ . '/../Wallet/_loginTW.php');
				$tw_getstatus = new TrueWallet($wallet_email, $wallet_password);
				$tw_getstatus->setAccessToken($wallet_access_token);
				$data_getstatus = $tw_getstatus->GetProfile();

				echo $data_getstatus["code"];
		    }
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
    			$sql_getSettings = "SELECT settings_id,settings_shop_name,settings_line_token FROM settings WHERE settings_id = 1";
				$query_getSettings = query($sql_getSettings);

    			$sql_wallet = 'SELECT email,password,access_token,mutiple FROM wallet_account WHERE id = 1';
			    $query_wallet = query($sql_wallet);

			    if($query_wallet->rowcount() == 1)
			    {
			    	$f_wallet = $query_wallet->fetch();
			    	$wallet_email = $f_wallet['email'];
			    	$wallet_password = $f_wallet['password'];
			    	$wallet_access_token = $f_wallet['access_token'];
			    	$wallet_mutiple = $f_wallet['mutiple'];
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
								$points_receive = $ftam_u*$wallet_mutiple;

								$sql_searchRP = "SELECT * FROM wallet_rp WHERE wallet_rp_topup = :wallet_topup LIMIT 1";
								$query_searchRP = query($sql_searchRP, array(
									':wallet_topup' => str_replace(',', '', number_format($ftam_u, 2))
								));

								if($query_searchRP->rowcount() > 0)
								{
									$searchRP = $query_searchRP->fetch();
									$updateRP = $searchRP['wallet_rp_reward'];
								}
								else
								{
									$updateRP = 0;
								}

								$sql_insertLogs = 'INSERT INTO refill_logs (refill_logs_transaction,refill_logs_amount,refill_logs_receive,refill_logs_rp,refill_type_id,user_id) VALUES (:refill_transaction,:refill_amount,:refill_logs_receive,:refill_logs_rp,:refill_type_id,:uid)';
								$query_insertLogs = query($sql_insertLogs,array(
									':refill_transaction' => $fti_u,
									':refill_amount' => $ftam_u,
									':refill_logs_receive' => $points_receive,
									':refill_logs_rp' => $updateRP,
									':refill_type_id' => 1,
									':uid' => $_SESSION['uid']
								));

								if($query_insertLogs)
								{
									$sql_updatePoints = 'UPDATE authme SET points = points+:updatepoints, rp = rp+:updateRP WHERE id = :uid LIMIT 1';
									$query_updatePoints = query($sql_updatePoints,array(
										':updatepoints' => $points_receive,
										':updateRP' => $updateRP,
										':uid' => $_SESSION['uid']
									));

									if($query_updatePoints)
									{
										echo '2|'.number_format($ftam_u, 2).'|'.$ftphone_u;

										if($query_getSettings->rowcount() > 0)
										{
											$getSettings = $query_getSettings->fetch();

											if($getSettings['settings_line_token'] != "")
											{
												require_once(__DIR__ . "/../_lineModel.php");
												$line = new Line_Notify();
												$line->setToken($getSettings['settings_line_token']);

												$line->setMsg('==== '.$getSettings['settings_shop_name'].' ====');
												$line->addMsg('ผู้เล่น '.$_SESSION['realname'].' ได้ทำการเติมเงิน');
												$line->addMsg('ด้วยระบบ TrueWallet');
												$line->addMsg('เลขอ้างอิง: '. $fti_u);
												$line->addMsg('จำนวน: '. number_format($ftam_u, 2) .' บาท');

												$line->sendNotify();
											}
										}
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
							if($query_getSettings->rowcount() > 0)
							{
								$getSettings = $query_getSettings->fetch();

								if($getSettings['settings_line_token'] != "")
								{
									require_once(__DIR__ . "/../_lineModel.php");
									$line = new Line_Notify();
									$line->setToken($getSettings['settings_line_token']);

									$line->setMsg('==== '.$getSettings['settings_shop_name'].' ====');
									$line->addMsg('Access Token เสีย กรุณาเข้าระบบหลังบ้านไปรับ Access Token ใหม่');

									$line->sendNotify();
								}
							}
						}
			    	}
			    }
    		}
		}
		elseif($g == 'topupTMN')
		{
    		if(!isset($_SESSION['uid']))
    		{
    			echo '6';
    		}
    		elseif(!is_numeric($_POST['truemoney_password']))
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
			    elseif($_POST['truemoney_password'] == '' || empty($_POST['truemoney_password']) || $_POST['truemoney_password'] == null)
			    {
			    	echo '2';
			    }
			    else
			    {
			    	$sql_getSettings = "SELECT settings_id,settings_shop_name,settings_line_token FROM settings WHERE settings_id = 1";
					$query_getSettings = query($sql_getSettings);
					
		    		require_once(__DIR__ . '/../Wallet/_loginTW.php');
					$tw_getstatus = new TrueWallet($wallet_email, $wallet_password);
					$tw_getstatus->setAccessToken($wallet_access_token);
					$data_getstatus = $tw_getstatus->GetProfile();
					@$tw_card = $_POST['truemoney_password'];

					if($data_getstatus["code"] == 'UPC-200')
					{
						require_once(__DIR__ . '/../Wallet/_truewallet.php');
						$tw = new WalletAPI();
						$token = $wallet_access_token;
						$objtw = $tw->CashcardTopup($token, $tw_card);

						if(isset($objtw['amount']))
						{
							$objtw_amount = $objtw['amount']; // จำนวนเงิน
							$objtw_transactionId = $objtw['transactionId']; // หมายเลขอ้างอิง
							$objtw_serverFee = $objtw['serviceFee']; // ภาษีที่โดนหัก
							$objtw_cashcardPin = $objtw['cashcardPin']; // รหัสบัตรเงินสดทรูมันนี่
							$objtw_createDate = $objtw['createDate']; // วันเวลาที่เติมเข้าสู่ระบบ

							$sql_search = 'SELECT * FROM truemoney WHERE amount = "'.$objtw_amount.'"';
		            		$query_search = query($sql_search);

		            		if($query_search->num_rows != 0)
		            		{
		            			$fetch_search = $query_search->fetch_assoc();
		            			$update_amount = $fetch_search['points'];
		            			$updateRpTMN = $fetch_search['rp'];
		            		}
		            		else
		            		{
		            			$update_amount = 0;
		            			$updateRpTMN = 0;
		            		}

		            		$sql_insertLogs = 'INSERT INTO refill_logs (refill_logs_transaction,refill_logs_amount,'.
		            		'refill_logs_receive,refill_logs_rp,refill_type_id,user_id) '.
		            		'VALUES (:refill_transaction,:refill_amount,:refill_receive,:refill_rp,:refill_type_id,:uid)';
							$query_insertLogs = query($sql_insertLogs,array(
								':refill_transaction' => $tw_card,
								':refill_amount' => $objtw_amount,
								':refill_receive' => $update_amount,
								':refill_rp' => $updateRpTMN,
								':refill_type_id' => 2,
								':uid' => $_SESSION['uid']
							));
							
							if($query_insertLogs)
							{
								$sql_updatepoints = 'UPDATE authme SET points = points+:updatepoints, rp = rp+:updateRP WHERE id = :uid LIMIT 1';
			            		$query_updatePoints = query($sql_updatepoints, array(
			            			':updatepoints' => $update_amount,
			            			':updateRP' => $updateRpTMN
			            		));

			            		if($query_updatePoints)
			            		{
			            			echo '1'.'|'.number_format($objtw_amount, 2);

									if($query_getSettings->rowcount() > 0)
									{
										$getSettings = $query_getSettings->fetch();

										if($getSettings['settings_line_token'] != "")
										{
											require_once(__DIR__ . "/../_lineModel.php");
											$line = new Line_Notify();
											$line->setToken($getSettings['settings_line_token']);

											$line->setMsg('==== '.$getSettings['settings_shop_name'].' ====');
											$line->addMsg('ผู้เล่น '.$_SESSION['realname'].' ได้ทำการเติมเงิน');
											$line->addMsg('ด้วยระบบ TrueMoney');
											$line->addMsg('รหัสบัตรทรูมันนี่: '. $tw_card);
											$line->addMsg('จำนวน: '. number_format($objtw_amount, 2) .' บาท');

											$line->sendNotify();
										}
									}
			            		}
			            		else
			            		{
			            			echo '3';
			            		}
							}
		            		else
		            		{
		            			echo '9';
		            		}
						}
						elseif($objtw['code'] == '-1')
						{
							echo '4';
						}
						else
						{
							echo '8';
						}
					}
					else
					{
						echo '5|'.$data_getstatus["code"];
						if($query_getSettings->rowcount() > 0)
						{
							$getSettings = $query_getSettings->fetch();

							if($getSettings['settings_line_token'] != "")
							{
								require_once(__DIR__ . "/../_lineModel.php");
								$line = new Line_Notify();
								$line->setToken($getSettings['settings_line_token']);

								$line->setMsg('==== '.$getSettings['settings_shop_name'].' ====');
								$line->addMsg('Access Token เสีย กรุณาเข้าระบบหลังบ้านไปรับ Access Token ใหม่');

								$line->sendNotify();
							}
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