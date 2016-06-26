<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('users_model','',TRUE);

    }

    // Initial function of the index is to provide the user
    // with the login for to sign into Travelled Writers.
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
        $data['title'] = ucfirst('Login');
        // Load the user navigation that controls the logout, login, account, etc links.
        $data['user_nav_html'] = $this->load->view('snippets/user_nav_view', $data, TRUE);

        // LOAD VIEWS //
        // Gotta load up the header and footer views as well as
        // the main page view.
        $this->load->view('templates/header_view', $data);
        $this->load->view('users/login_view');
        $this->load->view('templates/footer_view', $data);

    }

    // This function is where the login form from the login_view.php
    // file sends the user to validate the username and password entered.
    function verify () {

        // VALIDATION //
        // We need to validate the login form's username and password.
        // The password field has the check_database callback. If the validation works,
        // we need to then check the database against the entered credentials.
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

        // We now need to run the validation and run the callbacks.
        // If we return 'false', we need to display the errors.
        // If we return 'true', we need to redirect to the account page.
        if (!$this->form_validation->run()) {

            // SET DATA //
            // Setup the data for the views.
            $data['title'] = ucfirst('Login');
            // Load the user navigation that controls the logout, login, account, etc links.
            $data['user_nav_html'] = $this->load->view('snippets/user_nav_view', $data, TRUE);

            // LOAD VIEWS //
            // Field validation failed so we have to show the login form again.
            $this->load->view('templates/header_view', $data);
            $this->load->view('users/login_view');
            $this->load->view('templates/footer_view', $data);

        } else {

            // A successful login will redirect to my account page.
            redirect('/account', 'refresh');

        }

    }

    // After the credentials of a login have been validated, we need
    // To check the database against them and process the login.
    function check_database($password) {

        // SET VARIABLES //
        // We need to set the username variable to make it easier to manage
        // in the function.
        $username = $this->input->post('username');

        // Set the result variable of the login check.
        // Will return array or false.
        $result = $this->oneRecordArrayFormat($this->users_model->login($username, $password));

        // If false, provide validation error message.
        // Otherwise, proceed with login.
        if ($result) {

            // LOGIN USER //
            // Set the session with the logged in user's data
            $this->session->set_userdata('logged_in', $result);

            return true;

        } else {

            // Validation was no good :( ... tell them they are wrong!
            $this->form_validation->set_message('check_database', 'Invalid username or password');

            return false;

        }

    }

}