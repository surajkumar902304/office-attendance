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

                            <div class="col-md-3">
                                <label for="user">Select User</label>
                                <select name="user_id" class="form-control">
                                    <option value="">Select User</option>
                                    <?php foreach ($users_list as $user): ?>
                                        <option value="<?php echo $user['user_id']; ?>" <?php echo ($user['user_id'] == $user_id) ? 'selected' : ''; ?>>
                                            <?php echo $user['user_id'] . " " . $user['username']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3" id="tickmark">
                                <label for="show_only_present">Show Employee with attendance</label>
                                <input type="checkbox" name="show_only_present" id="show_only_present" value="1" <?php echo $show_only_present ? 'checked' : ''; ?>>
                            </div>
                            <div class="col-md-2" id="tickmark1">
                                <div class="form-group">
                                    <?php echo form_submit('submit', 'Show Report', 'class="btn btn-primary"'); ?>
                                </div>
                            </div>
                        </div>

                        <?php echo form_close(); ?>

                        <div class="attendance-calendar">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Sun</th>
                                        <th>Mon</th>
                                        <th>Tue</th>
                                        <th>Wed</th>
                                        <th>Thu</th>
                                        <th>Fri</th>
                                        <th>Sat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                                    $first_day = date('w', mktime(0, 0, 0, $month, 1, $year));

                                    // Initialize counters
                                    $total_present = 0;
                                    $total_absent = 0;
                                    $total_leave = 0;
                                    $total_hours = 0;

                                    // Print the days of the month
                                    $row = 0;
                                    for ($i = 1; $i <= $num_days + $first_day; $i++) {
                                        if (($i - 1) % 7 == 0) {
                                            echo "<tr>";
                                        }

                                        if ($i <= $first_day) {
                                            echo "<td></td>";
                                        } else {
                                            $date = $i - $first_day;
                                            $day_of_week = ($i - 1) % 7;
                                            $cell_class = ($day_of_week == 0 || $day_of_week == 6) ? 'status-weekend' : '';
                                            
                                            if ($i % 7 == 1 || $i % 7 == 0) {
                                                echo "<td id='sat'>";
                                            } else {
                                                echo "<td>";
                                            }
                                            
                                            echo "<div class='date'>" . $date . "</div>";

                                            // Print the attendance data for each user
                                            foreach ($users as $user) {
                                                $attendance_date = sprintf('%s-%s-%02d', $year, $month, $date);
                                                if ($user['user_id'] == $user_id) {
                                                    if ($i % 7 == 1 || $i % 7 == 0) {
                                                        continue;
                                                    } else {
                                                        if (isset($attendance_data[$user['user_id']][$attendance_date])) {
                                                            $status = $attendance_data[$user['user_id']][$attendance_date]['status'];
                                                            $working_hours = $attendance_data[$user['user_id']][$attendance_date]['working_hours'];
    
                                                            // Increment counters
                                                            if ($status == 'present') {
                                                                $total_present++;
                                                            } elseif ($status == 'absent') {
                                                                $total_absent++;
                                                            } elseif ($status == 'leave') {
                                                                $total_leave++;
                                                            }
                                                            if (strpos($working_hours, ':') !== false) {
                                                                list($hours_part, $minutes_part) = explode(':', $working_hours);
                                                                $hours = floatval($hours_part) + floatval($minutes_part) / 60;
                                                            } else {
                                                                // If working_hours is not in HH:MM format, assume it's just hours
                                                                $hours = is_numeric($working_hours) ? floatval($working_hours) : 0;
                                                            }
                                                            
                                                            $total_hours += $hours;
                                                            
    
                                                            if (!$show_only_present || $status !== 'NF') {
                                                                echo "<div class='attendance-status " . $cell_class . " status-" . strtolower($status) . "'>";
                                                                echo $status . "<br>" . $working_hours;
                                                                echo "</div>";
                                                            }
                                                        } else {
                                                            echo "<div class='attendance-status " . $cell_class . " status-nf'>NF<br>N/A</div>";
                                                        }
                                                    }
                                                    
                                                }
                                            }
                                            echo "</td>";
                                        }

                                        // Start a new row after the 7th day (Saturday)
                                        
                                        if (($i - 1) % 7 == 6) {
                                            echo "</tr>";
                                        }
                                        
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Display Totals Below the Calendar -->
                        <div class="attendance-totals"><br>
                            <h3>Monthly Summary</h3>
                            <ul>
                                <li>Total Present Days: <?php echo $total_present; ?></li>
                                <li>Total Absent Days: <?php echo $total_absent; ?></li>
                                <li>Total Leave Days: <?php echo $total_leave; ?></li>
                                <li>Total Login Hours: <?php echo $total_hours; ?></li>
                            </ul>
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

        <style>
            /* Container styling */
            .container {
                margin: 50px;
            }
            #sat{
                background-color: orchid;
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

            .attendance-calendar .status-weekend {
                background-color: #f5d76e;
                color: #333;
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

            .attendance-calendar {
                font-family: Arial, sans-serif;
                font-size: 14px;
                width: 100%;
                max-width: 800px;
                margin: 0 auto;
            }

            .attendance-calendar table {
                width: 100%;
                border-collapse: collapse;
            }

            .attendance-calendar th,
            .attendance-calendar td {
                padding: 10px;
                text-align: center;
                border: 1px solid #ddd;
            }

            .attendance-calendar th {
                background-color: #f2f2f2;
            }

            .attendance-calendar .date {
                font-weight: bold;
                margin-bottom: 5px;
            }

            .attendance-calendar .attendance-status {
                padding: 5px;
                border-radius: 4px;
                font-size: 12px;
                line-height: 1.2;
            }

            .attendance-calendar .status-present {
                background-color: #d4edda;
                color: #155724;
            }

            .attendance-calendar .status-absent {
                background-color: #f8d7da;
                color: #721c24;
            }
            .attendance-calendar .status-leave {
                background-color: yellow;
                color: #721c24;
            }

            .attendance-calendar .status-nf {
                background-color: #e2e3e5;
                color: #383d41;
            }
        </style>
</body>