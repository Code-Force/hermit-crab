<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends MY_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('stories_model');

    }

    // The initial purpose of this function is to show the user
    // their account. Should only be accessible by logged in users.
    function index() {

        // INITIALISE //
        // Setup the user data for use in the views.
        // sessionSetup is in MY_Controller
        $data['user'] = $this->sessionSetup();

        // PASSWORD PROTECTED //
        // Check to see if the user is logged in.
        if($data['user']) {

            // SET DATA //
            // Setup the data for the views.
            $data['title'] = ucfirst('My Account');
            // Load the user navigation that controls the logout, login, account, etc links.
            $data['user_nav_html'] = $this->load->view('snippets/user_nav_view', $data, TRUE);

            // LOAD VIEWS //
            // Gotta load up the header and footer views as well as the main page view.
            $this->load->view('templates/header_view', $data);
            $this->load->view('users/account_view');
            $this->load->view('templates/footer_view', $data);

        } else {

            // PASSWORD PROTECTED //
            // We need to redirect the user to the home page if they are not logged in.
            redirect('/', 'refresh');

        }

    }

}