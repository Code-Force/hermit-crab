<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Posts_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_story($story_id) {
        $this_story = false;
        $query = $this->db->query('SELECT * FROM stories s WHERE story_id = '.$story_id.'');


        return $query->result_array();

    }
}