<?php
class Auth extends Auth_Controller
{
    public function oauth($providername)
    {
        $key=$this->config->item($providername)['key'];
        $secret=$this->config->item($providername)['secret'];
        $this->load->helper('url');

        $this->load->spark('oauth/0.3.1');

        // Create an consumer from the config
        $consumer = $this->oauth->consumer(array(
            'key' => $key,
            'secret' => $secret,
        ));

        // Load the provider
        $provider = $this->oauth->provider($providername, array());

        // Create the URL to return the user to
        $callback = site_url('auth/oauth/'.$provider->name);

        if ( ! $this->input->get_post('oauth_token'))
        {
            // Add the callback URL to the consumer
            $consumer->callback($callback);

            // Get a request token for the consumer
            $token = $provider->request_token($consumer);

            // Store the token
            $this->session->set_userdata('oauth_token', base64_encode(serialize($token)));

            // Get the URL to the twitter login page
            $url = $provider->authorize($token, array(
                'oauth_callback' => $callback,
            ));

            // Send the user off to login
            redirect($url);
        }
        else
        {
            if ($this->session->userdata('oauth_token'))
            {
                // Get the token from storage
                $token = unserialize(base64_decode($this->session->userdata('oauth_token')));
            }

            if ( ! empty($token) AND $token->access_token !== $this->input->get_post('oauth_token'))
            {
                // Delete the token, it is not valid
                $this->session->unset_userdata('oauth_token');

                // Send the user back to the beginning
                exit('invalid token after coming back to site');
            }

            // Get the verifier
            $verifier = $this->input->get_post('oauth_verifier');

            // Store the verifier in the token
            $token->verifier($verifier);

            // Exchange the request token for an access token
            $token = $provider->access_token($consumer, $token);

            // We got the token, let's get some user data
            $user = $provider->get_user_info($consumer, $token);


            $this->saveData($providername,$token,$user);
        }
    }

    public function oauth2($providername)
    {

        $key=$this->config->item($providername)['key'];
        $secret=$this->config->item($providername)['secret'];

        $this->load->helper('url_helper');

        $this->load->spark('oauth2/0.4.0');

        $provider = $this->oauth2->provider($providername, array(
            'id' => $key,
            'secret' => $secret,
        ));

        if ( ! $this->input->get('code'))
        {
            // By sending no options it'll come back here
            $provider->authorize();
        }
        else
        {
            // Howzit?
            try
            {
                $token = $provider->access($_GET['code']);
                $user = $provider->get_user_info($token);
                $this->saveData($providername,$token,$user);

            }

            catch (OAuth2_Exception $e)
            {
                show_error('That didnt work: '.$e);
            }

        }
    }


    private function saveData($providername,$token,$user)
    {
        //var_dump($user);
        //return;
        $usertoken= $token->access_token;
        $usersecret= $token->secret;

        $uid=$user['uid'];

        $nickname= array_key_exists('nickname',$user)?$user['nickname']:$uid;
        $name =array_key_exists('name',$user)? $user['name']:null;
        $location= array_key_exists('location',$user)?$user['location']:null;
        $description= array_key_exists('description',$user)?$user['description']:null;
        $profileimage=array_key_exists('image',$user)? $user['image']:null;
        $email=array_key_exists('email',$user)? $user['email']:'';

        $userobj= array('username'=>$nickname,
            'uid'=>$uid,
            'name'=>$name,
            'email'=>$email,
            'location'=>$location,
            'token'=>$usertoken,
            'secret'=>$usersecret,
            'provider'=>$providername,
            'summary'=>$description,
            'profileurl'=>$profileimage,
        );

        $this->load->helper('url');

        $result=$this->db->query("select * from users where uid=? and provider=?",  array($uid,$providername));

        $id=0;
        if($result->row())
        {
            $this->db->where('id',$result->row()->id);
            $this->db->update('users',$userobj);
            $id= $result->row()->id;
        }
        else{
            $this->db->insert('users',$userobj);
            $id = $this->db->insert_id();

        }
        $this->load->library('session');
        $this->session->set_userdata('userid',$id);
        redirect('/profile/editprofile','refresh');

    }
}