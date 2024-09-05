<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        // Load the database library
        $this->load->database();
    }

    // Function to insert user data into the users table
    public function insert_user($data)
    {
        $this->db->insert('users', $data);
        // Return the ID of the newly inserted user
        return $this->db->insert_id();
    }

    // Function to insert employee details into the employee_details table
    public function insert_employee_details($data)
    {
        return $this->db->insert('employee_details', $data);
    }

    // Fetch all roles from the roles table
    public function get_roles()
    {
        $query = $this->db->get('roles');
        return $query->result_array();
    }


    // // Fetch all users from the users table
    public function get_all_users()
    {
        // Select fields from users table and join with roles table
        $this->db->select('users.*, roles.role_name');
        $this->db->from('users');
        $this->db->join('roles', 'roles.role_id = users.role_id', 'left'); // Perform a left join on role_id
        $this->db->where('users.role_id !=', 1); 
        
        $query = $this->db->get();
        return $query->result_array(); // Return as an associative array
    }



    public function get_user_by_id($id)
    {
        $this->db->where('user_id', $id);
        $query = $this->db->get('users');
        return $query->row_array(); // Return a single user
    }

    public function update_user($id, $data)
    {
        // Update the user data in the database
        $this->db->where('user_id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($user_id, $data)
    {
        $this->db->where('user_id', $user_id);
        return $this->db->update('users', $data); // Assuming your table name is 'users'
    }


    public function get_user_role($user_id)
    {
        $this->db->select('role_id');
        $this->db->from('users');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result ? $result->role_id : null;
    }

    public function get_user_details($user_id)
    {
        $this->db->select('first_name, last_name');
        $this->db->from('employee_details'); // Replace 'users' with your actual table name
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row(); // Return a single row of data
        } else {
            return null; // No user found
        }
    }


    public function email_exists($email)
    {
        $this->db->select('email');
        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true; // Email exists
        } else {
            return false; // Email does not exist
        }
    }


}
