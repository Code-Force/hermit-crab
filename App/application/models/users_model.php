<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Users_model extends CI_Model {

    // The login function is to pass information from the login.php controller.
    // We use sha1 for password encryption.
    function login($username, $password)
    {

        // Search the database with the information provided using the sha1 encryption for the password.
        $query = $this->db->query('SELECT u.user_id, u.username FROM users u WHERE username = "'.$username.'" AND password = "'.sha1($password).'" LIMIT 1');

        // We return it as an array as it's quicker.
        if ($query->num_rows() == 1) {

            return $query->result_array();

        } else {

            return false;

        }

    }

    // The register function is to pass information from the register.php controller.
    // We use sha1 for password encryption.
    function register($newUser)
    {

        // CHECK USER EXISTANCE //
        // First we need to check to see if the username is taken
        $check_username = $this->db->query('SELECT u.username FROM users u WHERE username = "'.$newUser['username'].'" LIMIT 1');
        // Then we need to check to see if the email is taken
        $check_email = $this->db->query('SELECT u.email FROM users u WHERE email = "'.$newUser['email'].'" LIMIT 1');

        if ($check_username->num_rows() == 1) {
            return 'This username has already been taken';
        }
        if ($check_email->num_rows() == 1) {
            return 'This email address has already been taken';
        }

        // If the two previous checks for the username and the email address
        // have passed successfully, then we will continue to register the user
        $create_new_user = $this->db->query('INSERT INTO users (username, email, password) VALUE ("'.$newUser['username'].'","'.$newUser['email'].'","'.sha1($newUser['password']).'")');

        // We return it as an array as it's quicker.
        if ($this->db->affected_rows() == 1) {

            // If the new user was inserted correctly, we need to return
            // the information of the user to log them in correctly.
            unset($newUser['password']);
            return $newUser;

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