<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata'); // Set to India timezone

class Attendance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Ensure user is logged in
        if (!$this->session->userdata('user_id')) {
            redirect('Login');
        }

        // Load model here
        $this->load->model('Attendance_model');
        $this->load->model('User_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->load->helper('url_helper');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        // Retrieve attendance data for the current day
        $data['attendance'] = $this->Attendance_model->is_attadence_mark($user_id);


        // Load views with data
        $this->load->view('punch_attendance', $data);
    }

    // employee Punch your Attendance
    public function punch_attendance()
    {
        $action = $this->input->post('action');
        $user_id = $this->session->userdata('user_id');

        if ($action == 'punch_in') {
            $result = $this->Attendance_model->punch_in($user_id);
            if ($result === true) {
                $this->session->set_flashdata('success', 'Punched In successfully!');
            } elseif ($result === false) {
                $this->session->set_flashdata('error', 'You have already punched in or been marked absent today!');
            } else {
                $this->session->set_flashdata('error', 'You are outside the punch-in time window. You have been marked as absent.');
            }
        } elseif ($action == 'punch_out') {
            $result = $this->Attendance_model->punch_out($user_id);
            if ($result) {
                $this->session->set_flashdata('success', 'Punched Out successfully!');
            } else {
                $this->session->set_flashdata('error', 'Error in punching out or you have not punched in today!');
            }
        }
        redirect('attendance');
    }


    // Function to display the attendance form
    public function mark()
    {
        // Fetch all employees
        $data['employees'] = $this->Attendance_model->get_all_employees();

        // Load the view and pass the employee data
        $this->load->view('mark_attendance', $data);
    }


    // Admin mark attendance for employee
    public function submit_attendance()
    {
        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');
        $date = $this->input->post('date');
        $check_in = $this->input->post('check_in');
        $check_out = $this->input->post('check_out');

        // Ensure $user_id is a valid single value (not an array)
        if (empty($user_id)) {
            $this->session->set_flashdata('error', 'Please select an employee.');
            redirect('attendance/mark');
            return;
        }


        // Convert check_in and check_out to datetime format or set to null if empty
        $formatted_check_in = !empty($check_in) ? date('Y-m-d H:i:s', strtotime($check_in)) : null;
        $formatted_check_out = !empty($check_out) ? date('Y-m-d H:i:s', strtotime($check_out)) : null;
        // echo $user_id.$status.$date.$check_in.$check_out.$formatted_check_in.$formatted_check_out;
        // die();
        $attendance_data = array(
            'user_id' => $user_id,
            'date' => $date,
            'status' => $status,
            'check_in' => $formatted_check_in,
            'check_out' => $formatted_check_out

        );

        if ($this->Attendance_model->admin_mark_attendance($attendance_data)) {
            $this->session->set_flashdata('success', 'Attendance marked successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to mark attendance. Please try again.');
        }

        redirect('attendance/mark');
    }



    // attendance report page
    public function attendance_report()
    {
        $year = $this->input->post('year') ?? date('Y');
        $month = $this->input->post('month') ?? date('m');
        $show_only_present = $this->input->post('show_only_present') ?? false;
        $user_id = $this->input->post('user_id'); // New


        // Fetch all users for the dropdown
        $users_list = $this->User_model->get_all_users(); // Fetch all users, modify this to your method


        $data = $this->Attendance_model->get_users_with_attendance($year, $month, $show_only_present, $user_id);

        $data['show_only_present'] = $show_only_present;
        $data['user_id'] = $user_id;
        $data['users_list'] = $users_list; // Add users list to the data array
        $this->load->view('attendance_report', $data);
    }





}