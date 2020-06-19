<?php
	require_once("../_config.php");

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
	}
	else
	{
		echo '405';
	}
?>