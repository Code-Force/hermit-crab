<?php
class Notifications extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');

    }
    
    function index() {
        $vars = array();
        // use Fuel_page to render so it will grab all opt-in variables and do any necessary parsing
        $page_init = array('location' => 'notifications');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        //if ($this->session->userdata('logged_in')){
        if ($this->bloggers_model->check_logged()) {
            $vars['user_logged'] = TRUE;
            $vars['user'] = $this->bloggers_model->get_user($this->session->userdata['username']);

            //redirect('/');
        } else {
            $vars['user_logged'] = FALSE;
            redirect('discover');

        }

        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }
}
