<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Resend extends Auth_Controller {

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
        // This page is limited to non logged in members. Check and redirect if logged in
        if ($this->bloggers_model->check_logged()) {

            redirect('discover', 'refresh');
        } else {
            $username = $this->session->userdata('temp_username');
            if ($this->session->userdata('temp_username') != ''){

                $check_username_resend = $this->bloggers_model->get_user($this->session->userdata['temp_username'], 'activation');

                if (is_array($check_username_resend) && !empty($check_username_resend)) {

                    // Link for activation.
                    $activation_link = base_url() . 'activate/validation/' . $check_username_resend['activation'];
                    $this->session->set_userdata(array('temp_username' => $check_username_resend['activation']));

                    // Setup all of the fields for the email template to be sent.
                    // Email variables are stored in nested arrays and parsed in the "basics.php" controller to the email template files
                    $email_variables = array(array('username', $check_username_resend['username']), array('activation', $activation_link));
                    $email_template = 'registered';
                    $to = $check_username_resend['email'];
                    $title = 'Registered with Travelled Writers!';

                    $this->send_my_emails($email_variables, $email_template, $to, $title);

                    $vars['resent'] = true;
                }
            }
            $page_init = array('location' => 'resend');
            $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
            $this->fuel_page->add_variables($vars);
            $this->fuel_page->render();
        }
    }


}

?>