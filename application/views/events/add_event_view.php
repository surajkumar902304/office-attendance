<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMP | Add Event</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
        }

        form {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="start"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
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
                    <h1>Add Event</h1>
                    <?php echo validation_errors(); ?>
                    <?php echo form_open('events/add'); ?>
                    <div class="form-group">
                        <label for="title">Event Title</label>
                        <input type="text" name="title" id="title" value="<?php echo set_value('title'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="start">Event start</label>
                        <input type="start" name="start" id="start" value="<?php echo set_value('start'); ?>" required>
                    </div>
                    <button type="submit">Add Event</button>
                    <?php echo form_close(); ?>
                </div>
            </main>

            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>
</body>

</html>