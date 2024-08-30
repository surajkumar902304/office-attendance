<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Employee_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_all_users() {
        $query = $this->db->get('users');
        return $query->result_array();
    }

    public function get_employee_details($user_id) {
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('employee_details');
        return $query->row();
    }

    public function update_employee($user_id, $data) {
        $this->db->where('user_id', $user_id);
        $this->db->update('employee_details', $data);
    }


    public function get_profile_by_user_id($user_id) {
        $query = $this->db->get_where('employee_details', array('user_id' => $user_id));
        return $query->row();
    }

    // Function to fetch all active employees
    public function get_all_employees() {
        $this->db->select('user_id, first_name, last_name');
        $this->db->from('employees');
        $this->db->where('status', 1); // Assuming there's an 'is_active' column
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }


    // Get all designations
    public function get_all_designations() {

        return $this->db->get('designation')->result();
        // $this->db->select('designation.deg_id, designation.name, employee_details.user_id');
        // $this->db->from('designation');
        // $this->db->join('employee_details', 'employee_details.deg_id = designation.deg_id', 'left');
        // $this->db->order_by('designation.deg_id', 'ASC');
        // $query = $this->db->get();
        // return $query->result();
    }

    
}

