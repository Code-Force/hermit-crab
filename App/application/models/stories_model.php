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
    public function get_stories($num = 999999, $order = 'ASC') {

        // Query to retrieve multiple stories.
        $query = $this->db->query('SELECT s.*, cou.nicename as country, con.nicename as continent, cat.handle as category
            FROM stories s, countries cou, continents con, categories cat
            WHERE cou.country_id = s.country_id
            AND cou.continent_id = con.continent_id
            AND s.category_id = cat.category_id
            GROUP BY s.story_id
            ORDER BY s.story_title '.$order.' LIMIT '.$num);

        // We return it as an array as it's quicker.
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function get_tags ($story_id) {

    }

}