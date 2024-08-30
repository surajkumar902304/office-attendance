<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMP | Event Calendar</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f7f6;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 800px;
        margin: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed; /* Ensures columns have consistent width */
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        overflow: hidden; /* Prevents content overflow */
    }
    th {
        background-color: #f2f2f2;
    }
    .event {
        background-color: #d4edda;
        color: #155724;
        padding: 5px;
        border-radius: 4px;
    }
    .add-event {
        margin: 20px 0;
    }
</style>

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
                    <h1>Event Calendar</h1>
                    <div class="add-event">
                        <a href="<?php echo base_url('events/add'); ?>">Add New Event</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Event Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($event['start']); ?></td>
                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td>
                                        <a href="<?php echo base_url('events/edit/' . $event['id']); ?>">Edit</a> |
                                        <a href="<?php echo base_url('events/delete/' . $event['id']); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>
            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>
</body>
</html>
