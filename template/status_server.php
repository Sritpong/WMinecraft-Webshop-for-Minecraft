<div class="card mt-3">
	<div class="card-header bg-info text-white">
		<i class="fa fa-signal"></i> Server Status
	</div>
	<div class="card-body">
		<?php
			if(isset($status_chk) && $status_chk == true)
			{
				?>
					<h5 class="mb-1 text-success text-center">Online <?php echo $player_online."/".$max_player; ?> Players</h5>
					<div class="progress">
						<div class="progress-bar" role="progressbar" style="width: <?php echo ($player_online*100)/$max_player; ?>%;" aria-valuenow="<?php echo $player_online; ?>" aria-valuemin="0" aria-valuemax="<?php echo $max_player; ?>"></div>
					</div>
				<?php
			}
			else
			{
				?>
					<div class="alert alert-danger text-center mt-2">
						Offline
					</div>
				<?php
			}
		?>
	</div>
</div>