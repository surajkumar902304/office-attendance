<body class="sb-nav-fixed">
    <?php include APPPATH . 'views/include/header.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include APPPATH . 'views/include/sidebar.php'; ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Listed Users</h1>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            User Details
                        </div>



                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $user['email']; ?></td>
                                            <td><?php echo $user['role_name']; ?></td>
                                            <td>
                                                <?php
                                                echo $user['status'] == 1 ? 'active' : 'in_active';
                                                ?>
                                            </td>

                                            <td>
                                                <!-- Add your action buttons here -->
                                                <a href="<?php echo site_url('users/edit/' . $user['user_id']); ?>"
                                                    class="btn btn-warning btn-sm">Edit</a>
                                                <?php if ($user['status'] == 1): ?>
                                                    <!-- Show Delete button if the status is 1 (active) -->
                                                    <a href="<?php echo site_url('users/delete/' . $user['user_id']); ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                                <?php else: ?>
                                                    <!-- Show Restore button if the status is 0 (inactive) -->
                                                    <a href="<?php echo site_url('users/restore/' . $user['user_id']); ?>"
                                                        class="btn btn-success btn-sm">Restore</a>
                                                <?php endif; ?>

                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>