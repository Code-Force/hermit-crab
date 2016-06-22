<?php
class Write extends Auth_Controller {

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
        // use Fuel_page to render so it will grab all opt-in variables and do any necessary parsing
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        //if ($this->session->userdata('logged_in')){
        if ($this->bloggers_model->check_logged()) {
            $vars['user_logged'] = TRUE;
            $vars['user'] = $this->bloggers_model->get_user($this->session->userdata['username']);
            $vars['countries'] = $this->write_model->get_countries();
            $vars['categories'] = $this->write_model->get_categories();
            $vars['tags_preload'] = $this->write_model->deal_with_tags(null, 'preload');


            if (!empty($_POST))
            {
                // put your processing code here... we show what we do for emailing. You will need to add a correct email address
                if ($this->_process($vars))
                {

                }
            } else {
                $page_init = array('location' => 'write');
                $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
                $this->fuel_page->add_variables( $vars );
                $this->fuel_page->render();
            }


        } else {
            $vars['user_logged'] = FALSE;
            redirect('discover');

        }


    }
    // Registration method
    public function _process($vars) {
        $vars =$vars;
        // field name, error message, validation rules
        $this->form_validation->set_rules('story_title', 'title', 'required|min_length[5]|xss_clean');
        $this->form_validation->set_rules('description', 'description', 'max_length[150]|xss_clean');
        $this->form_validation->set_rules('country', 'country', 'required|xss_clean|min_length[1]|max_length[3]|numerical');
        $this->form_validation->set_rules('location', 'location', 'required|min_length[3]|xss_clean');
        //$this->form_validation->set_rules('category', 'category', 'required|xss_clean|numerical');
        $this->form_validation->set_rules('story_tags', 'tags', 'required|xss_clean');
        $this->form_validation->set_rules('story', 'story', 'required|xss_clean|min_length[300]');
        $this->form_validation->set_rules('story_photo', 'cover photo', 'required');



        if ($this->form_validation->run() == FALSE) {

        } else {


            // If fields are OK, check user's inputted info.
            $title = $this->input->post('story_title');
            $description = $this->input->post('description');
            $country = $this->input->post('country');
            $location = $this->input->post('location');
            $story_tags = $this->input->post('story_tags');
            $story = $this->input->post('story');
            $story_photo = $this->input->post('story_photo');

            $result = $this->write_model->add_story($vars['user']['blogger_id'], $vars['user']['folder'], $title, $description, $country, $location, $story_tags, $story, $story_photo);

            if ($result === false) {
                $vars['user_logged'] = FALSE;
                $vars['errors'] = "<p>There has been an error in submitting this story. Please contact us about it..</p>";
            } else {
                $followers = $this->bloggers_model->get_followers($vars['user']['blogger_id']);
                $this_story = $this->write_model->get_story($result);
                if (!empty($followers)) {
                    foreach($followers as $follower) {
                        if ($follower['email_new_story'] == 'on') {
                            $email_variables = array(array('user', $follower), array('story', $this_story), array('story_owner', $vars['user']));
                            $email_template = 'new_story';
                            $to = $follower['email'];
                            $title = $vars['user']['username'].' has written a new story!';

                            $this->send_my_emails($email_variables, $email_template, $to, $title);
                        }
                    }
                }





                redirect($vars['user']['username'].'/'.$result, 'refresh');
                $vars['user_logged'] = TRUE;
            }

        }
        $page_init = array('location' => 'write');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }
}
