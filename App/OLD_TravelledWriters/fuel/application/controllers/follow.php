<?php
class Follow extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
        $this->load->model('write_model');
        $this->load->library('form_builder');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    function index() {
        if ($this->bloggers_model->check_logged()) {

            if ($this->input->post('blogger_id') > 0) {
                $user = $this->bloggers_model->get_user($this->session->userdata['username']);

                $follow = $this->bloggers_model->follow($this->input->post('action'), $this->input->post('blogger_id'), $user['blogger_id']);

                if (is_array($follow)) {

                    $followed_id = $follow[0];
                    $follower_id = $follow[1];
                    $follow = $follow[2];

                    if ($follow == 'follow') {

                        $followed = $this->bloggers_model->get_user($followed_id);
                        $follower = $this->bloggers_model->get_user($follower_id);

                        if ($followed['email_follow_me'] == 'on') {
                            $email_variables = array(array('follower', $follower), array('followed', $followed));
                            $email_template = 'follow';
                            $to = $followed['email'];
                            $title = $follower['username'].' has started following you!';

                            $this->send_my_emails($email_variables, $email_template, $to, $title);
                        }

                    }

                    echo $follow;

                } else {
                    echo $follow;
                }



            } else {
                echo false;
            }

        } else {
            echo false;
        }

    }
}
