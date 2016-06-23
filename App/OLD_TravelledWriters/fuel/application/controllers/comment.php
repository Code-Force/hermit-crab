<?php
class Comment extends Auth_Controller {

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

            $the_comment = $this->input->post('comment');
            $reply_id = $this->input->post('reply');

            if ($the_comment != '') {


                if (strlen($the_comment) > 3000) {
                    echo 8; // character limit

                } else {

                    $story_slug = $this->input->post('story_slug');
                    $blogger = $this->input->post('blogger');

                    $story_user = $this->bloggers_model->get_user($blogger);

                    $story = $this->write_model->get_story($story_slug, $story_user['blogger_id']);

                    if (is_array($story)) {

                        $user = $this->bloggers_model->get_user($this->session->userdata['username']);

                        $comment = $this->write_model->post_comment($the_comment, $reply_id, $story, $user['blogger_id']);
                        if (!is_numeric($comment)) {
                            $send_reply = array();
                            if ($reply_id > 0) {
                                $in_reply_to = $this->write_model->get_comments($story['story_id'], 1, $reply_id);

                                if ($in_reply_to[0]['email_new_action'] == 'on') {
                                    $email_variables = array(array('user', $in_reply_to[0]), array('story', $story), array('commenter', $user));
                                    $email_template = 'reply';
                                    $to = $in_reply_to[0]['email'];
                                    $title = 'New reply!';

                                    $this->send_my_emails($email_variables, $email_template, $to, $title);
                                }

                                if (!empty($in_reply_to) && (count($in_reply_to) == 1)) {
                                    foreach ($in_reply_to as $reply) {
                                        $send_reply = $reply;
                                    }
                                }
                                $comment = $this->display_comments($comment, $user, 1, $send_reply);
                            } else {
                                $comment = $this->display_comments($comment);

                            }

                            if ($story_user['email_new_action'] == 'on') {
                                $email_variables = array(array('user', $story_user), array('story', $story), array('commenter', $user));
                                $email_template = 'comment';
                                $to = $story_user['email'];
                                $title = 'New comment!';

                                $this->send_my_emails($email_variables, $email_template, $to, $title);
                            }

                        }
                        echo $comment;

                    } else {
                        echo 5; // story doesn't exist
                    }
                }
            } else {
                echo 2; // no comment posted
            }

        } else {

            echo 3; // not logged in

        }



    }
}
