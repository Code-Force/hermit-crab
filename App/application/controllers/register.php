<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends MY_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('users_model','',TRUE);

    }

    // Initial function of the index is to provide the user
    // with the ability to register an account with Travelled Writers.
    function index() {

        // INITIALISE //
        // Setup the user data for use in the views.
        // sessionSetup is in MY_Controller
        $data['user'] = $this->sessionSetup();

        // This page is protected from being viewed by logged in
        // users, so we need to redirect them to their account page
        if ($data['user']) {
            redirect('/account', 'refresh');
        }

        // SET DATA //
        // Setup the data for the views.
        $data['title'] = ucfirst('Register');
        // Load the user navigation that controls the logout, login, account, etc links.
        $data['header_snippets'] = $this->initializeHeaderHTML($data);

        // LOAD VIEWS //
        // Gotta load up the header and footer views as well as
        // the main page view.
        $this->load->view('templates/header_view', $data);
        $this->load->view('users/register_view');
        $this->load->view('templates/footer_view', $data);

    }

    // This function is where the login form from the login_view.php
    // file sends the user to validate the username and password entered.
    function verify ($ajax = 0) {

        // VALIDATION //
        // We need to validate the registration fields to make sure the values are set
        // and valid.
        $config = array(

            array(
                'field'   => 'password',
                'label'   => 'Password',
                'rules'   => 'trim|required|min_length[6]|matches[passconf]'
            ),
            array(
                'field'   => 'passconf',
                'label'   => 'Password Confirmation',
                'rules'   => 'trim|required'
            ),
            array(
                'field'   => 'email',
                'label'   => 'Email',
                'rules'   => 'trim|required|valid_email'
            ),
            array(
                'field'   => 'username',
                'label'   => 'Username',
                'rules'   => 'trim|required|min_length[5]|max_length[12]|callback_check_database'
            )
        );
        $this->form_validation->set_rules($config);

        // INITIALISE //
        // Setup the user data for use in the views.
        // sessionSetup is in MY_Controller
        $data['user'] = $this->sessionSetup();

        // We now need to run the validation and run the callbacks.
        // If we return 'false', we need to display the errors.
        // If we return 'true', we need to redirect to the account page.
        if (!$this->form_validation->run()) {

            // SET DATA //
            // Setup the data for the views.
            $data['title'] = ucfirst('Login');
            // Load the user navigation that controls the logout, login, account, etc links.
            $data['header_snippets'] = $this->initializeHeaderHTML($data);

            if ($ajax) {
                return $data['user'];
            } else {
                // LOAD VIEWS //
                // Field validation failed so we have to show the login form again.
                $this->load->view('templates/header_view', $data);
                $this->load->view('users/register_view');
                $this->load->view('templates/footer_view', $data);
            }


        } else {

            // A successful login will redirect to my account page.
            redirect('/account', 'refresh');

        }

    }

    // As a validation, we need to check the new user's username and email for its
    // existance in the database already
    function check_database($username) {

        // SET VARIABLES //
        // Since the username is being passed as the callback function variable,
        // we only need to set the email and password variable from the post data
        $newUser = array (
            'username' => $username,
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
        );

        // Set the result variable of the login check.
        // Will return array or false.
        $result = $this->users_model->register($newUser);

        // If false, provide validation error message.
        // Otherwise, proceed with registration process.
        if (is_array($result)) {

            // LOGIN USER //
            // Set the session with the logged in user's data
            $this->session->set_userdata('logged_in', $result);

            return true;

        } else {

            // Validation was no good :( ... tell them they are wrong!
            $this->form_validation->set_message('check_database', $result);

            return false;

        }

    }
    // We need to retrieve the ajax call requested by the front end and return
    // the view.
    function ajax () {

        echo $this->load->view('ajax/register_ajax_view', '', TRUE);
        exit();

    }
}