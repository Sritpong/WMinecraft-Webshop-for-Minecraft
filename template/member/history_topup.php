<?php
    if(isset($_SESSION['uid']))
    {
        ?>
            <div class="card my-3">
                <div class="card-body">
                    <h6><i class="fa fa-history"></i> History Topup</h6>
                    <hr/>
                    <table id="history_topup" class="table table-striped nowrap table-sm" style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ระบบ</th>
                                <th>หมายเลขอ้างอิง</th>
                                <th>วันที่</th>
                                <th>เวลา</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_history_topup">
                            <?php
                                $row_history_topup = 0;
                                $sql_history_topup = "SELECT\n".
                                "   refill_logs.refill_logs_id AS id,\n".
                                "   refill_logs.refill_logs_transaction AS transaction,\n".
                                "   refill_logs.refill_logs_amount AS amount,\n".
                                "   refill_type.refill_type_name,\n".
                                "   DATE_FORMAT(refill_logs.time_reg, '%d/%m/%Y') AS date,\n".
                                "   TIME(refill_logs.time_reg) AS time\n".
                                "FROM\n".
                                "(\n".
                                "   SELECT * FROM refill_logs WHERE user_id = :uid\n".
                                ") AS refill_logs\n".
                                "LEFT JOIN\n".
                                "(\n".
                                "   SELECT * FROM refill_type\n".
                                ") AS refill_type ON (refill_type.refill_type_id = refill_logs.refill_type_id)";
                                $query_history_topup = query($sql_history_topup,array(':uid' => $_SESSION['uid']));

                                while($history_topup = $query_history_topup->fetch())
                                {
                                    $row_history_topup++;
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $row_history_topup; ?>
                                            </td>
                                            <td>
                                                <?php echo $history_topup['refill_type_name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $history_topup['transaction']; ?>
                                            </td>
                                            <td>
                                                <?php echo $history_topup['date']; ?>
                                            </td>
                                            <td>
                                                <?php echo $history_topup['time']; ?>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
    }
?>