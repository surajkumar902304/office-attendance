
<body class="sb-nav-fixed">
    <?php include APPPATH.'views/include/header.php';?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include APPPATH.'views/include/sidebar.php';?> 
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit User</h1>
                    
                    

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-edit me-1"></i>
                            User Information
                        </div>
                        <div class="card-body">
                            <?php echo form_open('users/update/'.$users['user_id']); ?>
                            <div class="row mb-3">
                                    <label for="username">Username:</label>
                                    <input type="text" id="username" name="username" class="form-control" value="<?php echo set_value('username', $users['username']); ?>" required>
                                    <?php echo form_error('username'); ?>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" class="form-control" value="<?php echo set_value('email', $users['email']); ?>" required>
                                    <?php echo form_error('email'); ?>
                                </div>
                                
                                <div class="row mb-3">
                                            <div class="col-md-6">
                                    <label for="role_id">Role:</label>
                                    <select id="role_id" name="role_id" class="form-control" required>
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?php echo $role['role_id']; ?>" <?php echo ($role['role_id'] == $users['role_id']) ? 'selected' : ''; ?>>
                                                <?php echo $role['role_name']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('role_id'); ?>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="status">Status:</label>
                                    <select id="status" name="status" class="form-control" required>
                                        <option value="1" <?php echo ($users['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                        <option value="0" <?php echo ($users['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                                    </select>
                                    <?php echo form_error('status'); ?>
                                </div></div>

                                <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="<?php echo site_url('users/get_user'); ?>" class="btn btn-secondary">Cancel</a>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </main>
            
            <?php include APPPATH.'views/include/footer.php';?>
        </div>
    </div>
    