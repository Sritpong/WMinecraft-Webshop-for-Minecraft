<div class="card">
	<div class="card-body">
		<h6>
			<i class="fa fa-search"></i> Find Player
		</h6>
		<hr/>
		<div id="alert_register"></div>
		<form name="player_search" id="player_search" method="POST" action="javascript:void(0);">
			<div class="form-group mb-2">
				<input name="search_player_username" id="search_player_username" type="text" class="form-control" placeholder="ชื่อตัวละครในเกม">
			</div>
			<button type="submit" id="button_search_player" class="btn btn-outline-secondary btn-block" onclick="searchPlayer()">
				<i class="fa fa-search"></i> ค้นหา
			</button>
		</form>
	</div>
</div>