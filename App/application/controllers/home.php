<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('stories_model');
    }

    // ADD LATER : We have to add the map and all of its functionality here.
    // This is the initial home page function that will help guide users to all other sections
    function index() {

        // INITIALISE //
        // Setup the user data for use in the views.
        // sessionSetup is in MY_Controller
        $data['user'] = $this->sessionSetup();

        // SET DATA //
        // Setup the data for the views.
        $data['title'] = ucfirst('Travelling Home');

        $data['categories'] = $this->stories_model->get_categories();

        // Load the user navigation that controls the logout, login, account, etc links.
        $data['header_snippets'] = $this->initializeHeaderHTML($data);
	

        // LOAD VIEWS //
        // Gotta load up the header and footer views as well as the main page view.
        $this->load->view('templates/header_view', $data);
        $this->load->view('home_view');
        $this->load->view('templates/footer_view', $data);

    }

    // The logout function of the site is located here
    function logout() {

        // Unset and destroy the session
        $this->session->unset_userdata('logged_in');
        session_destroy();

        // We need to redirect back to the home page after the logout
        redirect('/', 'refresh');

    }

}