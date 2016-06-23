<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forgot extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
        $this->load->model('write_model');
        $this->load->library('form_builder');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

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
                $page_init = array('location' => 'forgot');
                $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );

                $this->fuel_page->add_variables( $vars );
                $this->fuel_page->render();
            }
        }
    }

    // Method for checking inputted info from forgotten password page and sending the reset link for their password.
    public function _process() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        if (isset($_POST['username']) && $_POST['username'] != '' && isset($_POST['email']) && $_POST['email'] != '') {
            // field name, error message, validation rules
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            if ($this->form_validation->run() == FALSE) {

            } else {

                // Setup the variables to be checked against the database
                $username = array($this->input->post('username'), "username");
                $email = array($this->input->post('email'), "email");
                $check_this = array($username, $email);

                // Check to see if the user's inputted information exists in one record and return the validation link for password reset
                $reset_link = $this->bloggers_model->check_exist($check_this);

                if ($reset_link === false) {

                    // Display errors from the model
                    $vars['errors'] =  "<p>That username and email do not match. Please try again</p>";
                } else {

                    // Link for resetting
                    $reset_link = base_url() . 'reset/validation/' . $reset_link;

                    // Setup all of the fields for the email template to be sent.
                    // Email variables are stored in nested arrays and parsed in the "basics.php" controller to the email template files
                    $email_variables = array(array('username', $this->input->post('username')), array('reset_link', $reset_link));
                    $email_template = 'reset';
                    $to = $this->input->post('email');
                    $title = 'Reset your password';

                    $this->send_my_emails($email_variables, $email_template, $to, $title);

                    $vars['success'] = 'reset_password';
                }
            }
        } elseif (isset($_POST['email']) && $_POST['email'] != '') {
            // field name, error message, validation rules
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            if ($this->form_validation->run() == FALSE) {

            } else {
                $email = $this->input->post('email');

                // check to see if the user's inputted information exists in one record and return the validation link for password reset
                $username = $this->bloggers_model->get_username($email);

                if ($username === false) {

                    $vars['errors'] = "<p>That email address is not in our system</p>";

                } else {

                    $email_variables = array(array('username', $username));
                    $email_template = 'username';
                    $to = $this->input->post('email');
                    $title = 'Retrieve your username';

                    $this->send_my_emails($email_variables, $email_template, $to, $title);

                    $vars['success'] = 'resend_username';
                }
            }
        } else {
            $vars['errors'] = "<p>Please fill out the form</p>";

        }
        $page_init = array('location' => 'forgot');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );

        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }
}

?>