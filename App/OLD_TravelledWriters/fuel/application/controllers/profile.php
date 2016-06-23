<?php
class Profile extends Auth_Controller {

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
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        //if ($this->session->userdata('logged_in')){
        if ($this->bloggers_model->check_logged()) {
            $vars['user_logged'] = TRUE;
            $vars['user'] = $this->bloggers_model->get_user($this->session->userdata['username']);
            $vars['countries'] = $this->write_model->get_countries();

            if (!empty($_POST))
            {
                // put your processing code here... we show what we do for emailing. You will need to add a correct email address
                if ($this->_process($_POST))
                {

                }
            } else {
                // use Fuel_page to render so it will grab all opt-in variables and do any necessary parsing
                $page_init = array('location' => 'profile');
                $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
                $this->fuel_page->add_variables($vars);
                $this->fuel_page->render();
            }

        } else {
            $vars['user_logged'] = FALSE;
            redirect('discover');

        }


    }

    // Registration method
    public function _process() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        $vars['user'] = $this->bloggers_model->get_user($this->session->userdata['username']);
        $vars['user_logged'] = TRUE;
        $vars['countries'] = $this->write_model->get_countries();

        $vars['errors'] = '';


        // field name, error message, validation rules
        $this->form_validation->set_rules('fullname', 'full name', 'trim|required|min_length[4]|xss_clean|regex_match[/^[A-Za-z\s]+$/]');
        $this->form_validation->set_rules('bio', 'bio', 'trim|min_length[4]|xss_clean|htmlspecialchars|max_length[300]');
        $this->form_validation->set_rules('nationality', 'nationality', 'xss_clean');
        $this->form_validation->set_rules('website', 'website', 'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('facebook_link', 'Facebook link', 'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('twitter_link', 'Twitter link', 'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('google_link', 'Google+ link', 'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('show_name', 'show full name', 'trim|max_length[2]|xss_clean');
        $this->form_validation->set_message('regex_match', 'Your %s must be only letters');

        $vars['user']['fullname'] = $this->input->post('fullname');
        $vars['user']['bio'] = $this->input->post('bio');
        $vars['user']['nationality'] = $this->input->post('nationality');
        $vars['user']['website'] = $this->input->post('website');
        $vars['user']['facebook_link'] = $this->input->post('facebook_link');
        $vars['user']['twitter_link'] = $this->input->post('twitter_link');
        $vars['user']['google_link'] = $this->input->post('google_link');
        $vars['user']['show_name'] = $this->input->post('show_name');


        if ($this->form_validation->run() == FALSE) {

        } else {

            $data = array(
                'fullname' => $vars['user']['fullname'],
                'bio' => $vars['user']['bio'],
                'nationality' => $vars['user']['nationality'],
                'website' => $vars['user']['website'],
                'facebook_link' => $vars['user']['facebook_link'],
                'twitter_link' => $vars['user']['twitter_link'],
                'google_link' => $vars['user']['google_link'],
                'show_name' => $vars['user']['show_name']
            );

            $user_updated = $this->bloggers_model->update_user($data, 'blogger_id', $vars['user']['blogger_id']);

            // If all of the information has been supplied successfully, setup email template and send activation link
            if ($user_updated === true) {

                $vars['errors'] = $user_updated;
                $vars['update_me'] = true;

            } else {

                // Display errors from the model
                $vars['errors'] = '<p>There was an error updating your details.</p>';
                $vars['update_me'] = false;
            }
        }
        // use Fuel_page to render so it will grab all opt-in variables and do any necessary parsing
        $page_init = array('location' => 'profile');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables($vars);
        $this->fuel_page->render();
    }
}
