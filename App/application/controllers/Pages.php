<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends MY_Controller {

    function __construct() {

        parent::__construct();

    }

    // The initial function of the index is to
    // redirect users. This function is not possible to access
    // as per the comments below. But we have it just in case.
    function index() {

        // This page cannot be accessed without providing a page
        // the routes.php file will not allow the page to be accessed
        // $route['pages/(:any)'] = 'pages/view/$';
        redirect('/', 'refresh');

    }

    // This function is the main purpose of this controller.
    // It will dynamically display individual page files.
    public function view($page = 'home') {

        // INITIALISE //
        // Setup the user data for use in the views.
        // sessionSetup is in MY_Controller
        $data['user'] = $this->sessionSetup();

        // Check to see if the desired page and file actually exist.
        if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        // SET DATA //
        // Setup the data for the views.
        $data['title'] = ucfirst($page);

        // LOAD VIEWS //
        // Gotta load up the header and footer views as well as
        // the main page view.
        $this->load->view('templates/header', $data);
        $this->load->view('pages/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }

}