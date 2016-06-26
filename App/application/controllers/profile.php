<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends MY_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('users_model');
        $this->load->model('stories_model');

    }

    // The initial function of the index is to
    // redirect users. This function is not possible to access
    // as per the comments below. But we have it just in case.
    function index() {

        // This page cannot be accessed without providing a username
        // the routes.php file will not allow the page to be accessed
        // $route['(:any)'] = 'profile/view/$1';
        redirect('/', 'refresh');

    }

    // This is the true initial function of the profile.php page.
    // the routes.php file will redirect all links here based on the following formula
    // $route['(:any)'] = 'profile/view/$1';
    function view ($user) {

        // INITIALISE //
        // Setup the user data for use in the views.
        // sessionSetup is in MY_Controller
        $data['user'] = $this->sessionSetup();

        // SET DATA //
        // Get the user data based on the username provided in the url and format the
        // one record returned array.
        $data['user_profile'] = $this->dbOneRecordArrayFormat($this->users_model->get_user($user));

        if ($data['user_profile']) {

            // The title is the viewed user's username
            $data['title'] = ucfirst($user);
            // Load the user navigation that controls the logout, login, account, etc links.
            $data['user_nav_html'] = $this->load->view('snippets/user_nav_view', $data, TRUE);

            // LOAD VIEWS //
            // Gotta load up the header and footer views as well as
            // the main page view.
            $this->load->view('templates/header_view', $data);
            $this->load->view('users/profile_view');
            $this->load->view('templates/footer_view', $data);

        } else {

            // This page cannot be accessed without providing a valid story slug
            // So we need to redirect them to the home page.
            redirect('/', 'refresh');

        }

    }

}