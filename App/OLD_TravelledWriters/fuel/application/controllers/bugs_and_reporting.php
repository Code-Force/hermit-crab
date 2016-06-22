<?php
class Bugs_and_reporting extends Auth_Controller {

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
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        // use Fuel_page to render so it will grab all opt-in variables and do any necessary parsing
        $page_init = array('location' => 'bugs_and_reporting');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        //if ($this->session->userdata('logged_in')){
        if ($this->bloggers_model->check_logged()) {
            $vars['user_logged'] = TRUE;
            $vars['user'] = $this->bloggers_model->get_user($this->session->userdata['username']);


            //redirect('/');
        } else {
            $vars['user_logged'] = FALSE;

        }
        $vars['page_title'] =  'Bugs &amp; Reporting';

        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }
}
