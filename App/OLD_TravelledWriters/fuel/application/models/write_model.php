<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(FUEL_PATH.'models/base_module_model.php');

class Write_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function get_countries($for_search = 0) {
        if ($for_search > 0) {
            $query_string = "SELECT DISTINCT(coun.country_id),coun.*, cont.*  FROM countries coun, continents cont WHERE cont.continent_id = coun.continent_id";
            $query = $this->db->query($query_string);
        } else {
            $query = $this->db->get("countries");
        }
        if ($query->num_rows() > 0) {
            // return the user's validation link to reset their password.
            return $this->objectToArray($query->result());
        } else {
            return false;
        }
    }

    public function get_categories() {
        $this->db->order_by("category_name", "asc");
        $query = $this->db->get("categories");
        if ($query->num_rows() > 0) {

            // return the user's validation link to reset their password.
            return $this->objectToArray($query->result());
        } else {
            return false;
        }
    }
    public function get_country_nice($nationality) {
        $this->db->where('country_id', $nationality);
        $query = $this->db->get("countries");
        if ($query->num_rows() > 0) {

            // return the user's validation link to reset their password.
            return $this->objectToArray($query->result());
        } else {
            return false;
        }
    }
    public function deal_with_tags($tags, $action = 'insert', $story_id = 0){
        $return_tags = array();
        if ($action == 'insert') {
            if (is_array($tags)){
                $return_tags = $tags;
            } else {
                $tag_array =  explode(',', $tags);
                foreach ($tag_array as $tag) {
                    $tag = strtolower($tag);

                    $this->db->where('tag_name', $tag);

                    $query = $this->db->get("tags");
                    if ($query->num_rows() > 0) {
                        foreach ($query->result() as $rows) {
                            $return_tags[] = $rows->tag_id;
                        }
                    } else {

                        $the_slug = $this->makeSlugs(trim($tag));

                        $data = array(
                            'tag_name' => $tag,
                            'slug' => $the_slug
                        );
                        $this->db->insert('tags', $data);
                        $return_tags[] = $this->db->insert_id();

                    }
                }
            }
        } elseif ($action == 'class_retrieve') {
            $return_tags = '';
            $query = $this->db->query('SELECT t.* FROM tags t, tag_connect tc  WHERE tc.story_id = "'.$story_id.'" AND t.tag_id = tc.tag_id ');
            foreach ($query->result() as $rows) {
            $return_tags .= ' '.$rows->slug;
            }
        } elseif ($action == 'link_retrieve') {
            $return_tags = '';
            $query = $this->db->query('SELECT t.* FROM tags t, tag_connect tc  WHERE tc.story_id = "'.$story_id.'" AND t.tag_id = tc.tag_id ');
            $entries = count($query->result());
            $count = 1;
            foreach ($query->result() as $rows) {
                if ($count == $entries) {
                    $return_tags .= '<a href="'.base_url().'discover?tag='.$rows->slug.'" title="'.$rows->tag_name.'">'.$rows->tag_name.'</a>';
                } else {
                    $return_tags .= '<a href="'.base_url().'discover?tag='.$rows->slug.'" title="'.$rows->tag_name.'">'.$rows->tag_name.'</a> ';
                }
                $count++;
            }
        } elseif ($action == 'filter_retrieve') {
            $return_tags = '';
            $query = $this->db->query('SELECT t.* FROM tags t, tag_connect tc  WHERE tc.story_id = "'.$story_id.'" AND t.tag_id = tc.tag_id ');
            $entries = count($query->result());
            $count = 1;
            foreach ($query->result() as $rows) {
                if ($count == $entries) {
                    $return_tags .= '<a href="#" data-filter-value="'.$rows->slug.'" data-filter-group="tag" class="filter tags-filter" title="'.$rows->tag_name.'">'.$rows->tag_name.'</a>';
                } else {
                    $return_tags .= '<a href="#" data-filter-value="'.$rows->slug.'" data-filter-group="tag" class="filter tags-filter" title="'.$rows->tag_name.'">'.$rows->tag_name.'</a>, ';
                }
                $count++;
            }
        } elseif ($action == 'preload') {
            $return_tags = "";
            $query = $this->db->query('SELECT t.* FROM tags t');
            $entries = count($query->result());
            $count = 1;
            foreach ($query->result() as $rows) {
                if ($count == $entries) {
                    $return_tags .= "'".$rows->tag_name."'";
                } else {
                    $return_tags .= "'".$rows->tag_name."', ";
                }
                $count++;
            }
        } elseif ($action == 'preselected') {
            $return_tags = "";
            $query = $this->db->query('SELECT t.* FROM tags t, tag_connect tc  WHERE tc.story_id = "'.$story_id.'" AND t.tag_id = tc.tag_id ');
            $entries = count($query->result());
            $count = 1;
            foreach ($query->result() as $rows) {
                if ($count == $entries) {
                    $return_tags .= "".$rows->tag_name."";
                } else {
                    $return_tags .= "".$rows->tag_name.", ";
                }
                $count++;
            }
        }
        return $return_tags;
    }
    function get_following ($blogger_id) {
        $my_followers = array();
        if ($blogger_id > 0){
            $query = $this->db->query('SELECT * FROM follow_connect WHERE follower_id = "'.$blogger_id.'"');
            if ($query->num_rows() > 0) {

                foreach ($query->result() as $rows) {

                    $my_followers[] = $rows->followed_id;
                }
            }
        }
        return $my_followers;
    }
    function post_comment ($comment, $reply_id, $story = array(), $blogger_id) {
        if ($reply_id > 0) {
            $replied_comment =  $this->get_comments($story['story_id'], 1, $reply_id);

            if (empty($replied_comment)){
                $reply_id = 0;
            }
        } else {
            $reply_id = 0;
            $replied_comment = array();
        }
        if (($blogger_id > 0) && (!empty($story))){

            $comment = strip_tags($comment);

            $data = array(
                'blogger_id' => $blogger_id,
                'story_id' => $story['story_id'],
                'comment' => $comment,
                'reply_id' => $reply_id
            );


            if ($this->db->insert('comments', $data)) {
                $comment_id = $this->db->insert_id();

                if ($blogger_id == $story['blogger_id']) {
                    if ($reply_id > 0 && !empty($replied_comment)) {
                        $data = array(
                            'doer_id' => $blogger_id,
                            'accepter_id' => $replied_comment[0]['blogger_id'],
                            'type_id' => 5,
                            'story_id' => $story['story_id'],
                            'comment_id' => $comment_id
                        );
                        $this->db->insert('notifications', $data);
                    }

                    $comment =  $this->get_comments($story['story_id'], 1, $comment_id, $reply_id);


                    return $comment;

                } else {
                    if ($reply_id > 0 && !empty($replied_comment)) {
                        $data = array(
                            'doer_id' => $blogger_id,
                            'accepter_id' => $replied_comment[0]['blogger_id'],
                            'type_id' => 5,
                            'story_id' => $story['story_id'],
                            'comment_id' => $comment_id
                        );
                        $this->db->insert('notifications', $data);
                    }

                    $data = array(
                        'doer_id' => $blogger_id,
                        'accepter_id' => $story['blogger_id'],
                        'type_id' => 1,
                        'story_id' => $story['story_id'],
                        'comment_id' => $comment_id
                    );
                    if ($this->db->insert('notifications', $data)) {

                        $comment =  $this->get_comments($story['story_id'], 1, $comment_id);
                        return $comment;

                    } else {
                        return 7; // There was an error. Please contact staff.

                    }
                }
            } else {
                return 6; // failed to comment
            }

        } else {
            return 7; // There was an error. Please contact staff.
        }
    }
    function like_story ($story_id = 0, $blogger_id = 0, $ip_address) {
        if ($blogger_id > 0) {

        } else {
            $blogger_id = 0;
        }
        if ($story_id > 0){
            $query = $this->db->query('SELECT * FROM stories WHERE story_id = "'.$story_id.'"');
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    // return the user's validation link to reset their password.
                    $accepter_id = $rows->blogger_id;

                }
            } else {
                return false;
            }
            $has_liked = $this->has_liked($ip_address, $story_id);
            if (!$has_liked){
                $query = $this->db->query('SELECT story_id FROM stories WHERE story_id = "'.$story_id.'" AND blogger_id = "'.$blogger_id.'"');
                if ($query->num_rows() > 0) {
                    return false;
                } else {
                    $query = $this->db->query('SELECT story_id FROM notifications WHERE story_id = "'.$story_id.'" AND doer_id = "'.$blogger_id.'" AND type_id = 4');
                    if ($query->num_rows() > 0) {
                        return false;
                    } else {
                        $data = array(
                            'doer_id' => $blogger_id,
                            'accepter_id' => $accepter_id,
                            'type_id' => 4,
                            'story_id' => $story_id,
                            'ip_address' => $ip_address
                        );
                        if ($this->db->insert('notifications', $data)) {
                            $likes = 0;
                            $query_string = "SELECT likes FROM stories s WHERE s.story_id = '".$story_id."'";
                            $query = $this->db->query($query_string);
                            if ($query->num_rows() > 0) {
                                foreach ($query->result() as $rows) {
                                    $likes = $rows->likes;
                                }
                            }
                            $data = array(
                                'likes' => ($likes + 1)
                            );
                            $this->db->update('stories', $data, array('story_id' => $story_id));
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            } else {
                return false;

            }
        } else {
            return false;

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
    public function get_replies ($story_id, $comment_id) {
        $replies = array();

        $query_string = "SELECT * FROM comments c, bloggers b WHERE c.story_id = '".$story_id."' AND c.reply_id = '".$comment_id."' AND b.blogger_id = c.blogger_id ORDER BY date DESC";
        $query = $this->db->query($query_string);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $this_reply = $this->objectToArray($rows);
                $this_reply['date_commented'] = $this->facebook_style_date_time(strtotime($this_reply['date']));
                $this_reply['replies'] = $this->get_replies($story_id, $this_reply['comment_id']);

                $replies[] = $this_reply;

            }
        }
        return $replies;
    }
    public function add_story_view ($story_id, $blogger_id = 0, $ip_address) {
        $data = array(
            'story_id' => $story_id,
            'blogger_id' => $blogger_id,
            'ip_address' => $ip_address
        );
        $story_views = 0;
        $query_string = "SELECT story_views FROM stories s WHERE s.story_id = '".$story_id."' LIMIT 1";
        $query = $this->db->query($query_string);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $story_views = $rows->story_views;
            }
        }
       // , (S) AS likes, (SELECT COUNT(DISTINCT sv.ip_address) as story_views FROM story_views sv WHERE sv.story_id = s.story_id) AS views
        if ($this->db->insert('story_views', $data)) {
            $query_string = "SELECT * FROM story_views sv WHERE sv.ip_address = '".$ip_address."' AND sv.story_id = '".$story_id."' LIMIT 2";
            $query = $this->db->query($query_string);
            if ($query->num_rows() > 1) {

            } else {
                $data = array(
                    'story_views' => ($story_views + 1)
                );
                $this->db->update('stories', $data, array('story_id' => $story_id));
            }

        }
    }
    public function has_liked($ip_address, $story_id) {
        $this->db->where_in( 'ip_address', $ip_address );
        $this->db->where_in( 'story_id', $story_id );
        $query = $this->db->get('notifications');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;

        }
    }
    public function get_comments($story_id = 0, $limit = 999999, $comment_id = 0, $reply_id = null, $startup = 0) {
        if ($startup == 1) {
            if ($comment_id > 0) {
                $query_string = "SELECT * FROM comments c, bloggers b WHERE c.story_id = '".$story_id."' AND c.comment_id = '".$comment_id."' AND c.reply_id = '0' AND b.blogger_id = c.blogger_id ORDER BY date DESC LIMIT ".$limit;
            } else {
                $query_string = "SELECT * FROM comments c, bloggers b WHERE c.story_id = '".$story_id."' AND b.blogger_id = c.blogger_id AND c.reply_id = '0' ORDER BY date DESC LIMIT ".$limit;
            }

        } else {
            if ($reply_id != null) {

                if ($comment_id > 0) {
                    $query_string = "SELECT * FROM comments c, bloggers b WHERE c.story_id = '".$story_id."' AND c.comment_id = '".$comment_id."' AND b.blogger_id = c.blogger_id AND c.reply_id = '".$reply_id."' ORDER BY date DESC LIMIT ".$limit;
                } else {
                    $query_string = "SELECT * FROM comments c, bloggers b WHERE c.story_id = '".$story_id."' AND b.blogger_id = c.blogger_id AND c.reply_id = '".$reply_id."' ORDER BY date DESC LIMIT ".$limit;
                }
            } else {

                if ($comment_id > 0) {
                    $query_string = "SELECT * FROM comments c, bloggers b WHERE c.story_id = '".$story_id."' AND c.comment_id = '".$comment_id."' AND b.blogger_id = c.blogger_id ORDER BY date DESC LIMIT ".$limit;
                } else {
                    $query_string = "SELECT * FROM comments c, bloggers b WHERE c.story_id = '".$story_id."' AND b.blogger_id = c.blogger_id ORDER BY date DESC LIMIT ".$limit;
                }
            }
        }

        $query = $this->db->query($query_string);
        $comments = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $this_comment = $this->objectToArray($rows);
                $this_comment['date_commented'] = $this->facebook_style_date_time(strtotime($this_comment['date']));

                $this_comment['replies'] = $this->get_replies($story_id, $this_comment['comment_id']);
                $comments[] = $this_comment;


            }
        }
        return $comments;

    }
    public function update_likes_views() {
        $sql_select = "SELECT s.story_id, (SELECT COUNT(*) FROM notifications n WHERE n.story_id = s.story_id AND n.type_id = 4) AS likes, (SELECT COUNT(DISTINCT sv.ip_address) as story_views FROM story_views sv WHERE sv.story_id = s.story_id) AS views FROM stories s";
        $query = $this->db->query($sql_select);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {

                $data = array(
                    'story_views' => $rows->views,
                    'likes' => $rows->likes
                );
                $this->db->update('stories', $data, array('story_id' => $rows->story_id));

            }
        }
    }

    public function get_stories($blogger_id = 0, $story_id = 0, $limit = 15, $filters = array(), $user = array(), $get_related = 0, $random = 0, $map = 0) {
        $stories = array();

        if (!empty($filters)) {
            $tags_count = 0;
            $continents_count = 0;
            $get_favourites = false;
            $getmorestories = 0;
            $continents = array();
            $tags = array();
            if ($blogger_id > 0) {
                $sql_select = "SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.*, (SELECT COUNT(*) FROM notifications n WHERE n.story_id = s.story_id AND n.type_id = 4) AS likes, (SELECT COUNT(DISTINCT sv.ip_address) as story_views FROM story_views sv WHERE sv.story_id = s.story_id) AS views  FROM stories s, categories cat, tags t, tag_connect tc, countries coun, bloggers b, continents cont WHERE s.blogger_id = ".$blogger_id." AND s.story_id = tc.story_id AND tc.tag_id = t.tag_id AND b.blogger_id = s.blogger_id AND cat.category_id = s.category_id AND coun.country_id = s.country_id AND cont.continent_id = s.continent_id";
            } else {
                if ($map > 0) {
                    $sql_select = "SELECT s.*, coun.*, cont.* FROM stories s, tags t, tag_connect tc, countries coun, continents cont WHERE  s.story_id = tc.story_id AND tc.tag_id = t.tag_id AND coun.country_id = s.country_id AND cont.continent_id = s.continent_id";
                } else {
                    $sql_select = "SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.* FROM stories s, categories cat, tags t, tag_connect tc, countries coun, bloggers b, continents cont WHERE b.blogger_id = s.blogger_id  AND s.story_id = tc.story_id AND tc.tag_id = t.tag_id AND  cat.category_id = s.category_id AND coun.country_id = s.country_id AND cont.continent_id = s.continent_id";
                }
            }
            foreach($filters as $filter){
                $filter = explode(':', $filter);
                if ($filter[0] == 'continent') {
                    $continents_count++;
                    if (is_numeric($filter[1])) {
                        $continents[] = $filter[1];
                    }
                } elseif ($filter[0] == 'tag') {
                    if ($filter[1] != '') {
                        $tags[] = $filter[1];
                    }
                } elseif ($filter[0] == 'favourites') {
                    if ($blogger_id == 0) {
                        $get_favourites = true;
                    }
                } elseif ($filter[0] == 'last_story') {
                    $getmorestories = $filter[1];
                }

            }

            if ($continents_count > 1){
                $sql_select .= " AND (";
                foreach($continents as $this_continent) {
                    $sql_select .= "s.continent_id = ".$this_continent." OR ";
                }
                $sql_select = substr($sql_select,0 , strlen($sql_select) - 3).")";

            } elseif ($continents_count == 1){
                if ($continents[0] != 0) {
                    $sql_select .= " AND s.continent_id = ".$continents[0];
                }
            }


            if (count($tags) > 1){
                $sql_select .= " AND (";
                foreach($tags as $this_tag) {
                    $sql_select .= "t.slug = '".$this_tag."' OR ";
                }
                $sql_select = substr($sql_select,0 , strlen($sql_select) - 3).")";

            } elseif (count($tags) == 1){
                if ($tags[0] != '') {
                    $sql_select .= " AND t.slug = '".$tags[0]."'";
                }
            }

            if ($get_favourites && !empty($user)) {
                $my_favourites = $this->get_following($user['blogger_id']);
                if (is_array($my_favourites) && !empty($my_favourites)) {
                    $sql_select .= " AND (";
                    foreach($my_favourites as $my_favourite) {
                        $sql_select .= "s.blogger_id = ".$my_favourite." OR ";
                    }
                    $sql_select = substr($sql_select,0 , strlen($sql_select) - 3).")";
                } else {
                    $return_empty = true;
                }
            }
            if ($getmorestories > 0) {

                $story = $this->get_story($getmorestories);
                $sql_select .= " AND s.date_posted < '".$story['date_posted']."'";

            }
            $query = $this->db->query($sql_select.' GROUP BY s.story_id ORDER BY s.date_posted DESC LIMIT '.$limit);

        } else {

            if ($blogger_id > 0) {
                $query = $this->db->query('SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.*  FROM stories s, categories cat, countries coun, bloggers b, continents cont  WHERE s.blogger_id = "'.$blogger_id.'" AND b.blogger_id = s.blogger_id AND cat.category_id = s.category_id AND coun.country_id = s.country_id AND cont.continent_id = coun.continent_id GROUP BY s.story_id ORDER BY date_posted DESC LIMIT '.$limit);
            } else {
                if ($story_id > 0) {
                    if ($random > 0) {
                        $query = $this->db->query('SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.* FROM stories s, categories cat, countries coun, bloggers b, continents cont  WHERE cat.category_id = s.category_id AND b.blogger_id = s.blogger_id AND s.story_id != "'.$story_id.'" AND coun.country_id = s.country_id AND cont.continent_id = coun.continent_id GROUP BY s.story_id ORDER BY RAND() LIMIT '.$limit);
                    } else {
                        $query = $this->db->query('SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.* FROM stories s, categories cat, countries coun, bloggers b, continents cont  WHERE cat.category_id = s.category_id AND b.blogger_id = s.blogger_id AND s.story_id != "'.$story_id.'" AND coun.country_id = s.country_id AND cont.continent_id = coun.continent_id GROUP BY s.story_id ORDER BY date_posted DESC LIMIT '.$limit);
                    }
                } else {
                    if ($map > 0) {
                        $query = $this->db->query('SELECT s.*
                        FROM stories s
                         GROUP BY s.story_id ORDER BY RAND() LIMIT '.$limit);
                    } else {
                        if ($random > 0) {
                            $query = $this->db->query('SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.* FROM stories s, categories cat, countries coun, bloggers b, continents cont  WHERE cat.category_id = s.category_id AND b.blogger_id = s.blogger_id AND coun.country_id = s.country_id AND cont.continent_id = coun.continent_id GROUP BY s.story_id ORDER BY RAND() LIMIT '.$limit);
                        } else {
                            $query = $this->db->query('SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.* FROM stories s, categories cat, countries coun, bloggers b, continents cont  WHERE cat.category_id = s.category_id AND b.blogger_id = s.blogger_id AND coun.country_id = s.country_id AND cont.continent_id = coun.continent_id GROUP BY s.story_id ORDER BY date_posted DESC LIMIT '.$limit);
                        }
                    }
                }
            }

        }
        if (isset($return_empty)) {
            return 'favourites';
        } else {
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {

                    // return the user's validation link to reset their password.
                    $this_story = $this->objectToArray($rows);
                    $this_story['link_tags'] = $this->deal_with_tags(null, 'link_retrieve', $rows->story_id);
                    $this_story['class_tags'] = $this->deal_with_tags(null, 'class_retrieve', $rows->story_id);
                    $this_story['filter_tags'] = $this->deal_with_tags(null, 'filter_retrieve', $rows->story_id);
                    $this_story['likes'] = $this->crunch_numbers($this_story['likes']);
                    $this_story['dated'] = $this->facebook_style_date_time(strtotime($this_story['date_posted']));
                    //$this_story['comments'] = $this->get_comments($rows->story_id, 99999, 0, null, 1);

                    $stories[] = $this_story;

                }
                return $stories;
            } else {
                if (isset($getmorestories)  &&  ($getmorestories > 0)) {
                    return 'end_of_results';
                } else {
                    return false;
                }
            }
        }
    }
    public function get_story($unique_id = 0, $blogger_id = 0, $random = 0) {
        if ($random > 0) {
            $query = $this->db->query('SELECT s.story_id, s.slug, b.username FROM stories s, bloggers b WHERE b.blogger_id = s.blogger_id ORDER BY RAND() LIMIT 1');
        } else {
            if ($blogger_id > 0) {
                if ($unique_id > 0) {
                    $query = $this->db->query('SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.* FROM stories s, categories cat, countries coun, bloggers b, continents cont  WHERE s.blogger_id = "'.$blogger_id.'" AND s.story_id = "'.$unique_id.'" AND b.blogger_id = s.blogger_id AND cat.category_id = s.category_id AND coun.country_id = s.country_id AND cont.continent_id = coun.continent_id');
                } else {
                    $query = $this->db->query('SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.* FROM stories s, categories cat, countries coun, bloggers b, continents cont  WHERE s.blogger_id = "'.$blogger_id.'" AND s.slug="'.$unique_id.'" AND b.blogger_id = s.blogger_id AND cat.category_id = s.category_id AND coun.country_id = s.country_id AND cont.continent_id = coun.continent_id');
                }
            } else {
                if ($unique_id > 0) {
                    $query = $this->db->query('SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.* FROM stories s, categories cat, countries coun, bloggers b, continents cont  WHERE s.story_id = "'.$unique_id.'" AND b.blogger_id = s.blogger_id AND cat.category_id = s.category_id AND coun.country_id = s.country_id AND cont.continent_id = coun.continent_id');
                } else {
                    $query = $this->db->query('SELECT s.*, cat.category_name, coun.nicename, coun.iso, b.*, cont.* FROM stories s, categories cat, countries coun, bloggers b, continents cont  WHERE s.slug="'.$unique_id.'" AND b.blogger_id = s.blogger_id AND cat.category_id = s.category_id AND coun.country_id = s.country_id AND cont.continent_id = coun.continent_id');
                }
            }
        }



        if ($query->num_rows() > 0) {
            $this_story = array();
            foreach ($query->result() as $rows) {
                // return the user's validation link to reset their password.
                $this_story = $this->objectToArray($rows);
                if ($random == 0) {
                    $this_story['link_tags'] = $this->deal_with_tags(null, 'link_retrieve', $rows->story_id);
                    $this_story['class_tags'] = $this->deal_with_tags(null, 'class_retrieve', $rows->story_id);
                    $this_story['filter_tags'] = $this->deal_with_tags(null, 'filter_retrieve', $rows->story_id);
                    $this_story['dated'] = $this->facebook_style_date_time(strtotime($this_story['date_posted']));
                }

            }
        } else {
            return false;
        }
        return $this_story;

    }
    public function crunch_numbers($number) {
        if (($number > 999) && ($number < 10000)) {
            $second_digit = substr($number, 1, 1);
            if ($second_digit == '0') {
                $number = substr($number, 0, 1).' k';
            } else {
                $number = substr($number, 0, 1).'.'.substr($number, 1, 1).' k';
            }
        } elseif (($number > 9999) && ($number < 99999)) {
            $number = substr($number, 0, 2).' k';
        } elseif (($number > 99999) && ($number < 999999)) {
            $number = substr($number, 0, 3).' k';
        } elseif (($number > 999999)) {
            $number = substr($number, 0, 1).' m';
        }
        return $number;
    }
    public function notify_followers($blogger_id = 0, $story_id = 0) {
        if ($blogger_id > 0 && $story_id > 0) {
            $query = $this->db->query('SELECT * FROM follow_connect fc, bloggers b  WHERE fc.followed_id = "'.$blogger_id.'" AND b.blogger_id= fc.follower_id');

            if ($query->num_rows() > 0) {

                foreach ($query->result() as $rows) {
                    $data = array(
                        'doer_id' => $blogger_id,
                        'accepter_id' => $rows->blogger_id,
                        'type_id' => 3,
                        'story_id' => $story_id
                    );
                    $this->db->insert('notifications', $data);
                }
            }
        }
    }
    public function add_story($blogger_id, $folder, $title, $description, $country, $location, $story_tags, $story, $story_photo) {

        $tags_dealt_with = $this->deal_with_tags($story_tags);
       // $check_category_exists =  $this->check_exist($category, 'category_id', 'categories');
        $check_country_exists =  $this->check_exist($country, 'country_id', 'countries');

        if (is_array($tags_dealt_with) && $check_country_exists) {

            $title = strip_tags($title);
            $description = strip_tags($description);
            $story = htmlspecialchars(str_replace('src="assets/uploads', base_url().'assets/uploads/', $story));

            $the_slug = $this->makeSlugs(trim($title));
            $get_slug =  $this->check_exist($the_slug, 'slug', 'stories', $blogger_id);
            $inc_me = 0;
            while ($get_slug == true) {
                $inc_me++;
                $the_slug = $this->makeSlugs(trim($title.' '.$inc_me));
                $get_slug = $this->check_exist($the_slug, 'slug', 'stories');
            }

            $story_folder = md5($the_slug);
            $temp_story_folder_path = APPPATH."../../assets/users/".$folder."/story_temp/";
            $story_folder_path = APPPATH."../../assets/users/".$folder."/stories/".$story_folder;

            if (!file_exists($story_folder_path)) {
                mkdir($story_folder_path, 0777);
            }

            if (file_exists($temp_story_folder_path.'/'.$story_photo)) {
                $temp_story_photo = $temp_story_folder_path.'/'.$story_photo;
            } else {
                $temp_story_photo = APPPATH."../../assets/users/default_story.png";
            }
            copy($temp_story_photo, $story_folder_path.'/'.$story_photo);
            $country_data = $this->get_country_nice($country);

            $continent = $country_data[0]->continent_id;
            $data = array(
                'blogger_id' => $blogger_id,
                'story_title' => $title,
                'description' => $description,
                'story_cover' => $story_photo,
                'album' => $story_folder,
                'slug' => $the_slug,
                //'category_id' => $category,
                'continent_id' => $continent,
                'country_id' => $country,
                'location' => $location,
                'story' => $story
            );

            if ($this->db->insert('stories', $data)) {
                $story_id = $this->db->insert_id();

                $this->notify_followers($blogger_id, $story_id);

                foreach ($tags_dealt_with as $tag) {
                    $data = array(
                        'tag_id' => $tag,
                        'story_id' => $story_id
                    );
                    $this->db->insert('tag_connect', $data);
                }
                return $the_slug;
            }
        } else {
            return false;
        }

    }

    public function delete_story($story_id, $blogger_id) {

        if($this->get_story($story_id, $blogger_id)){

            $this->db->where_in( 'story_id', $story_id );
            $this->db->delete('stories');

            $this->db->where_in( 'story_id', $story_id );
            $this->db->delete('tag_connect');

            return true;
        } else {
            return false;
        }

    }


    public function update_story($story_id, $blogger_id, $folder, $title, $description, $country, $location, $story_tags, $story, $story_photo, $old_story, $old_slug) {
        $title = trim(strip_tags(htmlentities($title)));
        $tags_dealt_with = $this->deal_with_tags($story_tags);
        //$check_category_exists =  $this->check_exist($category, 'category_id', 'categories');
        $check_country_exists =  $this->check_exist($country, 'country_id', 'countries');

        if (is_array($tags_dealt_with) && $check_country_exists) {


            if ($title != $old_story['story_title']) {
                $the_slug = $this->makeSlugs($title);
                $get_slug =  $this->check_exist($the_slug, 'slug', 'stories', $blogger_id);
                $inc_me = 0;

                while ($get_slug == true) {
                    $inc_me++;
                    $the_slug = $this->makeSlugs(trim($title.' '.$inc_me));
                    $get_slug = $this->check_exist($the_slug, 'slug', 'stories');
                }
            } else {
                $the_slug = $old_story['slug'];
            }
            $story_folder = $old_story['album'];
            $temp_story_folder_path = APPPATH."../../assets/users/".$folder."/story_temp/";
            $story_folder_path = APPPATH."../../assets/users/".$folder."/stories/".$story_folder;

            if (!file_exists($story_folder_path)) {
                mkdir($story_folder_path, 0777);
            }

            if (file_exists($temp_story_folder_path.'/'.$story_photo)) {
                $temp_story_photo = $temp_story_folder_path.'/'.$story_photo;
            } else {
                $temp_story_photo = APPPATH."../../assets/users/default_story.png";
            }
            copy($temp_story_photo, $story_folder_path.'/'.$story_photo);

            $country_data = $this->get_country_nice($country);

            $continent = $country_data[0]->continent_id;
            $data = array(
                'story_title' => $title,
                'description' => $description,
                'story_cover' => $story_photo,
                'album' => $story_folder,
                'slug' => $the_slug,
                //'category_id' => $category,
                'continent_id' => $continent,
                'country_id' => $country,
                'location' => $location,
                'story' => $story
            );

            if ($this->db->update('stories', $data, array('story_id' => $story_id))) {


                    $this->db->where_in( 'story_id', $story_id );
                    $this->db->delete('tag_connect');
                    foreach ($tags_dealt_with as $tag) {
                    $data = array(
                        'tag_id' => $tag,
                        'story_id' => $story_id
                    );
                    $this->db->insert('tag_connect', $data);
                }
                return $the_slug;
            }
        } else {
            return false;
        }

    }

    function my_str_split($string)
    {
        $slen=strlen($string);
        for($i=0; $i<$slen; $i++)
        {
            $sArray[$i]=$string{$i};
        }
        return $sArray;
    }

    function noDiacritics($string)
    {
        //cyrylic transcription
        $cyrylicFrom = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $cyrylicTo   = array('A', 'B', 'W', 'G', 'D', 'Ie', 'Io', 'Z', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Ch', 'C', 'Tch', 'Sh', 'Shtch', '', 'Y', '', 'E', 'Iu', 'Ia', 'a', 'b', 'w', 'g', 'd', 'ie', 'io', 'z', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ch', 'c', 'tch', 'sh', 'shtch', '', 'y', '', 'e', 'iu', 'ia');


        $from = array("Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
        $to   = array("A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");


        $from = array_merge($from, $cyrylicFrom);
        $to   = array_merge($to, $cyrylicTo);

        $newstring=str_replace($from, $to, $string);
        return $newstring;
    }

    function makeSlugs($string, $maxlen=0)
    {
        $newStringTab=array();
        $string=strtolower($this->noDiacritics($string));
        if(function_exists('str_split'))
        {
            $stringTab=str_split($string);
        }
        else
        {
            $stringTab=my_str_split($string);
        }

        $numbers=array("0","1","2","3","4","5","6","7","8","9","-");
        //$numbers=array("0","1","2","3","4","5","6","7","8","9");

        foreach($stringTab as $letter)
        {
            if(in_array($letter, range("a", "z")) || in_array($letter, $numbers))
            {
                $newStringTab[]=$letter;
                //print($letter);
            }
            elseif($letter==" ")
            {
                $newStringTab[]="-";
            }
        }

        if(count($newStringTab))
        {
            $newString=implode($newStringTab);
            if($maxlen>0)
            {
                $newString=substr($newString, 0, $maxlen);
            }

            $newString = $this->removeDuplicates('--', '-', $newString);
        }
        else
        {
            $newString='';
        }

        return $newString;
    }


    function checkSlug($sSlug)
    {
        if(ereg ("^[a-zA-Z0-9]+[a-zA-Z0-9\_\-]*$", $sSlug))
        {
            return true;
        }

        return false;
    }

    function removeDuplicates($sSearch, $sReplace, $sSubject)
    {
        $i=0;
        do{

            $sSubject=str_replace($sSearch, $sReplace, $sSubject);
            $pos=strpos($sSubject, $sSearch);

            $i++;
            if($i>100)
            {
                die('removeDuplicates() loop error');
            }

        }while($pos!==false);

        return $sSubject;
    }
    public function check_exist($check_me, $type = '', $table, $blogger_id = 0) {
        if ($blogger_id > 0){
            $this->db->where('blogger_id', $blogger_id);
        }
        $this->db->where($type, $check_me);

        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function objectToArray($d) {
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        return $d;
    }
}



?>