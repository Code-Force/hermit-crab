<?php
class MY_Controller extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $session_data = $this->session->userdata('logged_in');
    }
    function dbOneRecordArrayFormat($array) {
        $array = $array[0];
        return $array;
    }
    function sessionSetup() {
        return $this->session->userdata('logged_in');
    }
	function initializeHeaderHTML($data) {
		$load_views = array(
			'user_nav_html' => $this->load->view('snippets/user_nav_view', $data, TRUE)
		);
		return $load_views;
	}
    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        return $d;
    }
   /* function incrementalHash($len = 10){
        $charset = "0123#$45678#$!9ABCDEFGH!IJ!KLMN#OPQRST$#UVW#XYZabcdefghijk#lmno!pqrstuvw#xyz";
        $base = strlen($charset);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base){
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
        }
        return substr($result, -10);
    }

    function send_my_emails($variables = array(), $file = 'blank', $to = 'bennymclennan@gmail.com', $subject = 'Email from Travelled Writers', $from = 'noreply@travelledwriters.com', $from_name = 'Travelled Writers') {
        $this->load->library('email');

        $config['mailtype'] = 'html';

        $this->email->initialize($config);
        $this->email->from($from, $from_name);
        $this->email->to($to);

        $this->email->subject($subject);

        $data['module'] = "_emails";
        $data['view_file'] = $file;
        $data['email_variables'] = array();
        foreach($variables as $variable) {

            $data['email_variables'][$variable[0]] = $variable[1];

        }

        $register_email = $this->load->view('_emails/main', $data, TRUE);

        $this->email->message($register_email);

        $this->email->send();
    }
    function display_comments ($comments, $user = array(), $replies = 0, $in_reply_to = array()) {
        $return = '';
        if (is_array($comments)) {
            foreach ($comments as $comment) {
                if ($comment['show_name'] == 'on') {
                    $showing_name =  $comment['fullname'];
                } else {
                    $showing_name = $comment['username'];
                }
                $profile_photo = base_url().'assets/users/'.$comment['folder'].'/small/'.$comment['profile_photo'];
                if ($replies == 1) {
                    $return .= '<div class="display_reply" id="comment_'.$comment['comment_id'].'">';
                } else {
                    $return .= '<div class="display_comment" id="comment_'.$comment['comment_id'].'">';
                }
                $return .= '
                    <div class="commenter_photo"><img src="'.$profile_photo.'" /></div>
                    <div class="commenter_comment">
                        <div class="the_comment_text">'.nl2br($comment['comment']).'</div>';
                if (!empty($in_reply_to) && isset($in_reply_to) && (count($in_reply_to) >= 0)) {
                    if ($in_reply_to['show_name'] == 'on') {
                        $reply_name =  $in_reply_to['fullname'];
                    } else {
                        $reply_name = $in_reply_to['username'];
                    }
                    $return .= '<div class="replied_comment">In reply to <a href="'.base_url().$in_reply_to['username'].'">'.$reply_name.'</a>\'s comment -
                    <a href="javascript:void(0)" class="show_reply_comment" id="'.$comment['comment_id'].'_'.$in_reply_to['comment_id'].'">show comment</a>
                    <div class="show_comment" id="'.$comment['comment_id'].'_'.$in_reply_to['comment_id'].'_show_comment">'.nl2br($in_reply_to['comment']).'</div></div>';
                }
                $return .= '
                    </div>
                    <div class="commenter_meta">
                        <div class="by_who">
                        By <a href="'.base_url().$comment['username'].'">'.$showing_name.'</a> - '.$comment['date_commented'].'
                        </div>';

                if (!empty($user) && ($user['blogger_id'] != $comment['blogger_id'])) {
                    $return .= '
                            <div class="reply_comment" id="'.$comment['comment_id'].'">
                            Reply
                            </div>';
                    if ($replies == 1) {
                        $return .= '<div class="reply_box reply_reply_box" id="'.$comment['comment_id'].'_reply_box">';
                    } else {
                        $return .= '<div class="reply_box" id="'.$comment['comment_id'].'_reply_box">';
                    }
                    $return .= '
                                <div id="'.$comment['comment_id'].'_new_reply_loader" class="comment_loader"><img src="'.base_url().'assets/images/load-stories.gif" class="comments_loader_image" /></div>
                                <div class="comments_box_contain" id="'.$comment['comment_id'].'_new_reply_box">
                                    <div class="commenter_pic">
                                        <img src="'.base_url().'assets/users/'.$user['folder'].'/small/'.$user['profile_photo'].'"  />
                                    </div>
                                    <div class="new_comment">
                                        <textarea name="new_comment" class="comment_textarea" id="'.$comment['comment_id'].'_new_reply_text" placeholder="Post a new comment!"></textarea>
                                    </div>

                                    <div class="new_comment_submit">
                                        <button name="submit_comment" id="'.$comment['comment_id'].'_new_reply" class="submit_comment reply-link">Post Reply</button>
                                    </div>
                                    <input type="hidden" id="'.$comment['comment_id'].'_new_reply_id" value="'.$comment['comment_id'].'" />
                                    <div  id="'.$comment['comment_id'].'_new_reply_error" class="commenting_error_box"></div>
                                </div>

                            </div>';
                }


                $return .= '</div>';

                $return .= '</div>
                <div id="'.$comment['comment_id'].'_new_reply_all_comments">';

                if (!empty($comment['replies'])) {

                    $return .= $this->display_comments($comment['replies'], $user, 1, $comment);
                }

                $return .= '</div>
                <div class="clear"></div>';
            }
        }
        return $return;


    }
    function display_stories ($stories, $limit = 30) {
        $return = '';
        $limit_count = 1;
        if (is_array($stories)) {
            foreach ($stories as $story) {
                if($limit_count <= $limit){
                    if ($story['show_name'] == 'on') {
                        $showing_name =  $story['fullname'];
                    } else {
                        $showing_name = $story['username'];
                    }

                    $profile_photo = base_url().'assets/users/'.$story['folder'].'/small/'.$story['profile_photo'];;

                    $date = strtotime($story['date_posted']);
                    $date = date("l, F tS, Y", $date);

                    $return .= '<div class="story c'.$story['continent_name'].' '.$story['category_name'].$story['class_tags'].'" id="'.$story['story_id'].'">
                    <div class="info-top">

                        <div class="views">&nbsp;&nbsp;'.$story['story_views'].'&nbsp;&nbsp;</div>
                        <div class="likes">&nbsp;&nbsp;'.$story['likes'].'&nbsp;&nbsp;</div>
                        <a href="'.base_url().$story['username'].'/'.$story['slug'].'#comments" id="'.$story['story_id'].'_comments_count" class="comments">&nbsp;&nbsp;0&nbsp;&nbsp;</a>
                        <script>

                        getFacebookCommentCount(\''.base_url().$story['username'].'/'.$story['slug'].'\', function(count) {
                        if (count > 0) {
                                                  $(\'#'.$story['story_id'].'_comments_count\').html(\'&nbsp;&nbsp;\' + count + \'&nbsp;&nbsp;\');
                        }
                        });

                        </script>

                    </div>
                    <div class="photo">
                        <a href="'.base_url().$story['username'].'/'.$story['slug'].'" class="hover_cover"></a>
                        <img src="'.base_url().'assets/users/'.$story['folder'].'/stories/'.$story['album'].'/'.$story['story_cover'].'?'.rand(0,999999).'" height="250" />

                    </div>
                    <div class="info-bottom">

                        <div class="info-holder">
                            <div class="front-story-title">
                                <a href="'.base_url().$story['username'].'/'.$story['slug'].'">'.$story['story_title'].'</a>
                            </div>
                            <div class="story-location">
                                <img src="assets/images/msdropdown/icons/blank.gif" class="flag '.strtolower($story['iso']).' fnone" title="'.$story['nicename'].'" />
                                '.$story['nicename'].', '.$story['location'].'
                            </div>
                            <div class="story-desc">
                                '.$story['description'].'
                            </div>


                            <div class="story-tag story-filter">
                                '.$story['filter_tags'].'
                            </div>
                            <div class="author">
                                <div class="story-auth-photo">
                                    <a href="'.base_url().$story['username'].'">
                                    <img src="'.$profile_photo.'" width="30" />
                                    </a>
                                </div>
                                <div class="story-auth">
                                    <a href="'.base_url().$story['username'].'">
                                        '.$showing_name.'
                                    </a>

                                    <div class="story-date">
                                        '.$story['dated'].'
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>

                    </div>

                </div>';

                    $limit_count++;
                }
            }
        }

        return $return;
    }*/
}
