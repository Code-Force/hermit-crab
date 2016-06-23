<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Activate extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
        $this->load->model('write_model');
        $this->load->library('form_builder');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index() {

        // This page is limited to non logged in members. Check and redirect if logged in
        if ($this->bloggers_model->check_logged()) {
            redirect('discover', 'refresh');
        } else {

            // This page is also not inteded for viewing without the validation method and will redirect to homepage without it.
            redirect('/', 'refresh');
        }
    }

    // Validating the user's reset link
    function validation() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        // Pull the validation link
        $validation = $this->uri->segment(3);

        if (strlen($validation) == 40) {

            // Check for the existing user in the database. If this code exists, display the reset form.
            // The user will still have to provide the proper email address for resetting.
            $validate = $this->bloggers_model->activate_user($validation);
            if ($validate === true) {


                $vars['is_activated'] = "<p>Your account is now activated!</p>";
                $vars['activated'] = true;
            } else {
                if (array($validate)) {
                    redirect('/'.$validate['username'], 'redirect');
                } else {
                    $vars['is_activated'] = $validate;
                    $vars['activated'] = false;
                }


            }
            
            
        } else {
            $vars['activated'] = false;

            // Display the errors from the model
            $vars['is_activated'] = "<p>That activation code is invalid.</p>";
        }

        $page_init = array('location' => 'activate');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables($vars);
        $this->fuel_page->render();
    }

 

}

?>