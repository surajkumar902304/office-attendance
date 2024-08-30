

<body class="sb-nav-fixed">
    <?php include APPPATH . 'views/include/header.php'; ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?php include APPPATH . 'views/include/sidebar.php'; ?>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Change Password</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-6">
                            <?php if ($this->session->flashdata('success')) { ?>
                                <p style="color:green"><?php echo $this->session->flashdata('success'); ?></p>
                            <?php } ?>

                            <!--error message -->
                            <?php if ($this->session->flashdata('error')) { ?>
                                <p style="color:red"><?php echo $this->session->flashdata('error'); ?></p>
                            <?php } ?>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <?php echo form_open('login/changepassword'); ?>
                                    <div class="mb-3 mt-3">
                                        <label for="currentpassword">Current Password:</label>
                                        <input type="password" class="form-control" id="currentpassword"
                                            name="currentpassword" value="<?php echo set_value('currentpassword'); ?>">
                                        <?php echo form_error('currentpassword', '<p style="color:red">', '<p>') ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="newpassword">New Password:</label>
                                        <input type="password" class="form-control" id="newpassword" name="newpassword"
                                            value="<?php echo set_value('newpassword'); ?>">
                                        <?php echo form_error('newpassword', '<p style="color:red">', '<p>') ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="pwd">Confirm Password:</label>
                                        <input type="password" class="form-control" id="confirmpassword"
                                            name="confirmpassword" value="<?php echo set_value('confirmpassword'); ?>">
                                        <?php echo form_error('confirmpassword', '<p style="color:red">', '<p>') ?>
                                    </div>

                                    <input type="submit" name="submit" id="submit" value="submit"
                                        class="btn btn-primary">

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
    