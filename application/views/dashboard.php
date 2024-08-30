<body class="sb-nav-fixed">
    <?php include APPPATH . 'views/include/header.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include APPPATH . 'views/include/sidebar.php'; ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>

                    <?php
                    $role_id = $this->session->userdata('role_id'); // Assuming role_id is stored in session
                    $Name = $this->session->userdata('Name'); // Assuming Name is stored in session
                    ?>

                    <?php if ($role_id == 1): ?>
                        <div class="row">
                            <div class="col-xl-5 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Create Employee Profile</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link"
                                            href="<?php echo base_url('users/createuser'); ?>">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Update Employee Profile</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link"
                                            href="<?php echo base_url('Employeeupdate/select_user'); ?>">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-5 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Events</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link"
                                            href="<?php echo base_url('Events/index'); ?>">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php $username = $this->session->userdata('username'); ?>
                            <center>
                                <h1>Welcome <?php echo $username; ?></h1>
                            </center>
                        </div>
                    <?php endif; ?>

                </div>
            </main>

            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>
</body>