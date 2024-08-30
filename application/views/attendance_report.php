<style>
    /* Container styling */
    .container {
        margin: 20px;
    }

    /* Table styling */
    .table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }

    .table thead th {
        background-color: #2c3e50;
        color: white;
        padding: 10px;
    }

    .table tbody td {
        padding: 10px;
        font-size: 14px;
        text-align: center;
    }

    /* NF (Not Found) status */
    .table tbody td[data-status="NF"] {
        background-color: #dcdcdc;
        color: black;
    }

    /* OFF status */
    .table tbody td[data-status="OFF"] {
        background-color: #27ae60;
        color: white;
    }

    /* L status (Leave) */
    .table tbody td[data-status="L"] {
        background-color: #f39c12;
        color: white;
    }

    /* Form styling */
    form .form-control {
        height: 40px;
    }

    form .btn-block {
        height: 40px;
        line-height: 20px;
    }

    #tickmark {
        margin-top: 30px;
    }

    #tickmark1 {
        margin-top: 25px;
    }
</style>

<body class="sb-nav-fixed">
    <?php include APPPATH . 'views/include/header.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include APPPATH . 'views/include/sidebar.php'; ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <h2>Attendance Report</h2>

                    <?php echo form_open('attendance/attendance_report', ['method' => 'post']); ?>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="year">Year</label>
                            <?php
                            $current_year = date('Y');
                            $start_year = $current_year - 5;
                            $end_year = $current_year + 5;
                            $year_options = array();
                            for ($i = $start_year; $i <= $end_year; $i++) {
                                $year_options[$i] = $i;
                            }
                            echo form_dropdown('year', $year_options, $year, 'class="form-control"');
                            ?>
                        </div>
                        <div class="col-md-2">
                            <label for="month">Month</label>
                            <?php
                            $month_options = array();
                            for ($i = 1; $i <= 12; $i++) {
                                $month_num = sprintf('%02d', $i);
                                $month_name = date('F', mktime(0, 0, 0, $i, 1));
                                $month_options[$month_num] = $month_name;
                            }
                            echo form_dropdown('month', $month_options, $month, 'class="form-control"');
                            ?>
                        </div>

                        <div class="col-md-3" id="tickmark">
                            <label for="show_only_present">Show only users with attendance</label>
                            <input type="checkbox" name="show_only_present" id="show_only_present" value="1" <?php echo $show_only_present ? 'checked' : ''; ?>>
                        </div>
                        <div class="col-md-2" id="tickmark1">
                            <div class="form-group">
                                <?php echo form_submit('submit', 'Show Report', 'class="btn btn-primary"'); ?>
                            </div>
                        </div>
                    </div>



                    <?php echo form_close(); ?>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <?php
                                    $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                    for ($i = 1; $i <= $num_days; $i++): ?>
                                        <th><?php echo sprintf('%02d', $i); ?></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $user['user_id']; ?></td>
                                        <td><?php echo $user['username']; ?></td>
                                        <?php
                                        for ($i = 1; $i <= $num_days; $i++) {
                                            $date = sprintf('%s-%s-%02d', $year, $month, $i);
                                            if (isset($attendance_data[$user['user_id']][$date])) {
                                                $status = $attendance_data[$user['user_id']][$date]['status'];
                                                $working_hours = $attendance_data[$user['user_id']][$date]['working_hours'];
                                                echo "<td data-status='" . htmlspecialchars($status) . "'>" .
                                                    htmlspecialchars($status) . "<br>" .
                                                    htmlspecialchars($working_hours) .
                                                    "</td>";
                                            } else {
                                                echo "<td data-status='NF'>NF<br>N/A</td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.table').DataTable({
                "pageLength": 10,
                "searching": true
            });
        });
    </script>
</body>