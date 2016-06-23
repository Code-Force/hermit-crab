<?php
class Like extends Auth_Controller {

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
            $blogger_id = $user['blogger_id'];

        } else {
            $blogger_id = 0;
        }

        $liked = $this->write_model->like_story($this->input->post('story_id'), $blogger_id, $_SERVER['REMOTE_ADDR']);
        echo $liked;

    }
}
