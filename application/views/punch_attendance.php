<?php date_default_timezone_set('Asia/Kolkata'); // Set to India timezone ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            margin-top: 40%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }

        select,
        input[type="date"],
        input[type="time"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            color: #333;
            transition: border-color 0.3s ease;
        }

        select:focus,
        input[type="date"]:focus,
        input[type="time"]:focus {
            outline: none;
            border-color: #4CAF50;
        }

        button {


            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body class="sb-nav-fixed">
    <?php include APPPATH . 'views/include/header.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include APPPATH . 'views/include/sidebar.php'; ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container">
                    <h2>Mark Attendance</h2>

                    <?php if ($this->session->flashdata('success')){ ?>
                        <p style="color:green"><?php echo $this->session->flashdata('success'); ?></p>

                    <?php } ?>
                    <?php if ($this->session->flashdata('error')){ ?>
                        <p style="color:red"><?php echo $this->session->flashdata('error'); ?></p>

                    <?php } ?>


                    <?php echo form_open('attendance/punch_attendance', array('id' => 'attendance_form')); ?>
                    <div class="form-group">
                        <label for="current_datetime">Current Date and Time:</label>
                        <input type="text" id="current_datetime" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly>
                    </div>
                    <?php
                    $this->load->model('Attendance_model');
                    $is_mark = $this->Attendance_model->is_attadence_mark($this->session->userdata('user_id')); ?>
                    <div class="row mb-3">
    <div class="col-md-6">
        <?php if (!$is_mark) { // If no record is found, display Punch In ?>
            <button type="submit" name="action" value="punch_in" id="punch_in">Punch In</button>
        <?php } ?>
    </div>
    <div class="col-md-6" id="punch_out_div"
        style="<?php echo ($is_mark && empty($check_out)) ? 'display: block;' : 'display: none;'; ?>">
        <?php if ($is_mark && empty($check_out)) { // If record is found and check_out is empty, display Punch Out ?>
            <button type="submit" name="action" value="punch_out" id="punch_out">Punch Out</button>
        <?php } ?>
    </div>
</div>

                    <?php echo form_close(); ?>
                </div>
            </main>

            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>

    
</body>

</html>