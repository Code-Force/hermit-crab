<?php
class Settings extends Auth_Controller {

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
                $page_init = array('location' => 'settings');
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
        $user = $this->bloggers_model->get_user($this->session->userdata['username']);
        $vars['user'] = $user;
        $vars['user_logged'] = TRUE;
        $vars['update_me'] = '';
        $vars['errors'] = '';
        $vars['countries'] = $this->write_model->get_countries();


        // field name, error message, validation rules
        $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[4]|xss_clean|alpha_numeric');
        $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
        $this->form_validation->set_rules('new_password', 'new password', 'trim|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('confirm_new_password', 'password confirmation', 'trim|min_length[4]|max_length[32]|matches[new_password]');
        $this->form_validation->set_message('regex_match', 'Your %s must be only letters');


        $vars['user']['username'] = $this->input->post('username');
        $vars['user']['email'] = $this->input->post('email');
        $vars['user']['email_new_feature'] = $this->input->post('email_new_feature');
        $vars['user']['email_new_story'] = $this->input->post('email_new_story');
        $vars['user']['email_new_action'] = $this->input->post('email_new_action');
        $vars['user']['email_follow_me'] = $this->input->post('email_follow_me');

        $data = array();

        if ($this->form_validation->run() == FALSE) {

        } else {

            if ($this->input->post('email') != $user['email']) {
                $check_email = $this->bloggers_model->check_exist($vars['user']['email'], 'email');

                if ($check_email === true) {
                    $data['email'] = $this->input->post('email');
                    $vars['update_me'] = TRUE;

                } else {
                    $vars['errors'] .= '<p>That email address is already taken.</p>';
                    $vars['update_me'] = FALSE;
                }
            }
            if ($this->input->post('username') != $user['username']) {
                $check_username = $this->bloggers_model->check_exist($vars['user']['username'], 'username');
                if ($check_username === true) {
                    $data['username'] = $this->input->post('username');
                    $update_username = 1;
                    $vars['update_me'] = TRUE;

                } else {
                    $vars['errors'] .= '<p>That username is already taken.</p>';
                    $vars['update_me'] = FALSE;
                }
            }

            if ($this->input->post('old_password') != '' && ($this->input->post('new_password') != '' || $this->input->post('confirm_new_password') != '')) {

                if (sha1($this->input->post('old_password')) == $user['password']) {
                    $data['password'] = sha1($this->input->post('new_password'));
                    $vars['update_me'] = TRUE;
                } else {
                    $vars['errors'] .= '<p>Your old password entered does not match the password we have on file.</p>';
                    $vars['update_me'] = FALSE;
                }

            } elseif ($_POST['old_password'] != '') {
                $vars['errors'] .= '<p>Enter your new password and confirm it.</p>';
                $vars['update_me'] = FALSE;
            }
            $user_updated = false;
            if ($vars['update_me'] == TRUE || $vars['errors'] == '') {
                $data['email_new_feature'] = $this->input->post('email_new_feature');
                $data['email_new_story'] = $this->input->post('email_new_story');
                $data['email_new_action'] = $this->input->post('email_new_action');
                $data['email_follow_me'] = $this->input->post('email_follow_me');

                $user_updated = $this->bloggers_model->update_user($data, 'blogger_id', $user['blogger_id']);
            }

            // If all of the information has been supplied successfully, setup email template and send activation link
            if ($user_updated === true) {

                $vars['errors'] = $user_updated;
                if (isset($update_username)) {
                    $this->session->set_userdata('username', $data['username']);
                }
            } else {

                // Display errors from the model
                if ($vars['errors'] == '') {
                $vars['errors'] .= '<p>There was an error updating your details.</p>';
                }

                $vars['update_me'] = false;
            }
        }
        // use Fuel_page to render so it will grab all opt-in variables and do any necessary parsing
        $page_init = array('location' => 'settings');
        $this->load->module_library( FUEL_FOLDER, 'fuel_page', $page_init );
        $this->fuel_page->add_variables($vars);
        $this->fuel_page->render();
    }
}
