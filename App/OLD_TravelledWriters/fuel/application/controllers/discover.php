<?php
class Discover extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
        $this->load->model('write_model');
    }

    function index() {
        $vars = array();
        $vars['random_story'] = $this->write_model->get_story(0,0,1);

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

        if (isset($_GET['favourites'])) {
            $filters[] = 'favourites:1';
        }

        // use Fuel_page to render so it will grab all opt-in variables and do any necessary parsing
        $page_init = array('location' => 'discover');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        //if ($this->session->userdata('logged_in')){


        if ($this->bloggers_model->check_logged()) {
            $vars['user_logged'] = TRUE;
            $vars['user'] = $this->bloggers_model->get_user($this->session->userdata['username']);
            //redirect('/');
            $stories = $this->write_model->get_stories(0,0,15,$filters, $vars['user']);

        } else {
            $stories = $this->write_model->get_stories(0,0,15,$filters);
            $vars['user_logged'] = FALSE;
            //redirect('/');

        }


        $vars['countries'] = $this->write_model->get_countries();
        if ($stories == 'favourites') {
            $vars['stories'] = '<div class="search_message"><img src="'.base_url().'assets/images/icons/no-favourites.png" /><br /><br />You haven\'t followed anyone yet!<br /><br />Please try some new filters.</div>';

        } elseif ($stories == false) {
            $vars['stories'] = '<div class="search_message"><img src="'.base_url().'assets/images/icons/no-results.png" /><br /><br />No results found.<br /><br />Please try some new filters.</div>';
        } else {

            $vars['stories'] = $this->display_stories($stories);
        }

        $this->fuel_page->add_variables( $vars );
        $this->fuel_page->render();
    }
}
