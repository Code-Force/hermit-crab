<?php
class Connectgoogleplus extends Auth_Controller {

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


        if (!empty($_POST))
        {
            // put your processing code here... we show what we do for emailing. You will need to add a correct email address
            if ($this->_process($_POST))
            {

            }
        }



    }
    function _process() {
        $activation = sha1($this->input->post('email') . rand());
        $password = rand(100000, 999999);

        if ($this->bloggers_model->check_logged()) {

            $gotosettings = true;
            $data = array(
                'google_id' => $this->input->post('google_id'),
                'google_link' => $this->input->post('google_link')
            );
        } else {
            $data = array(
                'username' => str_replace(' ', '', $this->input->post('username')),
                'email' => $this->input->post('email'),
                'activation' => $activation,
                'fullname' => $this->input->post('fullname'),
                'password' => $password,
                'nationality' => '',
                'activated' => '1',
                'website_link' => '',
                'facebook_id' => '',
                'facebook_link' => '',
                'twitter_id' => '',
                'twitter_link' => '',
                'google_id' => $this->input->post('google_id'),
                'google_link' => $this->input->post('google_link')
            );
        }

        $connect_me = $this->bloggers_model->check_connect_social($data, 'google');

        if (!array($connect_me)) {
            redirect('signup/errorgoogle', 'redirect');
        } else {

            if (isset($gotosettings)) {
                echo 'settings';
            } else {

                if ($connect_me['method'] == 'add_connect') {

                    // Setup all of the fields for the email template to be sent.
                    // Email variables are stored in nested arrays and parsed in the "basics.php" controller to the email template files
                    $email_variables = array(array('username', $connect_me['username']), array('password', $password), array('social', 'Google'), array('settings', base_url().'settings'));
                    $email_template = 'socialconnect';
                    $to = $this->input->post('email');
                    $title = 'Google Connected!';

                    $this->send_my_emails($email_variables, $email_template, $to, $title);
                } elseif ($connect_me['method'] == 'account_exist_add_connect') {
                    // Setup all of the fields for the email template to be sent.
                    // Email variables are stored in nested arrays and parsed in the "basics.php" controller to the email template files
                    $email_variables = array(array('username', $connect_me['username']), array('social', 'Google'));
                    $email_template = 'socialadded';
                    $to = $this->input->post('email');
                    $title = 'Google Connected!';

                    $this->send_my_emails($email_variables, $email_template, $to, $title);
                }

                echo $connect_me['username'];

            }
        }
    }
}
