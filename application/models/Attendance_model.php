<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // Load the database library
        $this->load->database();
    }

     // Function to fetch all employees jinka attendance mark nahi ha
     public function get_all_employees() {
        $today = date('Y-m-d');
        
        // Select employee details
        $this->db->select('u.user_id, u.username, u.role_id');
        $this->db->from('users u');
        
        // Left join with attendance table to check attendance status
        $this->db->join('attendance a', 'u.user_id = a.user_id AND DATE(a.check_in) = ' . $this->db->escape($today), 'left');
        
        // Filter to exclude employees who have marked attendance for today
        $this->db->where('a.user_id IS NULL');
        $this->db->where('u.role_id = 3');
        $this->db->where('u.status = 1');

        
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array(); // Return an empty array if no employees found
        }
    }
    

   
    // public function get_all_users()
    // { 
    //     $this->db->where('status = 1');
    //     $query = $this->db->get('users');
    //     return $query->result_array();
    // }
    

// attendance report page

public function get_users_with_attendance($year, $month, $show_only_present = false)
{
    $this->db->select('users.user_id, users.username, attendance.date, attendance.status, attendance.check_in, attendance.check_out');
    $this->db->from('users');
    $this->db->join('attendance', "users.user_id = attendance.user_id AND YEAR(attendance.date) = $year AND MONTH(attendance.date) = $month", 'left');
    $this->db->where('users.role_id = 3');
    if ($show_only_present) {
        $this->db->where('attendance.status IS NOT NULL');
    }
    
    $this->db->order_by('users.user_id, attendance.date');
    
    $query = $this->db->get();
    $results = $query->result_array();

    $users = array();
    $attendance_data = array();

    foreach ($results as $row) {
        if (!isset($users[$row['user_id']])) {
            $users[$row['user_id']] = array(
                'user_id' => $row['user_id'],
                'username' => $row['username']
            );
        }

        if ($row['date']) {
            $working_hours = 'N/A';
            if ($row['check_in'] && $row['check_out']) {
                $check_in = new DateTime($row['check_in']);
                $check_out = new DateTime($row['check_out']);
                $interval = $check_in->diff($check_out);
                $working_hours = $interval->format('%H:%I');
            }
            
            $attendance_data[$row['user_id']][date('Y-m-d', strtotime($row['date']))] = array(
                'status' => $row['status'],
                'working_hours' => $working_hours
            );
        }
    }

    return array(
        'users' => array_values($users),
        'attendance_data' => $attendance_data,
        'year' => $year,
        'month' => $month
    );
}

    

// admin mark the attendance for employee
    public function admin_mark_attendance($attendance_data) {
        // Ensure $attendance_data is an associative array
        if (is_array($attendance_data) && !empty($attendance_data)) {
            return $this->db->insert('attendance', $attendance_data);
        } else {
            // Handle the error: invalid data format
            return false;
        }
    }
    
    
// employee Punch in your Attendance

public function punch_in($user_id) {
    $today = date('Y-m-d');
    $current_time = date('H:i');
    $punch_in_start = '09:30';
    $punch_in_end = '10:30';

    // Check if already punched in today
    $this->db->where('user_id', $user_id);
    $this->db->where('DATE(date)', $today);
    $query = $this->db->get('attendance');

    if ($query->num_rows() > 0) {
        return false; // Already punched in or marked absent today
    }

    // Check if current time is within the punch-in window
    if ($current_time >= $punch_in_start && $current_time <= $punch_in_end) {
        // Punch In
        $data = array(
            'user_id' => $user_id,
            'date' => $today,
            'check_in' => date('Y-m-d H:i:s'),
            'status' => 'Present'
        );
        return $this->db->insert('attendance', $data);
    } else {
        // Mark as absent if outside punch-in window
        $data = array(
            'user_id' => $user_id,
            'date' => $today,
            'status' => 'Absent'
        );
        return $this->db->insert('attendance', $data);
    }
}

public function mark_absent_for_non_punch_in() {
    $today = date('Y-m-d');
    $punch_in_end = $today . ' 10:30:00';

    // Get all users who haven't punched in today
    $this->db->select('users.user_id');
    $this->db->from('users');
    $this->db->where("users.user_id NOT IN (SELECT user_id FROM attendance WHERE DATE(date) = '$today')");
    $query = $this->db->get();
    $users = $query->result_array();

    // Mark absent for users who haven't punched in
    foreach ($users as $user) {
        $data = array(
            'user_id' => $user['user_id'],
            'date' => $today,
            'status' => 'Absent'
        );
        $this->db->insert('attendance', $data);
    }
}


// employee Punch out your Attendance
public function punch_out($user_id) {
    // Check if user is currently punched in
    $today = date('Y-m-d');
    $this->db->where('user_id', $user_id);
    $this->db->where('DATE(check_in)', $today);  
    $query = $this->db->get('attendance');

    if ($query->num_rows() == 0) {
        return false; // Not punched in or already punched out
    }

    // Check if check_out is already filled
    $row = $query->row();
    if (!empty($row->check_out)) {
        return false; // Already punched out
    }

    // Punch Out
    $data = array(
        'check_out' => date('Y-m-d H:i:s')
        
    );
    $this->db->where('user_id', $user_id);
    $this->db->where('DATE(check_in)', $today);
    return $this->db->update('attendance', $data);
}

public function is_attadence_mark($user_id){
    $today = date('Y-m-d');
    $this->db->where('user_id', $user_id);
    $this->db->where('DATE(check_in)', $today);
    return $this->db->get('attendance')->row(); // Retrieve a single row
}



// public function get_attendance_status($user_id) {
//     $this->db->select('status, check_in, check_out');
//     $this->db->from('attendance');
//     $this->db->where('user_id', $user_id);
//     $this->db->where('date', date('Y-m-d'));
//     $query = $this->db->get();
//     return $query->row();
// }

    


}


