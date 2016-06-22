<?php
class Connectfacebook extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');

    }
    
    function index() {
        $vars = array();

        // This page is limited to non logged in members. Check and redirect if logged in
        $fb_config = array(
            'appId'  => '243282025825120',
            'secret' => '72b045e4ed50ac5225d9b61386e283dc'
        );
        $this->load->library('facebook', $fb_config);

        $user = $this->facebook->getUser();
        if ($user) {
            try {
                $user_details = $this->facebook->api('/me');
            } catch (FacebookApiException $e) {
            }
        }

        $activation = sha1($user_details['email'] . rand());
        $password = rand(100000, 999999);

        if ($this->bloggers_model->check_logged()) {
            $gotosettings = true;

            $data = array(
                'facebook_id' => $user_details['id'],
                'facebook_link' => $user_details['link']
            );
        } else {
            $data = array(
                'username' => $user_details['username'],
                'email' => $user_details['email'],
                'activation' => $activation,
                'fullname' => $user_details['first_name'].' '.$user_details['last_name'],
                'password' => $password,
                'nationality' => '',
                'activated' => '1',
                'website_link' => '',
                'facebook_id' => $user_details['id'],
                'facebook_link' => $user_details['link'],
                'twitter_id' => '',
                'twitter_link' => '',
                'google_id' => '',
                'google_link' => ''
            );
        }
        $connect_me = $this->bloggers_model->check_connect_social($data, 'facebook');

        if (!array($connect_me)) {
            redirect('signup/errorfacebook', 'redirect');
        } else {

            if(isset($gotosettings)){
                redirect('settings', 'redirect');
            } else {
                if ($connect_me['method'] == 'add_connect') {

                    // Setup all of the fields for the email template to be sent.
                    // Email variables are stored in nested arrays and parsed in the "basics.php" controller to the email template files
                    $email_variables = array(array('username', $connect_me['username']), array('password', $password), array('social', 'Facebook'), array('settings', base_url().'settings'));
                    $email_template = 'socialconnect';
                    $to = $user_details['email'];
                    $title = 'Facebook Connected!';

                    $this->send_my_emails($email_variables, $email_template, $to, $title);
                } elseif ($connect_me['method'] == 'account_exist_add_connect') {
                    // Setup all of the fields for the email template to be sent.
                    // Email variables are stored in nested arrays and parsed in the "basics.php" controller to the email template files
                    $email_variables = array(array('username', $connect_me['username']), array('social', 'Facebook'));
                    $email_template = 'socialadded';
                    $to = $user_details['email'];
                    $title = 'Facebook Connected!';

                    $this->send_my_emails($email_variables, $email_template, $to, $title);
                }

                redirect($connect_me['username'], 'redirect');
            }
        }


    }
}
