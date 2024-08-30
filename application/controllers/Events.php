<?php
class Events extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Event_model');
    }

    // Display the calendar with events
    public function index() {
        $this->load->model('Event_model');
        $data['events'] = $this->Event_model->get_all_events();
        $this->load->view('events/events_view', $data);
    }

    // Add a new event
    public function add() {
        $this->load->helper('url');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('events/add_event_view');
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'date' => $this->input->post('date'),
            );
            $this->Event_model->insert_event($data);
            redirect('events');
        }
    }

    // Edit an existing event
    public function edit($id) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('start', 'start', 'required');

        $data['events'] = $this->Event_model->get_event($id);

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('events/edit_event_view', $data);
        } else {
            $update_data = array(
                'title' => $this->input->post('title'),
                'start' => $this->input->post('start'),
            );
            $this->Event_model->update_event($id, $update_data);
            redirect('events');
        }
    }

    // Delete an event
    public function delete($id) {
        $this->Event_model->delete_event($id);
        redirect('events');
    }
}
