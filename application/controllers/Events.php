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

    private function check_admin_access() {
        if ($this->session->userdata('role_id') != 1) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['success' => false, 'message' => 'Access denied']);
                exit;
            } else {
                show_error('Access denied', 403);
            }
        }
    }

    public function index() {
        $role_id = $this->session->userdata('role_id');
        $data['events'] = $this->Event_model->get_all_events($role_id);
        $this->load->view('events/events_view', $data);
    }

    public function add() {
        $this->check_admin_access();
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
        $this->check_admin_access();
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
        $this->check_admin_access();
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


}