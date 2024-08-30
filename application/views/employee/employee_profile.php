<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/employee_profile.css'); ?>">

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .user-select-form {
            margin-bottom: 20px;
        }

        .registration-form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-column {
            width: 100%;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        .preview-image {
            max-width: 100px;
            margin-bottom: 10px;
            display: block;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .select-user-message {
            color: #666;
            font-style: italic;
        }

        .profile-image-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto 20px;
            border: 3px solid #4CAF50;
        }

        #profile-image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-image-container {
            cursor: pointer;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.9);
        }
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }
        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
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
                    <?php
                    $role_id = $this->session->userdata('role_id'); // Retrieve the role_id from the session                    
                    if ($role_id == 1) { ?>
                        <h1>Employee Details Form</h1>
                        <form method="post" action="<?php echo site_url('Employeeupdate/select_user'); ?>"
                            class="user-select-form">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="user_id">Select User:</label>
                                    <select name="user_id" id="user_id" onchange="this.form.submit()">
                                        <option value="">Select User</option>
                                        <?php if (isset($users) && !empty($users)): ?>
                                            <?php foreach ($users as $user): ?>
                                                <option value="<?php echo $user['user_id']; ?>" <?php echo (isset($selected_user_id) && $selected_user_id == $user['user_id']) ? 'selected' : ''; ?>>
                                                    <?php echo $user['user_id'] . "        " . $user['username']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>


                                </div>
                            </div>
                        </form>
                    <?php } ?>




                    <?php if (isset($selected_user_id)): ?>

                        <div class="profile-image-container">
    <img id="profile-image-preview"
         src="<?php echo isset($employee_details->profile_image) ? base_url('assets/uploads/profile_picture/' . $employee_details->profile_image) : base_url('assets/images/default-profile.png'); ?>"
         alt="Profile Image" onclick="openModal(this.src)">
</div>

<div id="imageModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImage">
</div>
                        <form method="post" action="<?php echo site_url('Employeeupdate/update_employee'); ?>"
                            enctype="multipart/form-data" class="registration-form">
                            <input type="hidden" name="user_id" value="<?php echo $selected_user_id; ?>">
                            <div class="form-column">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="first_name">First Name:</label>
                                        <input type="text" id="first_name" name="first_name"
                                            value="<?php echo isset($employee_details->first_name) ? $employee_details->first_name : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name">Last Name:</label>
                                        <input type="text" id="last_name" name="last_name"
                                            value="<?php echo isset($employee_details->last_name) ? $employee_details->last_name : ''; ?>">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="contact_number">Contact Number:</label>
                                        <div class="input-group ">
                                            <span class="input-group-text ">+91</span>
                                            <input type="text" id="contact_number" name="contact_number" maxlength="10" class="form-control"
                                            value="<?php echo isset($employee_details->contact_number) ? $employee_details->contact_number : ''; ?>">
                                        </div>
                                        <small id="contact_number_error" class="text-danger"></small>
                                    </div>
                                    <div class="col-md-6">
                                    
 
                                       
  
 
                                        <label for="salary">Salary:</label>
                                        <div class="input-group">
                                            <span class="input-group-text rupee-symbol">₹</span>
                                            <input type="number" id="salary" name="salary" class="form-control"
                                                value="<?php echo isset($employee_details->salary) ? $employee_details->salary : ''; ?>"
                                                min="0" step="0.01" <?php if ($role_id == 3) { ?>disabled<?php } ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">

                                        <label for="dob">Date of Birth:</label>
                                        <input type="date" id="dob" name="dob"
                                            value="<?php echo isset($employee_details->dob) ? $employee_details->dob : ''; ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="profile_image">Profile Image:</label><br>
                                        <input type="file" id="profile_image" name="profile_image"
                                            onchange="previewImage(this);">

                                    </div>
                                </div>

                                <label for="address">Address:</label>
                                <textarea id="address"
                                    name="address"><?php echo isset($employee_details->address) ? $employee_details->address : ''; ?></textarea>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="date_of_joining">Date of Joining:</label>
                                        <input type="date" id="date_of_joining" name="date_of_joining"
                                            value="<?php echo isset($employee_details->date_of_joining) ? $employee_details->date_of_joining : ''; ?>" <?php if ($role_id == 3) { ?>disabled<?php } ?>>
                                    </div>
                                    <div class="col-md-6">
    <label for="deg_id">Designation:</label>
    
    <select id="deg_id" name="deg_id" class="form-control" required <?php if ($role_id == 3) { ?>disabled<?php } ?>>
        <option value="">Select Designation</option>
        <?php foreach($designations as $designation): ?>
           
            <option value="<?php echo $designation->deg_id; ?>" <?=($employee_details->deg_id == $designation->deg_id)?'selected':'';?>>
                <?php echo $designation->name; ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>



                                        
                                </div>
                                <div class="row mb-3">

                                    <div class="col-md-3">
                                        <label for="document">Document:</label><br>
                                        <input type="file" id="document" name="document">
                                        <?php if (isset($employee_details->document) && !empty($employee_details->document)): ?>
                                            <a href="<?php echo base_url('assets/uploads/documents/' . $employee_details->document); ?>"
                                                alt="Document" class="preview-image" target="_blank">View</a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <br><button class="col-md-4" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php else: ?>

                    <?php endif; ?>
                </div>
            </main>

            <?php include APPPATH . 'views/include/footer.php'; ?>
        </div>
    </div>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile-image-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

// contact number error 10 digit only
        document.getElementById('contact_number').addEventListener('input', function (e) {
            var input = e.target;
            var errorElement = document.getElementById('contact_number_error');
            var regex = /^[0-9]{10}$/;

            // Remove any non-digit characters
            input.value = input.value.replace(/\D/g, '');

            if (input.value.length === 10 && regex.test(input.value)) {
                errorElement.textContent = '';
                input.setCustomValidity('');
            } else {
                errorElement.textContent = 'Please enter exactly 10 digits';
                input.setCustomValidity('Invalid phone number');
            }
        });

        // Form submission validation
        document.querySelector('form').addEventListener('submit', function (e) {
            var contactNumber = document.getElementById('contact_number');
            if (contactNumber.value.length !== 10) {
                e.preventDefault();
                document.getElementById('contact_number_error').textContent = 'Please enter exactly 10 digits';
            }
        });


// profile Image
        function openModal(src) {
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("modalImage");
    modal.style.display = "block";
    modalImg.src = src;
}

function closeModal() {
    var modal = document.getElementById("imageModal");
    modal.style.display = "none";
}

// Close the modal when clicking outside the image
window.onclick = function(event) {
    var modal = document.getElementById("imageModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

    </script>
</body>

</html>