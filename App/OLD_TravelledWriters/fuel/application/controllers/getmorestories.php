<?php
class Getmorestories extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
        $this->load->model('write_model');
        $this->load->library('form_builder');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    function index() {

        $filters = explode(',', $this->input->post('filters'));
        if ($this->input->post('blogger_id') > 0){
            $blogger_id = $this->input->post('blogger_id');
        } else {
            $blogger_id = 0;
        }
        if ($this->bloggers_model->check_logged()) {
            $user = $this->bloggers_model->get_user($this->session->userdata['username']);
        } else {
            $user = array();;
        }
        if ($this->input->post('last_story') > 0) {
            $filters[] = 'last_story:'.$this->input->post('last_story');
        }
        $stories = $this->write_model->get_stories($blogger_id,0,15,$filters, $user);

        if (is_array($stories) && !empty($stories)){




            echo $this->display_stories($stories);
        } else {
            echo $stories;
        }
    }
}
