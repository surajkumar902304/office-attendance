<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_Model extends CI_Model
{
    public function checkLogin($email, $password)
{
    // Query the 'users' table and get the result count
    $this->db->where('email', $email);
    $this->db->where('password', $password);
    $this->db->where('status', 1); // Check if status is active
    $query = $this->db->get('users');
    
    if ($query->num_rows() > 0) {
        // User found, get the user data
        $user = $query->row();
        
        // Update the last login timestamp
        $data = array(
            'created_at' => date('Y-m-d H:i:s') // Current timestamp
        );
        
        // Update the 'updated_at' column for the found user
        $this->db->where('user_id', $user->user_id); // Assuming 'user_id' is the primary key
        $this->db->update('users', $data);
        
        return $user;
    }
    
    // Return NULL if no user is found
    return NULL;
}


    public function update_last_login($user_id) {
        $data = array(
            'updated_at' => date('Y-m-d H:i:s') // Current timestamp
        );
    
        // Update the update_at column for the specified user
        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);
    }

    public function getcurrentpassword($user_id)
        {
                $query = $this->db->where('user_id', $user_id)
                        ->get('users');

                if ($query->num_rows() > 0) {
                        return $query->row();
                }
        }


        // For updating Password
        public function updatepassword($user_id, $newpassword)
        {
                $data = array('password' => $newpassword);
                return $this->db->where(['user_id' => $user_id])
                        ->update('users', $data);
        }
}