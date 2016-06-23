<?php
class Posts extends MY_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('posts_model');
    }

    public function view($story_id)
    {
        $the_story = $this->posts_model->get_story($story_id);
        if ($the_story) {
            $data['blurb'] = 'The magical story of "'.$the_story[0]['story_title'].'"';
            $data['story'] = $the_story[0];
            $data['title'] = $the_story[0]['story_title']; // Capitalize the first letter
            $page = 'show_post';

        } else {
            $data['blurb'] = 'suck it bitch! THERE AIN\'T NO POST!';
            $data['story'] = $the_story[0];
            $data['title'] = 'HAR HAR'; // Capitalize the first letter
            $page = 'no_post';
        }

        $this->load->view('templates/header', $data);
        $this->load->view('posts/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }
}
