<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employeeupdate extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Ensure user is logged in
        if (!$this->session->userdata('user_id')) {
            redirect('Login');
        }

        // Get the user's role_id from session
    $role_id = $this->session->userdata('role_id');
    
    // Check if the user has role_id 1 (Admin) or 3 (Employee)
    if ($role_id != 1 && $role_id != 3) {
        show_error('You do not have permission to access this page.', 403);
    }

        // Load model here
        $this->load->model('User_model');
        $this->load->model('Employee_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        
        $this->load->helper('url_helper');
    }

    

    public function select_user() {
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('user_id');
        
        if ($role_id == 1) {
            // Role ID 1: Admin or similar
            $user_id = $this->input->post('user_id');
            if ($user_id) {
                $data['selected_user_id'] = $user_id;
                $data['employee_details'] = $this->Employee_model->get_employee_details($user_id);
                $data['designations'] = $this->Employee_model->get_all_designations();
                
            }
            $data['users'] = $this->User_model->get_all_users();
        } elseif ($role_id == 3) {
            // Role ID 3: Employee
            $employee_details = $this->Employee_model->get_employee_details($user_id);
            $data['employee_details'] = $employee_details;
            $data['selected_user_id'] = $user_id; // Pass the user_id for hidden input in the form
            $data['designations'] = $this->Employee_model->get_all_designations();
        } else {
            // Handle cases where the role is neither 1 nor 3
            show_error('You do not have permission to access this page.', 403);
        }
        
        // Load the view
        $this->load->view('employee/employee_profile', $data);
    }
    
    

    public function update_employee() {
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->input->post('user_id');
        if ($role_id == 1) {
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'contact_number' => $this->input->post('contact_number'),
                'dob' => $this->input->post('dob'),
                'address' => $this->input->post('address'),
                'date_of_joining' => $this->input->post('date_of_joining'),
                'deg_id' => $this->input->post('deg_id'),
                'salary' => $this->input->post('salary')
            );
        }else{
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'contact_number' => $this->input->post('contact_number'),
                'dob' => $this->input->post('dob'),
                'address' => $this->input->post('address')
            );
        }
        
    
        // Get current employee details
        $current_employee = $this->Employee_model->get_employee_details($user_id);
    
        // Handle profile image upload
        if ($_FILES['profile_image']['name']) {
            $config['upload_path'] = './assets/uploads/profile_picture/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 2000;
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('profile_image')) {
                // Delete old image if exists
                if ($current_employee->profile_image && file_exists($config['upload_path'] . $current_employee->profile_image)) {
                    unlink($config['upload_path'] . $current_employee->profile_image);
                }
                $data['profile_image'] = $this->upload->data('file_name');
            }
        } else {
            // Keep old image if no new image is uploaded
            $data['profile_image'] = $current_employee->profile_image;
        }
    
        // Handle document upload
        if ($_FILES['document']['name']) {
            $config['upload_path'] = './assets/uploads/documents/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size'] = 2000;
            $this->upload->initialize($config);
    
            if ($this->upload->do_upload('document')) {
                // Delete old document if exists
                if ($current_employee->document && file_exists($config['upload_path'] . $current_employee->document)) {
                    unlink($config['upload_path'] . $current_employee->document);
                }
                $data['document'] = $this->upload->data('file_name');
            }
        } else {
            // Keep old document if no new document is uploaded
            $data['document'] = $current_employee->document;
        }
    
        $this->Employee_model->update_employee($user_id, $data);
        redirect('Employeeupdate/select_user');
    }

    
}
