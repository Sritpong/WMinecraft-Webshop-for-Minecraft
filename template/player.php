<?php
	if(isset($_SESSION['search_Player']))
	{
		?>
			<div class="card">
				<div class="card-body">
					<h6>
						<i class="fa fa-search"></i> Player: <?php echo $_SESSION['search_Player']; ?>
					</h6>
					<hr/>
					<?php
						$sql_getSearchPlayer = "SELECT * FROM authme WHERE realname = :realname LIMIT 1";
						$query_getSearchPlayer = query($sql_getSearchPlayer, array(
							':realname' => $_SESSION['search_Player']
						));
						if($query_getSearchPlayer->rowcount() <= 0)
						{
							exit("ไม่พบผู้เล่นนี้");
						}
						else
						{
							$searchPlayer = $query_getSearchPlayer->fetch();
							$sql_getReport = "SELECT * FROM report WHERE report_uid_person = :report_uid";
							$query_getReport = query($sql_getReport, array(
								':report_uid' => $searchPlayer['id']
							));
							$sql_getDetailReport = "SELECT\n".
							"	COUNT(report_status_wait.report_id) AS count_wait,\n".
							"	COUNT(report_status_success.report_id) AS count_success,\n".
							"	COUNT(report_accept_wait.report_id) AS count_accept_wait,\n".
							"	COUNT(report_accept_success.report_id) AS count_accept_success\n".
							"FROM\n".
							"(\n".
							"	SELECT * FROM report WHERE report_uid_person = :report_uid\n".
							") AS report\n".
							"LEFT JOIN\n".
							"(\n".
							"	SELECT * FROM report WHERE report_status = 0\n".
							") AS report_status_wait ON (report_status_wait.report_id = report.report_id)\n".
							"LEFT JOIN\n".
							"(\n".
							"	SELECT * FROM report WHERE report_status = 1\n".
							") AS report_status_success ON (report_status_success.report_id = report.report_id)\n".
							"LEFT JOIN\n".
							"(\n".
							"	SELECT * FROM report WHERE report_status = 1 AND report_accept = 0\n".
							") AS report_accept_wait ON (report_accept_wait.report_id = report.report_id)\n".
							"LEFT JOIN\n".
							"(\n".
							"	SELECT * FROM report WHERE report_status = 1 AND report_accept = 1\n".
							") AS report_accept_success ON (report_accept_success.report_id = report.report_id)";
							$query_getDetailReport = query($sql_getDetailReport, array(
								':report_uid' => $searchPlayer['id']
							));
							$getDetailReport = $query_getDetailReport->fetch();
							?>
								<div class="row">
									<div class="col-lg-12 text-center">
								        <img src="https://minotar.net/armor/body/<?php echo $_SESSION['search_Player']; ?>/100" alt="<?php echo $_SESSION['search_Player']; ?>"/>
								        <h2>
									        <?php echo $_SESSION['search_Player']; ?>
									    </h2>
									    <hr/>
								        <p>
								        	ประวัติการโดนรีพอร์ต: <?php echo $query_getReport->rowcount(); ?> ครั้ง
								        </p>
								        <p>
								        	กำลังรอตรวจสอบ: <?php echo $getDetailReport['count_wait']; ?> ครั้ง
								        </p>
								        <p>
								        	ตรวจสอบแล้ว: <?php echo $getDetailReport['count_success']; ?> ครั้ง
								        </p>
								        <p>
								        	ตรวจสอบแล้วไม่ผิด: <?php echo $getDetailReport['count_accept_wait']; ?> ครั้ง
								        </p>
								        <p>
								        	ตรวจสอบแล้วผิด: <?php echo $getDetailReport['count_accept_success']; ?> ครั้ง
								        </p>
								        <?php
								        	if(isset($_SESSION['uid']))
								        	{
								        		?>
								        			<hr/>
											        <div class="col-12">
											        	<div class="card">
															<div class="card-body">
																<h6>
																	รายงาน
																</h6>
																<hr/>
																<input id="uid_person" type="hidden" value="<?php echo $searchPlayer['id']; ?>"/>
																<form name="report_frm" id="report_frm" method="POST" action="javascript:void(0);" autocomplete="off">
																	<div class="form-group mb-2">
																		<label for="report_descr">รายละเอียด</label>
																		<textarea name="report_descr" id="report_descr" class="form-control"></textarea>
																	</div>
																	<div class="form-group mb-2">
																		<label for="report_img">แนบรูปภาพ</label>
																		<input name="report_img" id="report_img" type="text" class="form-control" placeholder="URL รูปภาพ"/>
																	</div>
																	<hr/>
																	<button type="submit" name="report_btn" id="report_btn" class="btn btn-outline-danger btn-block" onclick="report()">
																		แจ้งรายงาน
																	</button>
																</form>
															</div>
														</div>
											        </div>
								        		<?php
								        	}
								        ?>
							    	</div>
								</div>
							<?php
						}
					?>
				</div>
			</div>
		<?php
	}
?>