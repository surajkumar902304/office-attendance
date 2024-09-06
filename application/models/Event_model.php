<?php
class Event_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all events
    public function get_all_events($role_id) {
        if ($role_id == 1) {
            // Role ID 1: Fetch all events (past, current, and future)
            $query = $this->db->get('events');
        } else {
            // Role ID != 1: Fetch only current and future events
            $this->db->where('start >=', date('Y-m-d'));  // Fetch events with a date greater than or equal to today
            $query = $this->db->get('events');
        }
        
        return $query->result_array();
    }
    

    // Get event by ID
    public function get_event($id) {
        $query = $this->db->get_where('events', array('id' => $id));
        return $query->row_array();
    }

    // Insert new event
    public function insert_event($data) {
        return $this->db->insert('events', $data);
    }

    // Update event
    public function update_event($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('events', $data);
    }

    // Delete event
    public function delete_event($id) {
        return $this->db->delete('events', array('id' => $id));
    }
}
