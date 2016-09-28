<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stories extends MY_Controller
{
	function __construct() {

		parent::__construct();
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

	// This is the true initial function of the stories.php page.
	// the routes.php file will redirect all links here based on the following formula
	// $route['stories/(:any)'] = 'stories/view/$';;
	public function view ($story_slug) {

		// INITIALISE //
		// Setup the user data for use in the views.
		// sessionSetup is in MY_Controller
		$data['user'] = $this->sessionSetup();

		$data['categories'] = $this->stories_model->get_categories();

		// Load the user navigation that controls the logout, login, account, etc links.
		$data['header_snippets'] = $this->initializeHeaderHTML($data);

		$data['current_page'] = 'story';

		// FIX LATER : We need to add security for checking the slug
		// If the story slug exists, we continue searching for the story.
		// If there is no story, we need to provide the user with the "no story" page.
		if ($story_slug) {

			// SET DATA //
			// Retrieve the story based on the slug provided and
			// stick the query result into the variable.
			$the_story = $this->dbOneRecordArrayFormat($this->stories_model->get_story($story_slug, 'slug'));
			$the_story['profile'] = base_url().'assets/users/'.$the_story['folder'].'/small/'.$the_story['profile_photo'];

			// If the story returned and it exists, we continue the process.
			// If there is no story, we need to show the user there is no story.
			if ($the_story) {

				// SET DATA //
				// Set the story and title data for the views.
				$data['story'] = $the_story;
				$data['title'] = $the_story['story_title'];

			} else {

				// SET DATA //
				// There is no story, so we set it to be null for
				// use in the view.
				$data['story'] = null;
				$data['title'] = 'No story be here. Arrrr\'';

			}

			// LOAD VIEWS //
			// Gotta load up the header and footer views as well as the main page view.
			$this->load->view('templates/header_view', $data);
			$this->load->view('stories/story_view', $data);
			$this->load->view('templates/footer_view', $data);

		} else {

			// This page cannot be accessed without providing a username
			// so if there is no username provided in the view, we redirect home
			redirect('/', 'refresh');

		}
	}
	function save () {

		$data['story_id'] = $this->input->post('story-id');
		$content = $this->input->post();
		$data['story_title'] = $this->input->post('story-title');
		$data['story_content'] = $this->input->post('story-content');
		$stories = $this->stories_model->save_story($data);

		if ($stories) {
			echo 'SUCCESS MOTHAFUCKA';
		} else {
			echo 'FAILURE!!';
		}
		exit();

	}

	function ajax($function = 'stories_list') {

		echo $this->$function(true);

	}
	function stories_list ($ajax = false) {

		$search['categories'] = $this->input->get('categories');

		$stories = $this->stories_model->get_stories($search);

		if ($ajax) {
			return json_encode($stories);
		} else {
			return $stories;
		}
	}

}
