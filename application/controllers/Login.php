<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata'); // Set to India timezone

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Login_Model'); // Load the Auth_model
        $this->load->model('Attendance_model');
        $this->load->model('Employee_model');
        $this->load->library('form_validation'); // Load form validation library
    }



    // user login

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email ID', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $this->load->view('login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $uresult = $this->Login_Model->checkLogin($email, $password);

            if ($uresult) {
                // Store user data in session
                $this->session->set_userdata('user_id', $uresult->user_id);
                $this->session->set_userdata('username', $uresult->username);
                $this->session->set_userdata('email', $uresult->email);
                $this->session->set_userdata('role_id', $uresult->role_id);

                // Role-based redirection
                if ($uresult->role_id == 1) {
                    redirect(base_url('Dashboard'));
                } else if ($uresult->role_id == 2) {
                    redirect(base_url('Dashboard'));
                } else if ($uresult->role_id == 3) {
                    redirect(base_url('Dashboard'));
                } else {
                    // Default redirection if role doesn't match
                    redirect(base_url('Dashboard'));
                }
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Email ID and Password are Invalid!</div>');
                redirect('Login');
            }
        }
    }


    // user logout
    public function logout()
    {
        // Get user ID from session
        $user_id = $this->session->userdata('user_id');

        // Load User_model
        $this->load->model('User_model');

        // Update the update_at column in the users table
        if ($user_id) {
            $this->Login_Model->update_last_login($user_id);
        }

        // Destroy the session
        $this->session->sess_destroy();

        // Redirect to login page or home
        redirect('login'); // Ensure this matches your route configuration
    }



    public function changepassword()
    {
        $this->form_validation->set_rules('currentpassword', 'Current Password', 'required');
        $this->form_validation->set_rules('newpassword', 'New Password', 'required');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[newpassword]');
        if ($this
            ->form_validation->run())
        {
         $currentpassword=$this->input->post('currentpassword');  
         $newpassword=$this->input->post('newpassword');
         $user_id=$this->session->userdata('user_id');
         
         
         
         $currentpwd=$this->Login_Model->getcurrentpassword($user_id);
         $dbcurrentpwd=$currentpwd->password;
         
         
            if ($currentpassword == $dbcurrentpwd)
            {
             
             $this->Login_Model->updatepassword($user_id, $newpassword);
             $this->session->set_flashdata('success', 'Password changed successfully');
             redirect('login/changepassword');
            }
            else
            {
             $this->session->set_flashdata('error', 'Current Password is wrong');
             redirect('login/changepassword');
            }
         }
      else
      {
       $this->load->view('employee/changepassword');
      }
    }


}
