<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
    public function mark_absent() {
        $this->load->model('Attendance_model');
        $this->Attendance_model->mark_absent_for_non_punch_in();
        echo "Absent marking process completed.";
    }
}