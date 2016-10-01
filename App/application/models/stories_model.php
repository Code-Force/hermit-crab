<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stories_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    // This function is for getting individual stories based on search
    // criteria and the method (the table column) which you want to search
    public function get_story($search_qry, $method = 'story_id') {

        // Query to retreive a single story.
        $query = $this->db->query('SELECT s.*, u.fullname, username, folder, profile_photo FROM stories s, users u WHERE s.'.$method.' = "'.$search_qry.'" AND u.user_id = s.user_id GROUP BY s.story_id LIMIT 1');

        // We return it as an array as it's quicker.
        if ($query->num_rows() == 1) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    public function save_story($story_content) {

        $update_fields = '';
        if (isset($story_content['story_title'])) {
            $update_fields .= 'story_title = "'.trim($story_content['story_title']).'",';
        }
        if (isset($story_content['story_content'])) {
            $update_fields .= 'story = "'.addslashes($story_content['story_content']).'",';
        }


        $this->db->trans_start();
        $this->db->query('UPDATE stories SET '.$update_fields.' date_updated = now() WHERE story_id = '.$story_content['story_id']);
        $this->db->trans_complete();
        if ($this->db->affected_rows() == '1') {
            return TRUE;
        } else {
            // any trans error?
            if ($this->db->trans_status() === FALSE) {
                return false;
            }
            return true;
        }

    }

    // Get X amount of stories
    public function get_stories($search = array(), $num = 999999, $order = 'ASC') {

        $where = 'WHERE cou.country_id = s.country_id
            AND cou.continent_id = con.continent_id
            AND s.category_id = cat.category_id
            AND u.user_id = s.user_id';

        if ($search['categories']) {
            $categoriesRaw = $search['categories'];
            $categories = explode(':', $categoriesRaw);
            $numCategories = count($categories);
            $where .= ' AND (';
            for ($c = 0; $c < $numCategories; $c++) {
                if ($c == ($numCategories - 1)) {
                    $where .= 's.category_id='.$categories[$c].')';
                } else {
                    $where .= 's.category_id='.$categories[$c].' OR ';
                }
            }
        }
        if ($search['last_date']) {
            $date = $search['last_date'];
            $where .= ' AND s.date_posted < '.$date.')';
        }

        // Query to retrieve multiple stories.
        $query = $this->db->query('SELECT s.*, cou.nicename as country, con.nicename as continent, cat.handle as category, u.folder, username, profile_photo fullname
            FROM stories s, countries cou, continents con, categories cat, users u
            '.$where.'
            GROUP BY s.story_id
            ORDER BY s.story_id '.$order.' LIMIT '.$num);

        // We return it as an array as it's quicker.
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }

    }

    // Get all of the categories listed on the website.
    public function get_categories () {

        // Query to retrieve multiple stories.
        $query = $this->db->query('SELECT cat.*
            FROM categories cat
            ORDER BY cat.category_id');

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