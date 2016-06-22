<?php
class Signin extends Auth_Controller {

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
        $vars['page_title'] = 'Sign in to Travelled Writers';
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        if ($this->bloggers_model->check_logged()) {
            $vars['user_logged'] = TRUE;
            redirect('discover');
        } else {
            $vars['user_logged'] = FALSE;
        }


        $this->load->library('form_builder');
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

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
                $page_init = array('location' => 'signin');

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

        // field name, error message, validation rules
        $this->form_validation->set_rules('username', 'username', 'required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'required|xss_clean|min_length[6]');



        if ($this->form_validation->run() == FALSE) {

        } else {

            // If fields are OK, check user's inputted info.
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $remember_me = $this->input->post('remember_me');

            $result = $this->bloggers_model->login($username, sha1($password), $remember_me);
            if ($result === false) {
                $vars['user_logged'] = FALSE;
                $vars['errors'] = "<p>The login information does not match. Please try again.</p>";
            } elseif ($result === true) {
                redirect($this->session->userdata('username'), 'refresh');
                $vars['user_logged'] = TRUE;
            } else {
                $vars['errors'] = $result;
                $vars['user_logged'] = FALSE;

            }

        }
        $vars['page_title'] = 'Sign in to Travelled Writers';

        $page_init = array('location' => 'signin');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables($vars);
        $this->fuel_page->render();
    }

}

?>