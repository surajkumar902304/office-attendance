<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Employee_model');
        $this->load->library('form_validation');
    }

    

    // Function to display the form to create an employee
    public function create() {
        $this->load->view('employee/create');
    }

    // Function to handle form submission and create the employee
    public function store() {
        // Form validation rules
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('date_of_joining', 'Date of Joining', 'required');
        $this->form_validation->set_rules('designation', 'Designation', 'required');

        if ($this->form_validation->run() === FALSE) {
            // If validation fails, reload the form with error messages
            $this->load->view('employee/create');
        } else {
            // Gather input data
            $data = array(
                'user_id' => $this->input->post('user_id'), // assuming user_id is coming from a hidden field or dropdown
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'contact_number' => $this->input->post('contact_number'),
                'address' => $this->input->post('address'),
                'date_of_joining' => $this->input->post('date_of_joining'),
                'designation' => $this->input->post('designation'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            // Insert data into the database
            $employee_id = $this->Employee_model->create_employee($data);

            if ($employee_id) {
                $this->session->set_flashdata('success', 'Employee created successfully.');
                redirect('employee/show/' . $employee_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to create employee.');
                $this->load->view('employee/create');
            }
        }
    }

    // Function to show the details of a specific employee
    public function show($employee_id) {
        $data['employee'] = $this->Employee_model->get_employee($employee_id);
        $this->load->view('employee/show', $data);
    }
}
