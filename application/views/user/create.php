<style>
    .container{
        margin-top: 30px;
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
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card mt-5">
                                <div class="card-header text-center">
                                    <h2>Create Employee</h2>
                                    <?php if ($this->session->flashdata('message')) { ?>
                                <p style="color:green"><?php echo $this->session->flashdata('message'); ?></p>
                            <?php } ?>
                                </div>
                                <div class="card-body">
                                    <?php echo form_open_multipart('users/createuser'); ?>
                                    
                                        <div class="row mb-3">
                                            <label for="username">Username:</label>
                                            <input type="text" id="username" name="username" required><br>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="password">Password:</label>
                                            <input type="password" id="password" name="password" required><br>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="email">Email:</label>
                                            <input type="email" id="email" name="email" required><br>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="role_id">Role:</label>
                                                    <select id="role_id" name="role_id" class="form-control" required>
                                                    <?php foreach ($roles as $role): ?>
                                                    <option value="<?php echo $role['role_id']; ?>"
                <?php echo ($role['role_id'] == 3) ? 'selected' : ''; ?>>
                <?php echo $role['role_name']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
</div>

                                            <div class="col-md-6">
                                                <label for="status">Status:</label>
                                                <select id="status" name="status" class="form-control" required>
                                                    <?php foreach ($statuses as $key => $value): ?>
                                                        <option value="<?php echo $key; ?>">
                                                            <?php echo $value; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select><br>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <button type="submit">Submit</button>
                                        </div>
                                        </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>
    