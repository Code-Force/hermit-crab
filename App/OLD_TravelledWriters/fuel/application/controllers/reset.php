<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reset extends Auth_Controller {

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
        // This page is limited to non logged in members. Check and redirect if logged in
        if ($this->bloggers_model->check_logged()) {

            redirect('discover', 'refresh');
        } else {
            if (!empty($_POST))
            {
                // put your processing code here... we show what we do for emailing. You will need to add a correct email address
                if ($this->_process($_POST))
                {

                }
            } else {
                redirect('/', 'refresh');
            }
        }
    }

    // Validating the user's reset link
    function validation() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        // Pull the validation link
        $validation = $this->uri->segment(3);
        if (strlen($validation) == 40) {

            // Setup the variables for checking the validation link
            $validation_this = array($validation, "activation");
            $check_this = array($validation_this);

            // Check for the existing user in the database. If this code exists, display the reset form.
            // The user will still have to provide the proper email address for resetting.
            $reset_link = $this->bloggers_model->check_exist($check_this);
            if ($reset_link === false) {

                $vars['errors'] =  "<p>That activation code is invalid</p>";

            } else {
                if (!empty($_POST))
                {
                    // put your processing code here... we show what we do for emailing. You will need to add a correct email address
                    if ($this->_process($_POST))
                    {

                    }
                }
            }
        } else {

            // Display the errors from the model
            $vars['errors'] =  "<p>That activation code is invalid</p>";
        }
        $page_init = array('location' => 'reset');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $vars['activation_code'] = $validation;
        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }

    function _process() {

        // field name, error message, validation rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('confpassword', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_rules('activation_code', 'Reset Code', 'required');


        if ($this->form_validation->run() == FALSE) {

        } else {

            // Set variables for resetting the password
            $form_email = $this->input->post('email');
            $form_activation_code = $this->input->post('activation_code');
            $form_password = $this->input->post('password');
            $form_confpassword = $this->input->post('confpassword');

            $password_reset = $this->bloggers_model->reset_password($form_email, $form_activation_code, $form_password, $form_confpassword);

            if ($password_reset === true) {

                $vars['success'] =  "reset_password";
            } else {

                $vars['errors'] =  $password_reset;
            }
        }

        $page_init = array('location' => 'reset');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $vars['activation_code'] = $this->input->post('activation_code');
        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }

}

?>