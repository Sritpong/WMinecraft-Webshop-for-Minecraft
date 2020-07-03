<?php
	if(isset($_SESSION['search_Player']))
	{
		echo "Real Name: ".$_SESSION['search_Player']."<br/>";
		if(isset($chkPlayerOnlineSearch) && $chkPlayerOnlineSearch == true)
		{
			echo 'Status: <label class="text-success"><b>Online</b></label>';
		}
		else
		{
			echo 'Status: <label class="text-danger"><b>Offline</b></label>';
		}
	}
?>