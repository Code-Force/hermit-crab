<?php
class Disconnectsocial extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
        $this->load->model('write_model');
        $this->load->library('form_builder');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    function index() {
        $vars = array();

        //if ($this->session->userdata('logged_in')){
        if ($this->bloggers_model->check_logged()) {
            $vars['user_logged'] = TRUE;
            $vars['user'] = $this->bloggers_model->get_user($this->session->userdata['username']);
            $disconnect = $this->bloggers_model->disconnectsocial($_POST['action'], $vars['user']);
            if ($disconnect === true) {
                echo true;
            } else {
                echo false;
            }
            //redirect('/');
        } else {
            redirect('signup', 'redirect');
        }

    }
}
