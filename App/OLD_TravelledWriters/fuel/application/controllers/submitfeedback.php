<?php
class Submitfeedback extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
        $this->load->model('write_model');
        $this->load->library('form_builder');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    function index() {
        if ($this->bloggers_model->check_logged()) {

            $user = $this->bloggers_model->get_user($this->session->userdata['username']);

        } else {
            $user = false;
        }
        if ($user) {
            $follow = $this->bloggers_model->submit_feedback($user['fullname'], $user['email'],$this->input->post('feedback'), $user['blogger_id']);
        } else {
            $follow = $this->bloggers_model->submit_feedback($this->input->post('name'),$this->input->post('email'),$this->input->post('feedback'), 0);
        }

        echo $follow;


    }
}
