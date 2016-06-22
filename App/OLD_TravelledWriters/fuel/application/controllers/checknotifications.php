<?php
class Checknotifications extends Auth_Controller {

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

            $follow = $this->bloggers_model->check_notifications($this->input->post('last'), $user['blogger_id']);

            echo $follow;

        } else {
            echo false;
        }

    }
}
