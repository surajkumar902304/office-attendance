<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading"></div>
            <a class="nav-link" href="<?php echo base_url('Dashboard'); ?>">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <?php $role_id = $this->session->userdata('role_id'); ?>

            <?php if ($role_id == 1): ?>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts1"
                    aria-expanded="false" aria-controls="collapseLayouts1">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Employees
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts1" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="<?php echo base_url('users/createuser') ?>">Create Employee</a>
                        <a class="nav-link" href="<?php echo base_url('users/get_user') ?>">Manage Employees</a>
                        <a class="nav-link" href="<?php echo base_url('attendance/mark') ?>">Mark Attendance</a>
                        <a class="nav-link" href="<?php echo base_url('attendance/attendance_report') ?>">Attendance Report</a>
                        
                    </nav>
                </div>
            <?php endif; ?>
            <?php if ($role_id == 3): ?>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                Employees
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">


                    
                    
                        <a class="nav-link" href="<?php echo base_url('attendance/punch_attendance') ?>">Punch Attendance</a>
                        <a class="nav-link" href="<?php echo base_url('Employeeupdate/select_user'); ?>">Update Profile</a>
                    

                </nav>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <div class="sb-sidenav-footer">
    <div class="small">Logged in as IMPACTMINDZ :</div>
    <?php
    // Retrieve the user's role_id from the session
    $role_id = $this->session->userdata('role_id');
    
    // Display the appropriate role based on role_id
    switch ($role_id) {
        case 1:
            echo 'Admin';
            break;
        case 2:
            echo 'HR'; // Assuming role_id 2 corresponds to HR
            break;
        case 3:
            echo 'Employee';
            break;
        default:
            echo 'Unknown Role';
            break;
    }
    ?>
</div>

</nav>