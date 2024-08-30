<!-- application/views/mark_attendance.php -->

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
        margin-top: 30px;
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
        background-color: #4CAF50;
        color: white;
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

                    <?php echo validation_errors(); ?>

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                    <?php echo form_open('attendance/submit_attendance'); ?>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Employee</label>
                        <select name="user_id" required>
                            <option value="">Select Employee</option>
                            <?php foreach ($employees as $employee): ?>

                                <option value="<?php echo $employee['user_id']; ?>">
                                    <?php echo $employee['user_id'] . ' ' . $employee['username']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" required>
                            <option value="">Select Status</option>
                            <option value="present">Present</option>
                            <option value="absent">Absent</option>
                            <option value="leave">Leave</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="check_in">Check-in Time</label>
                        <input type="time" name="check_in" required>
                    </div>

                    <div class="form-group">
                        <label for="check_out">Check-out Time</label>
                        <input type="time" name="check_out" required>
                    </div>

                    <button type="submit">Mark Attendance</button>

                    <?php echo form_close(); ?>
                </div>
            </main>

            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>
</body>

</html>