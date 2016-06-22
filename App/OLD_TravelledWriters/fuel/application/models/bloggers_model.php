<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');

class Bloggers_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function check_logged() {
        if ($this->session->userdata('logged_in') == true) {
            return true;
        } elseif (!isset($_COOKIE['RememberMe'])) {
            return false;
        } else {
            $this->db->where("remember_code", $_COOKIE['RememberMe']);
            $query = $this->db->get("bloggers");

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    // log the user in and add all data to the session
                    $new_data = array(
                        'bloggers_id' => $rows->blogger_id,
                        'username' => $rows->username,
                        'fullname' => $rows->fullname,
                        'nationality' => $rows->nationality,
                        'folder' => $rows->folder,
                        'profile_photo' => $rows->profile_photo,
                        'user_email' => $rows->email,
                        'logged_in' => TRUE,
                    );
                }
                // set the session
                $this->session->set_userdata($new_data);
                return true;
            } else {
                return false;
            }
        }
    }

    public function add_user($user_details) {
        $user_details['username'] = strtolower($user_details['username']);
        if (!isset($user_details['activation']) || empty($user_details['activation'])) {
            $user_details['activation'] = sha1($user_details['email'] . rand());
        }

        $email_check = $this->check_exist($user_details['email'], 'email');
        $username_check = $this->check_exist($user_details['username'], 'username');
        $folder = md5($user_details['email'] . rand());
        $user_profile_folder = APPPATH."../../assets/users/".$folder;
        $upload_photos_path = APPPATH."../../assets/uploads/".$folder;



        if (!file_exists($user_profile_folder)) {
            mkdir($user_profile_folder, 0775);
        }
        if (!file_exists($user_profile_folder.'/small')) {
            mkdir($user_profile_folder.'/small', 0775);
        }
        if (!file_exists($user_profile_folder.'/story_temp')) {
            mkdir($user_profile_folder.'/story_temp', 0775);
        }
        if (!file_exists($user_profile_folder.'/story_temp/small')) {
            mkdir($user_profile_folder.'/story_temp/small', 0775);
        }
        if (!file_exists($user_profile_folder.'/stories')) {
            mkdir($user_profile_folder.'/stories', 0775);
        }
        if (!file_exists($upload_photos_path)) {
            mkdir($upload_photos_path, 0775);
        }

        if ($user_details['facebook_id'] > 0) {
            $img = file_get_contents('https://graph.facebook.com/'.$user_details['facebook_id'].'/picture?width=500');
            $profile_photo = $user_details['facebook_id'].'.jpg';
            $large = $user_profile_folder.'/'.$profile_photo;
            $small = $user_profile_folder.'/small/'.$profile_photo;

            file_put_contents($large, $img);

            $this->load->library('simpleimage');
            $image = new SimpleImage();
            $image->load($large);
            $image->resizeToWidth(50);
            $image->save($small);
        } else {
            $photo = APPPATH."../../assets/users/default.png";
            $profile_photo = $user_profile_folder."/default.png";
            $profile_photo_small = $user_profile_folder."/small/default.png";
            copy($photo, $profile_photo);
            $this->load->library('simpleimage');
            $image = new SimpleImage();
            $image->load($photo);
            $image->resizeToWidth(50);
            $image->save($profile_photo_small);
            $profile_photo = 'default.png';
        }

        $data = array(
            'username' => $user_details['username'],
            'fullname' => $user_details['fullname'],
            'folder' => $folder,
            'profile_photo' => $profile_photo,
            'email' => $user_details['email'],
            'password' => sha1($user_details['password']),
            'nationality' => $user_details['nationality'],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'activation' => $user_details['activation'],
            'activated' => $user_details['activated'],
            'facebook_id' => $user_details['facebook_id'],
            'facebook_link' => $user_details['facebook_link'],
            'twitter_id' => $user_details['twitter_id'],
            'twitter_link' => $user_details['twitter_link'],
            'google_id' => $user_details['google_id'],
            'google_link' => $user_details['google_link']
        );

        if ($username_check != 1) {
            return $username_check;
        } elseif ($email_check != 1) {
            return $email_check;
        } elseif ($this->db->insert('bloggers', $data)) {
            /*            $data = array(
                            'doer_id' => 1,
                            'accepter_id' => $this->db->insert_id(),
                            'type_id' => 6,
                            'announcement_id' => 1
                        );
                        $this->db->insert('notifications', $data);*/
            return true;
        }

    }
    function update_user($updates, $where_condition, $condition) {

        if ($this->db->update('bloggers', $updates, array($where_condition => $condition))) {
            return true;
        } else {
            return false;
        }

    }
    function count_followers ($action = 'followers', $blogger_id) {
        if ($action == 'followers'){
            $query = $this->db->query('SELECT COUNT(connect_id) AS follow_number FROM follow_connect WHERE followed_id = "'.$blogger_id.'"');
        } elseif ($action == 'following'){
            $query = $this->db->query('SELECT COUNT(connect_id) AS follow_number FROM follow_connect WHERE follower_id = "'.$blogger_id.'"');
        }
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {

                return $rows->follow_number;
            }

        } else {
            return 0;
        }
    }
    function get_followers ($blogger_id) {
        $this_array = array();
        $query = $this->db->query('SELECT b.* FROM follow_connect fc, bloggers b WHERE fc.followed_id = "'.$blogger_id.'" AND b.blogger_id = fc.follower_id');
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                $this_array[] = $this->objectToArray($rows);

            }

        }
        return $this_array;
    }
    function is_following($followed_id, $follower_id){
        $this->db->where('followed_id', $followed_id);
        $this->db->where('follower_id', $follower_id);

        $query = $this->db->get("follow_connect");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;

        }

    }
    function follow($action, $followed_id, $follower_id) {

        if ($action == 'follow') {
            $this->db->where('followed_id', $followed_id);
            $this->db->where('follower_id', $follower_id);

            $query = $this->db->get("follow_connect");
            if ($query->num_rows() > 0) {
                return array($followed_id, $follower_id, 'followed');

            } else {
                $data = array(
                    'followed_id' => $followed_id,
                    'follower_id' => $follower_id
                );
                $followed = $this->db->insert('follow_connect', $data);

                $data = array(
                    'doer_id' => $follower_id,
                    'accepter_id' => $followed_id,
                    'type_id' => 2

                );
                $notified = $this->db->insert('notifications', $data);
                if ($followed && $notified) {
                    return array($followed_id, $follower_id, 'followed');

                } else {
                    return false;
                }
            }
        } elseif ($action == 'unfollow') {
            $this->db->where('followed_id', $followed_id);
            $this->db->where('follower_id', $follower_id);

            $query = $this->db->get("follow_connect");
            if ($query->num_rows() > 0) {
                $this->db->where_in( 'followed_id', $followed_id );
                $this->db->where_in( 'follower_id', $follower_id );

                if ($this->db->delete('follow_connect')) {
                    return array($followed_id, $follower_id, 'unfollowed');

                } else {
                    return false;
                }

            } else {
                return array($followed_id, $follower_id, 'unfollowed');
            }
        } else {
            return false;
        }

    }
    public function disconnectsocial($action, $user_details) {

        $this->db->where($action.'_id', $user_details[$action.'_id']);

        $query = $this->db->get("bloggers");
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {

                $data = array(
                    $action.'_id' => '',
                    $action.'_link' => ''
                );

                $this->update_user($data, 'email', $user_details['email']);

                return true;

            }

        } else {
            return false;
        }

    }
    public function check_connect_social($user_details, $type = 'facebook') {
        $user_details['username'] = strtolower($user_details['username']);

        $return_data = array();
        if ($user_details[$type.'_id'] != '') {
            if (!isset($activation) || empty($activation)) {
                $activation = sha1($user_details['email'] . rand());
            }

            $this->db->where($type.'_id', $user_details[$type.'_id']);

            $query = $this->db->get("bloggers");
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $rows) {

                    // return the user's validation link to reset their password.
                    $login_try = $this->login($rows->username, $rows->password, 'on');
                    if ($login_try === true) {
                        $return_data['method'] = 'just_connect';
                        $return_data['username'] = $rows->username;
                        return $return_data;
                        exit();
                    }
                }

            } else {
                $check_email = $this->check_exist($user_details['email'], 'email');
                if ($check_email === true) {
                    $check_username = $this->check_exist($user_details['username'], 'username');
                    if ($check_username !== true) {

                        $user_details['username'] = $user_details['username'].rand(1000,9999);

                    }
                    $this->add_user($user_details);
                    $sign_in = $this->login($user_details['username'], sha1($user_details['password']), 'on');
                    if ($sign_in) {
                        $return_data['method'] = 'add_connect';
                        $return_data['username'] = $user_details['username'];
                        return $return_data;
                        exit();
                    }
                } else {

                    $data = array(
                        $type.'_id' => $user_details[$type.'_id'],
                        $type.'_link' => $user_details[$type.'_link']
                    );

                    $this->update_user($data, 'email', $user_details['email']);

                    $username = $this->get_username($user_details['email']);

                    $user = $this->get_user($username);
                    $sign_in = $this->login($user['username'], $user['password'], 'on');
                    if ($sign_in) {
                        $return_data['method'] = 'account_exist_add_connect';
                        $return_data['username'] = $username;
                        return $return_data;
                        exit();
                    }
                }
            }
        }
        return false;

    }



    public function check_exist($check_me, $type = '') {
        // To check if the user exists with all matching identifiers and return one boolean result
        if (is_array($check_me)) {
            foreach ($check_me as $this_check) {
                $this->db->where($this_check[1], $this_check[0]);
            }

            $query = $this->db->get("bloggers");
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $rows) {
                    // return the user's validation link to reset their password.
                    return $rows->activation;
                }
            } else {
                return false;
            }
            // To check if someone has already registered a certain field. And return personalised error message
        } else {
            $this->db->where($type, $check_me);

            $query = $this->db->get("bloggers");
            if ($query->num_rows() > 0) {

                // return "<p>The $type <strong>$check_me</strong> has already been registered.</p>";
                return "<p>That $type has already been registered.</p>";
            } else {
                return true;
            }
        }
    }


    function facebook_style_date_time($timestamp)
    {
        $difference = time() - $timestamp;
        $periods = array("sec", "min", "hour", "day", "week", "month", "years", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        if ($difference > 0) { // this was in the past time
            $ending = "ago"; } else { // this was in the future time
            $difference = -$difference; $ending = "to go";
        }
        for($j = 0; $difference >= $lengths[$j]; $j++) $difference /= $lengths[$j];
        $difference = round($difference);
        if($difference != 1) $periods[$j].= "s";
        $text = "$difference $periods[$j] $ending";
        return $text;
    }
    public function get_username($identifier, $action = 'email') {

        $this->db->where($action, $identifier);

        $query = $this->db->get("bloggers");
        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                // return the user's validation link to reset their password.
                return $rows->username;
            }
        } else {
            return false;
        }
    }
    public function check_notifications($last_notification, $blogger_id) {
        $query = $this->db->query("UPDATE notifications SET seen = '1' WHERE notification_date <= '".$last_notification."' AND accepter_id = '".$blogger_id."'");
        var_dump($last_notification);
    }
    public function fetch_upates($blogger_id) {
        $nots = array();

        $query = $this->db->query('SELECT b.*, n.*, nt.*, s.*, sb.username AS story_username, coun.nicename, coun.iso, cont.*
        FROM bloggers b, bloggers sb, notifications n, notification_types nt, stories s, comments c, announcements a, countries coun, continents cont
        WHERE s.story_id = n.story_id
        AND c.comment_id = n.comment_id
        AND n.accepter_id = "'.$blogger_id.'"
        AND b.blogger_id = n.doer_id
        AND sb.blogger_id = s.blogger_id
        AND n.type_id = nt.type_id
        AND coun.country_id = s.country_id
        AND cont.continent_id = s.continent_id
        AND n.announcement_id = a.announcement_id
        GROUP BY n.notification_id
        ORDER BY n.notification_date DESC');
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                // return the user's validation link to reset their password.
                $this_array = $this->objectToArray($rows);
                $this_array['dated'] = $this->facebook_style_date_time(strtotime($rows->notification_date));
                $nots[] = $this_array;

            }

        }

        return $nots;

    }
    public function submit_feedback($name, $email, $feedback, $blogger_id = 0) {
        $aValid = array(' ', '.', ',', '!', '?');

        if(!ctype_alnum(str_replace($aValid, '', $name))) {
            return 'Invalid Name';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Invalid Email';
        }
        if(!ctype_alnum(str_replace($aValid, '', $feedback))) {
            return 'You may only type letters, numbers and punctuation marks.';
        }
        $data = array(
            'blogger_id' => $blogger_id,
            'name' => $name,
            'email' => $email,
            'feedback' => $feedback
        );
        if ($this->db->insert('feedback', $data)) {
            return true;
        } else {
            return 'There was an error.';
        }
    }
    public function get_user($identifier, $action = 'username') {

        if ($identifier > 0) {
            $action = 'blogger_id';
        }

        $this->db->where($action, $identifier);


        $user = array();
        $query = $this->db->get("bloggers");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                // return the user's validation link to reset their password.
                $user = $this->objectToArray($rows);
                $user['updates'] = $this->fetch_upates($user['blogger_id']);

            }

        } else {
            return false;
        }
        return $user;
    }
    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        return $d;
    }
    function login($username, $password, $remember_me) {
        // set all the test variables for validating users
        $this->db->where("username", $username);
        $this->db->where("password", $password);

        $query = $this->db->get("bloggers");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                if ($rows->activated == 0) {

                    return "<p>Your account has not been activated yet.</p>";

                } else {
                    // log the user in and add all data to the session
                    $new_data = array(
                        'bloggers_id' => $rows->blogger_id,
                        'username' => $rows->username,
                        'fullname' => $rows->fullname,
                        'nationality' => $rows->nationality,
                        'folder' => $rows->folder,
                        'profile_photo' => $rows->profile_photo,
                        'user_email' => $rows->email,
                        'logged_in' => TRUE,
                    );
                }
            }

            // set the session
            $this->session->set_userdata($new_data);

            // if the remember me option was selected, create the cookie

            if ($remember_me == 'on') {

                $remember_code = sha1($password . rand());
                $data = array('remember_code' => $remember_code);
                $this->db->update('bloggers', $data, array('username' => $username));

                setcookie("RememberMe", $remember_code, time() + 31449600, '/');
            }

            return true;
        } else {
            return false;
        }
    }

    function logout() {

        $data = array('remember_code' => NULL);
        $this->db->update('bloggers', $data, array('username' => $this->session->userdata('username')));

        setcookie("RememberMe", '', time() - 3600);
        $this->session->sess_destroy();
    }


    function reset_password($email, $activation, $password, $password_confirm) {
        // set all the test variables for validating users
        $this->db->where("email", $email);
        $this->db->where("activation", $activation);

        $query = $this->db->get("bloggers");

        if ($query->num_rows() > 0) {

            // if the remember me option was selected, create the cookie
            $password = sha1($password);
            $data = array('password' => $password);
            $this->db->update('bloggers', $data, array('email' => $email));

            return true;
        } else {
            return "<p>The email address you have entered is not linked to this account</p>";
        }
    }

    function activate_user($activation) {
        // set all the test variables for validating users
        $this->db->where("activation", $activation);

        $query = $this->db->get("bloggers");

        if ($query->num_rows() > 0) {

            foreach ($query->result() as $rows) {
                if ($rows->activated == 0) {

                    $data = array('activated' => 1);
                    $this->db->update('bloggers', $data, array('activation' => $activation));

                    if ($rows->twitter_id > 0) {
                        $this->login($rows->username, $rows->password, 'on');
                        return array ('action' => 'twitter', 'username' => $rows->username);
                    } else {
                        return true;
                    }
                } else {
                    return "<p>Your account has already been activated</p>";
                }
            }
            // if the remember me option was selected, create the cookie
            $password = sha1($password);
            $data = array('password' => $password);
            $this->db->update('bloggers', $data, array('email' => $email));

            return true;
        } else {
            return "<p>That activation code is invalid.</p>";
        }
    }
}



?>