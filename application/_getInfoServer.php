<?php
	require __DIR__ . '/_MinecraftQuery.php';
	require __DIR__ . '/_MinecraftQueryException.php';
	use xPaw\MinecraftQuery;
	use xPaw\MinecraftQueryException;

	$MCQuery = new MinecraftQuery();
	try
	{
		$MCQuery->Connect("127.0.0.1", "25565", 3, false);
		$status_server = $MCQuery->GetInfo();

		$status_chk = true;
		$player_online = $status_server['Players'];
		$max_player = $status_server['MaxPlayers'];

		if(isset($_SESSION['uid']))
		{
			if($MCQuery->GetPlayers() != null)
			{
				foreach ($MCQuery->GetPlayers() as $key)
				{
					if($key == $_SESSION['realname'])
					{
						$status_chkOnline = true;
						break;
					}
				}
			}

			if(isset($status_chkOnline) && $status_chkOnline == true)
			{
				$chkPlayerOnline = true;
			}
			else
			{
				$chkPlayerOnline = false;
			}
		}
	}
	catch(MinecraftQueryException $e)
	{
		$status_chk = false;
	}

	if(isset($_GET['page']) == 'player')
	{
		if(isset($_SESSION['search_Player']))
		{
			try
			{
				$MCQuery->Connect("127.0.0.1", "25565", 3, false);
				$status_server = $MCQuery->GetInfo();

				if(isset($_SESSION['uid']))
				{
					if($MCQuery->GetPlayers() != null)
					{
						foreach ($MCQuery->GetPlayers() as $key)
						{
							if($key == $_SESSION['search_Player'])
							{
								$status_chkOnlineSearch = true;
								break;
							}
						}
					}

					if(isset($status_chkOnlineSearch) && $status_chkOnlineSearch == true)
					{
						$chkPlayerOnlineSearch = true;
					}
					else
					{
						$chkPlayerOnlineSearch = false;
					}
				}
			}
			catch(MinecraftQueryException $e)
			{
				$chkPlayerOnlineSearch = false;
			}
		}
	}
?>