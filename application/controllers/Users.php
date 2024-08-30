<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Ensure user is logged in
        if (!$this->session->userdata('user_id')) {
            redirect('Login');
        }

        // Ensure the user has an Admin role (role_id = 1)
        if ($this->session->userdata('role_id') != 1) {
            show_error('You do not have permission to access this page.', 403);
        }

        // Load model here
        $this->load->model('User_model');
        $this->load->model('Employee_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        
        $this->load->helper('url_helper');
    }

    // Controller: Users.php

public function get_user() {
    

    // Fetch all users from the model
    $data['users'] = $this->User_model->get_all_users();

    // Load the view with users data
    $this->load->view('user/user_records', $data);
}


public function createuser()
{
    // Fetch roles from the database
    $roles = $this->User_model->get_roles();

    // Define the array for statuses
    $statuses = array(
        1 => 'Active',
        0 => 'Inactive'
    );

    // Check if form is submitted
    if ($this->input->server('REQUEST_METHOD') === 'POST') {
        // Check if the email already exists
        $email = $this->input->post('email');
        if ($this->User_model->email_exists($email)) {
            
            // Set an error message in the session and reload the form
            $this->session->set_flashdata('message', 'Email already exists. Please use a different email.');
            redirect('Users/createuser');
        } else {
            // Start transaction
            $this->db->trans_begin();

            // Get form data for the user
            $userData = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'email' => $email,
                'role_id' => $this->input->post('role_id'),
                'status' => $this->input->post('status'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            // Insert user data into the users table
            $user_id = $this->User_model->insert_user($userData);

            if ($user_id) {
                // Insert a blank record into employee_details with the user_id
                $employeeData = array(
                    'user_id' => $user_id
                );

                if ($this->User_model->insert_employee_details($employeeData)) {
                    // Commit transaction
                    $this->db->trans_commit();
                    // Set a success message in the session and redirect
                    $this->session->set_flashdata('message', 'User created successfully.');
                    redirect('Users/createuser');
                } else {
                    // Rollback transaction if employee details insertion fails
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', 'Failed to initialize employee details.');
                }
            } else {
                // Rollback transaction if user creation fails
                $this->db->trans_rollback();
                $this->session->set_flashdata('message', 'Failed to create user.');
            }
        }
    }

    // Pass the arrays to the view
    $data['roles'] = $roles;
    $data['statuses'] = $statuses;

    // Load the view with the data
    $this->load->view('user/create', $data);
}



    // edit user
    public function edit($id) {
        // Load user data for editing
        $data['users'] = $this->User_model->get_user_by_id($id);
        if (!$data['users']) {
            show_404();
        }
        
        // Load roles
        $data['roles'] = $this->User_model->get_roles();
        
        // Load the edit view
        $this->load->view('user/edit', $data);
    }
    
    public function update($id) {
       
        
        // Check if the form is submitted
        if ($this->input->post()) {
            // Validate form input
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('role_id', 'Role', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
    
            if ($this->form_validation->run() == TRUE) {
                // Prepare data for update
                $data = array(
                    'username' => $this->input->post('username'),
                    'email'    => $this->input->post('email'),
                    'role_id'  => $this->input->post('role_id'),
                    'status'   => $this->input->post('status')
                );
    
                // Update the user data
                $update = $this->User_model->update_user($id, $data);
    
                if ($update) {
                    $this->session->set_flashdata('success', 'User updated successfully.');
                    redirect('users/get_user'); // Redirect to the users list page or any other page
                } else {
                    $this->session->set_flashdata('error', 'Failed to update user.');
                }
            }
        }
        
        
    }
    
    
    
    
    // delete function
    public function delete($user_id) {
        // Update the user's status to 0 (inactive) instead of deleting the record
        $data = array(
        'status' => 0
        );
        // Perform delete operation
        $this->User_model->delete_user($user_id, $data);
        $this->session->set_flashdata('success', 'User marked as inactive successfully.');
        redirect('users/get_user');
    }

    // restore function
    public function restore($user_id) {
        // Update the user's status to 1 (active)
        $data = array(
            'status' => 1
        );
        // Perform restore operation
        $this->User_model->delete_user($user_id, $data);
        $this->session->set_flashdata('success', 'User restored successfully.');
        redirect('users/get_user');
    }


    public function index() {
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('employee_details', $data);
    }
}
