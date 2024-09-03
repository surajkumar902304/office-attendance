<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user_id')) {
            redirect('Login');
        }
        $this->load->model('Event_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['events'] = $this->Event_model->get_all_events();
        $this->load->view('events/events_view', $data);
    }

    public function add() {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('events/add_event_view');
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'start' => $this->input->post('date'),
            );
            $result = $this->Event_model->insert_event($data);
            if ($result) {
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['success' => true]);
                } else {
                    redirect('events');
                }
            } else {
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['success' => false, 'message' => 'Failed to add event']);
                } else {
                    $this->session->set_flashdata('error', 'Failed to add event');
                    redirect('events/add');
                }
            }
        }
    }

    public function edit($id) {
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');

        if ($this->form_validation->run() === FALSE) {
            $data['event'] = $this->Event_model->get_event($id);
            $this->load->view('events/edit_event_view', $data);
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'start' => $this->input->post('date'),
            );
            $result = $this->Event_model->update_event($id, $data);
            if ($result) {
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['success' => true]);
                } else {
                    redirect('events');
                }
            } else {
                if ($this->input->is_ajax_request()) {
                    echo json_encode(['success' => false, 'message' => 'Failed to update event']);
                } else {
                    $this->session->set_flashdata('error', 'Failed to update event');
                    redirect('events/edit/' . $id);
                }
            }
        }
    }

    public function delete($id) {
        $result = $this->Event_model->delete_event($id);
        if ($result) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => true]);
            } else {
                redirect('events');
            }
        } else {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Failed to delete event']);
            } else {
                $this->session->set_flashdata('error', 'Failed to delete event');
                redirect('events');
            }
        }
    }

    public function get_events() {
        $events = $this->Event_model->get_all_events();
        echo json_encode($events);
    }
}