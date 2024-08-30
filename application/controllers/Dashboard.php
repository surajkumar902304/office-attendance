<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct(){
        parent::__construct();
         if(!$this->session->userdata('user_id'))
        redirect('Login');
        $this->load->model('User_model'); // Ensure this line is present
        $this->load->library('session');
     }
     public function index() {
        $user_id = $this->session->userdata('user_id'); // Adjust as needed
        // Fetch user details from the database
        $data['employee_details'] = $this->User_model->get_user_details($user_id);
        $data['role_id'] = $this->User_model->get_user_role($user_id);
        $this->load->view('dashboard', $data);
    }
}