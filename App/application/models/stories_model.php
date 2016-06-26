<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stories_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // This function is for getting individual stories based on search
    // criteria and the method (the table column) which you want to search
    public function get_story($search_qry, $method = 'story_id') {

        // Query to retreive a single story.
        $query = $this->db->query('SELECT * FROM stories s WHERE '.$method.' = "'.$search_qry.'" LIMIT 1');

        // We return it as an array as it's quicker.
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    // Get X amount of stories
    public function get_stories($num, $order = 'ASC') {

        // Query to retrieve multiple stories.
        $query = $this->db->query('SELECT * FROM stories s ORDER BY s.story_title '.$order.' LIMIT '.$num);

        // We return it as an array as it's quicker.
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

}