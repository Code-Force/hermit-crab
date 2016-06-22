<?php
class Blogger extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
        $this->load->model('write_model');
    }

    function index() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

        if ($this->bloggers_model->check_logged()){

            $vars['user_logged'] = TRUE;
            $vars['user'] = $this->bloggers_model->get_user($this->session->userdata['username']);

        } else {
            $vars['user'] = array();

            $vars['user_logged'] = FALSE;

        }
        // use Fuel_page to render so it will grab all opt-in variables and do any necessary parsing
        $vars['countries'] = $this->write_model->get_countries();
        if ($this->uri->segment(1) == 'edit') {
            $this->load->library('form_builder');
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            if (!is_numeric($this->uri->segment(2))) {
                redirect('discover');
            }
            if ($this->bloggers_model->check_logged()) {
                $vars['user_logged'] = TRUE;

                $vars['story_edit'] = $this->write_model->get_story($this->uri->segment(2), $vars['user']['blogger_id']);
                if (is_array($vars['story_edit'])) {
                    $vars['countries'] = $this->write_model->get_countries();
                    $vars['categories'] = $this->write_model->get_categories();
                    $vars['tags_preload'] = $this->write_model->deal_with_tags(null, 'preload');
                    $vars['tags_preselected'] = $this->write_model->deal_with_tags(null, 'preselected',$vars['story_edit']['story_id']);

                    if (!empty($_POST))
                    {
                        // put your processing code here... we show what we do for emailing. You will need to add a correct email address
                        if ($this->_edit_process($vars))
                        {

                        }
                    } else {

                        $page_init = array('location' => 'edit');
                        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
                        $this->fuel_page->add_variables( $vars );
                        $this->fuel_page->render();
                    }
                } else {
                    $vars['user_logged'] = FALSE;
                    redirect('discover');

                }


            } else {
                $vars['user_logged'] = FALSE;
                redirect('discover');

            }


        } elseif ($this->uri->segment(1) == 'delete') {
            if (!is_numeric($this->uri->segment(2))) {
                redirect('discover');
            }
            if ($this->bloggers_model->check_logged()) {
                $vars['user_logged'] = TRUE;

                $vars['story_edit'] = $this->write_model->get_story($this->uri->segment(2), $vars['user']['blogger_id']);
                $vars['the_story'] = $this->display_stories(array($vars['story_edit']));

                if (is_array($vars['story_edit'])) {

                    if (!empty($_POST))
                    {
                        // put your processing code here... we show what we do for emailing. You will need to add a correct email address
                        if ($this->_delete_process($vars))
                        {

                        }
                    } else {

                        $page_init = array('location' => 'delete');
                        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
                        $this->fuel_page->add_variables( $vars );
                        $this->fuel_page->render();
                    }
                } else {
                    $vars['user_logged'] = FALSE;
                    redirect('discover');

                }


            } else {
                $vars['user_logged'] = FALSE;
                redirect('discover');

            }


        } elseif ($user_viewed = $this->bloggers_model->get_user($this->uri->segment(1))) {

            $vars['user_viewed'] = $user_viewed;

            $story_viewed = $this->write_model->get_story($this->uri->segment(2), $user_viewed['blogger_id']);

            if (is_array($story_viewed)) {

                if (!empty($vars['user'])) {
                    $this->write_model->add_story_view($story_viewed['story_id'], $vars['user']['blogger_id'], $_SERVER['REMOTE_ADDR']);
                } else {
                    $this->write_model->add_story_view($story_viewed['story_id'], 0, $_SERVER['REMOTE_ADDR']);
                }


                $vars['story_viewed'] = $story_viewed;
                $vars['page_title'] =  $vars['story_viewed']['story_title'];

                $stories = $this->write_model->get_stories(0, $vars['story_viewed']['story_id'], 4, array(), array(), 0, 1);
                //$comments = $this->write_model->get_comments($vars['story_viewed']['story_id'], 99999, 0, null, 1);
                $vars['has_liked'] = $this->write_model->has_liked($_SERVER['REMOTE_ADDR'], $vars['story_viewed']['story_id']);

                //shuffle($stories);

                if (isset($vars['user']) && !empty($vars['user'])) {
                    $vars['is_following'] = $this->bloggers_model->is_following($user_viewed['blogger_id'], $vars['user']['blogger_id']);
                } else {
                    $vars['is_following'] = false;
                }

                $vars['stories'] = $this->display_stories($stories, 4);
                //$vars['comments'] = $this->display_comments($comments, $vars['user']);


                //$vars['count_comments'] = count($comments);

                while ($vars['random_story']['story_id'] == $vars['story_viewed']['story_id']) {
                    $vars['random_story'] = $this->write_model->get_story(0,0,1);
                    echo 1;
                }

                $page_init = array('location' => 'story');
                $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );

            } else {
                $filters = array();
                if (isset($_GET['continent'])) {
                    $continents = explode(':',$_GET['continent']);
                    foreach ($continents as $continent){
                        $filters[] = 'continent:'.$continent;
                    }
                }
                if (isset($_GET['tag'])) {
                    $filters[] = 'tag:'.$_GET['tag'];
                }


                if (isset($vars['user']) && !empty($vars['user'])) {
                    $vars['is_following'] = $this->bloggers_model->is_following($user_viewed['blogger_id'], $vars['user']['blogger_id']);
                } else {
                    $vars['is_following'] = false;
                }

                $stories = $this->write_model->get_stories($user_viewed['blogger_id'],0,15,$filters);

                if ($stories == false) {
                    $vars['stories'] = '<div class="search_message"><img src="'.base_url().'assets/images/icons/no-results.png" /><br /><br />No results found.<br /><br />Please try some new filters.</div>';
                } else {
                    $vars['stories'] = $this->display_stories($stories);
                }

                $vars['body_class'] = 'view_profile';
                $vars['page_title'] = $user_viewed['username'];

                $vars['followers'] = $this->write_model->crunch_numbers($this->bloggers_model->count_followers('followers', $user_viewed['blogger_id']));
                $vars['following'] = $this->write_model->crunch_numbers($this->bloggers_model->count_followers('following', $user_viewed['blogger_id']));
                $page_init = array('location' => 'blogger');
                $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );

            }
        } else {

            $page_init = array('location' => '404');
            $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );


        }



        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }
    // Registration method
    public function _delete_process($vars) {
        $vars = $vars;

        $result = $this->write_model->delete_story($vars['story_edit']['story_id'], $vars['user']['blogger_id']);

        if ($result === false) {
            $vars['user_logged'] = FALSE;
            $vars['errors'] = "<p>There has been an error in submitting this story. Please contact us about it..</p>";
        } else {
            $vars['errors'] = 1;
            $vars['user_logged'] = TRUE;
        }


        $page_init = array('location' => 'delete');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }
    // Registration method
    public function _edit_process($vars) {
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

            $result = $this->write_model->update_story($vars['story_edit']['story_id'], $vars['user']['blogger_id'], $vars['user']['folder'], $title, $description, $country, $location, $story_tags, $story, $story_photo, $vars['story_edit'], $this->uri->segment(2));

            if ($result === false) {
                $vars['user_logged'] = FALSE;
                $vars['errors'] = "<p>There has been an error in submitting this story. Please contact us about it..</p>";
            } else {
                redirect($vars['user']['username'].'/'.$result, 'refresh');
                $vars['user_logged'] = TRUE;
            }

        }
        $page_init = array('location' => 'edit');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }
}
