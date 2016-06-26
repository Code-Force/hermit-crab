<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Users_model extends CI_Model {

    // The login function is to pass information from the login.php controller.
    // We use sha1 for password encryption.
    function login($username, $password)
    {

        // Search the database with the information provided using the sha1 encryption for the password.
        $query = $this->db->query('SELECT * FROM users u WHERE username = "'.$username.'" AND password = "'.sha1($password).'" LIMIT 1');

        // We return it as an array as it's quicker.
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    // We user this function to retrieve simple data about a
    // specific user. Can be user anywhere.
    function get_user ($user, $method = 'username') {

        // retrieve a single user's basic information.
        $query = $this->db->query('SELECT u.username FROM users u WHERE '.$method.' = "'.$user.'" LIMIT 1');

        // We return it as an array as it's quicker.
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }

    }

}