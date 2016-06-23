<?php
class Home extends CI_Controller {

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
        $vars['page_title'] = 'Travelled Writers welcomes you!';
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        // use Fuel_page to render so it will grab all opt-in variables and do any necessary parsing
        $page_init = array('location' => 'home');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );

        if ($this->bloggers_model->check_logged()) {
            $vars['user_logged'] = TRUE;
            redirect('discover');
        } else {
            $vars['user_logged'] = FALSE;
            $vars['body_class'] = 'splash';
        }

        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }
}
