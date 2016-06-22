    <?php
class Connecttwitter extends Auth_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
        $this->load->model('write_model');
        $this->load->library('form_builder');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    function index() {
        $this->load->library('twitteroauth');

        if ($this->bloggers_model->check_logged()) {
            $gotosettings = true;
        }
        $CONSUMER_KEY='rFQovuqdFnRVsUvwxXiQmg';
        $CONSUMER_SECRET='43tJZCHj4htZq78JvcZ1uuJzILRETMVwoSPBD1DxNc';

        $OAUTH_CALLBACK='http://travelledwriters.com/connecttwitter/oauth';



        $vars = array();

        // This page is limited to non logged in members. Check and redirect if logged in

        $name = $this->session->userdata('name');
        $twitter_id = $this->session->userdata('twitter_id');


        $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);

        $request_token = $connection->getRequestToken($OAUTH_CALLBACK); //get Request Token

        if(	$request_token)
        {
            $token = $request_token['oauth_token'];
            $this->session->set_userdata('request_token', $token);
            $this->session->set_userdata('request_token_secret', $request_token['oauth_token_secret']);

            switch ($connection->http_code)
            {
                case 200:
                    $url = $connection->getAuthorizeURL($token);
                    //redirect to Twitter .

                    header('Location: ' . $url);
                    break;
                default:
                    //echo "Coonection with twitter Failed";
                    redirect('signup/errortwitter', 'redirect');
                    break;
            }

        }
        else //error receiving request token
        {
            //echo "Error Receiving Request Token";
            redirect('signup/errortwitter', 'redirect');
        }


    }
    function oauth() {

        $this->load->library('twitteroauth');


        $oauth_token = $this->input->get('oauth_token');
        if(isset($oauth_token))
        {
            $CONSUMER_KEY='rFQovuqdFnRVsUvwxXiQmg';
            $CONSUMER_SECRET='43tJZCHj4htZq78JvcZ1uuJzILRETMVwoSPBD1DxNc';

            $oauth_verifier = $this->input->get('oauth_verifier');


            $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $this->session->userdata('request_token'), $this->session->userdata('request_token_secret'));
            $access_token = $connection->getAccessToken($oauth_verifier, $oauth_token);

            if($access_token)
            {


                $connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
                $params =array();
                $params['include_entities']='false';
                $content = $connection->get('account/verify_credentials',$params);

                if($content && isset($content->screen_name) && isset($content->name))
                {
                    if ($this->bloggers_model->check_logged()) {
                        $data = $this->bloggers_model->get_user($this->session->userdata['username']);
                        $data = array(
                            'twitter_id'  => $content->id_str,
                            'twitter_link' => 'http://www.twitter.com/'.$content->screen_name,
                        );
                        $this->session->set_userdata($data);

                    } else {
                        $data = array(
                            'twitter_id'  => $content->id_str,
                            'twitter_link' => 'http://www.twitter.com/'.$content->screen_name,
                            'username'    => $content->screen_name,
                            'fullname' => $content->name
                        );
                        $this->session->set_userdata($data);

                    }
                    //redirect to main page.
                    header('Location: /signup/twitter');

                }
                else
                {
                    //echo "<h4> Login Error </h4>";
                    redirect('signup/errortwitter', 'redirect');
                }
            }

            else
            {

                //echo "<h4> Login Error </h4>";
                redirect('signup/errortwitter', 'redirect');
            }
        }

    }
}
