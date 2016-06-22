<?php
class Signup extends Auth_Controller {

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
        $vars['page_title'] = 'Sign up to Travelled Writers';
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        if ($this->bloggers_model->check_logged()) {
            $vars['user_logged'] = TRUE;
            redirect('discover');
        } else {
            $vars['user_logged'] = FALSE;
        }


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
                $vars['countries'] = $this->write_model->get_countries();

                $page_init = array('location' => 'signup');
                $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
                $this->fuel_page->add_variables($vars);
                $this->fuel_page->render();
            }
        }

    }

    // Registration method
    public function _process() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        $vars['page_title'] = 'Sign up to Travelled Writers';

        // field name, error message, validation rules
        $this->form_validation->set_rules('fullname', 'Full name', 'trim|required|min_length[4]|xss_clean|regex_match[/^[A-Za-z\s]+$/]');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|xss_clean|alpha_numeric');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]|xss_clean');
        $this->form_validation->set_rules('nationality', 'Nationality', 'min_length[2]|max_length[2]|xss_clean');

        $this->form_validation->set_message('regex_match', 'Your %s must be only letters');


        if ($this->form_validation->run() == FALSE) {

        } else {

            // Set the user's activation code used for account activation and password resetting purposes
            $activation = sha1($this->input->post('email') . rand());

            $user_details = array(
                'username' => $this->input->post('username'),
                'activation' => $activation,
                'email' => $this->input->post('email'),
                'fullname' => $this->input->post('fullname'),
                'password' => $this->input->post('password'),
                'nationality' => $this->input->post('nationality'),
                'activated' => '0',
                'website_link' => '',
                'facebook_id' => '',
                'facebook_link' => '',
                'twitter_id' => '',
                'twitter_link' => '',
                'google_id' => '',
                'google_link' => ''
            );


            $user_registered = $this->bloggers_model->add_user($user_details);

            // If all of the information has been supplied successfully, setup email template and send activation link
            if ($user_registered === true) {

                $this->session->set_userdata(array('temp_username' => $activation));

                // Link for activation.
                $activation_link = base_url() . 'activate/validation/' . $activation;

                // Setup all of the fields for the email template to be sent.
                // Email variables are stored in nested arrays and parsed in the "basics.php" controller to the email template files
                $email_variables = array(array('username', $this->input->post('username')), array('activation', $activation_link));
                $email_template = 'registered';
                $to = $this->input->post('email');
                $title = 'Registered with Travelled Writers!';

                $this->send_my_emails($email_variables, $email_template, $to, $title);

                $vars['errors'] = $user_registered;
                $vars['registered'] = true;

            } else {

                // Display errors from the model
                $vars['errors'] = $user_registered;
                $vars['registered'] = false;
            }
        }
        $page_init = array('location' => 'signup');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables($vars);
        $this->fuel_page->render();
    }
    function errorgoogle() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        $page_init = array('location' => 'errorgoogle');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables($vars);
        $this->fuel_page->render();
    }
    function errorfacebook() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        $page_init = array('location' => 'errorfacebook');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables($vars);
        $this->fuel_page->render();
    }
    function errortwitter() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        $page_init = array('location' => 'errortwitter');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables($vars);
        $this->fuel_page->render();
    }
    function twitter () {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        if (!empty($_POST))
        {

            // field name, error message, validation rules
            $this->form_validation->set_rules('fullname', 'full name', 'trim|required|min_length[4]|xss_clean|regex_match[/^[A-Za-z\s]+$/]');
            $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[4]|xss_clean|alpha_numeric');
            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|max_length[32]');

            $this->form_validation->set_message('regex_match', 'Your %s must be only letters');

            $vars['twitter_id'] = $this->input->post('twitter_id');
            $vars['username'] = $this->input->post('username');
            $vars['twitter_link'] = $this->input->post('twitter_link');
            $vars['fullname'] = $this->input->post('fullname');
            $vars['email'] = $this->input->post('email');
            $vars['password'] = $this->input->post('password');

            if ($this->form_validation->run() == FALSE) {

            } else {

                // Set the user's activation code used for account activation and password resetting purposes
                $activation = sha1($this->input->post('email') . rand());

                $user_details = array(
                    'username' => $this->input->post('username'),
                    'activation' => $activation,
                    'email' => $this->input->post('email'),
                    'fullname' => $this->input->post('fullname'),
                    'password' => $this->input->post('password'),
                    'nationality' => $this->input->post('nationality'),
                    'activated' => 0,
                    'website_link' => '',
                    'facebook_id' => '',
                    'facebook_link' => '',
                    'twitter_id' => $this->input->post('twitter_id'),
                    'twitter_link' => $this->input->post('twitter_link'),
                    'google_id' => '',
                    'google_link' => ''
                );


                $user_registered = $this->bloggers_model->add_user($user_details);

                // If all of the information has been supplied successfully, setup email template and send activation link
                if ($user_registered === true) {

                    // Link for activation.
                    $activation_link = base_url() . 'activate/validation/' . $activation;

                    // Setup all of the fields for the email template to be sent.
                    // Email variables are stored in nested arrays and parsed in the "basics.php" controller to the email template files
                    $email_variables = array(array('username', $this->input->post('username')), array('activation', $activation_link));
                    $email_template = 'registered';
                    $to = $this->input->post('email');
                    $title = 'Registered with Travelled Writers!';

                    $this->send_my_emails($email_variables, $email_template, $to, $title);

                    $vars['errors'] = $user_registered;
                    $vars['registered'] = true;

                } else {

                    // Display errors from the model
                    $vars['errors'] = $user_registered;
                    $vars['registered'] = false;
                }

            }
        } else {

            $vars['twitter_id'] = $this->session->userdata('twitter_id');
            $vars['username'] = $this->session->userdata('username');
            $vars['twitter_link'] = $this->session->userdata('twitter_link');
            $vars['fullname'] = $this->session->userdata('fullname');
            $vars['email'] = '';
            $vars['password'] = '';

            if(isset($vars['twitter_id']) && $vars['twitter_id'] != '') //check whether user already logged in with twitter
            {

                $registered_already = $this->bloggers_model->check_exist($vars['twitter_id'], 'twitter_id');
                if ($registered_already === true) {

                    $logged_in  = $this->bloggers_model->check_logged();

                    if ($logged_in) {

                        $data = array(
                            'username' => $this->session->userdata('username'),
                            'email' => $this->session->userdata('user_email'),
                            'twitter_id' => $this->session->userdata('twitter_id'),
                            'twitter_link' => $this->session->userdata('twitter_link')
                        );
                        $connect_me = $this->bloggers_model->check_connect_social($data, 'twitter');

                        if (!array($connect_me)) {
                            redirect('signup/errorfacebook', 'redirect');
                        } else {
                            redirect('settings', 'redirect');
                        }
                    } else {

                    }
                } else {


                    $user_details = array(
                        'twitter_id' => $vars['twitter_id'],
                        'twitter_link' => $vars['twitter_link']
                    );

                    $connect_me = $this->bloggers_model->check_connect_social($user_details, 'twitter');

                    redirect('/'.$connect_me['username'], 'redirect');
                }

            } else {

                redirect('/signup', 'redirect');

            }
        }
        $page_init = array('location' => 'signuptwitter');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables($vars);
        $this->fuel_page->render();

    }
}

?>