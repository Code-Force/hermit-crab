<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Signout extends Auth_Controller {


    function __construct() {
        parent::__construct();
        $this->load->model('bloggers_model');
    }

    public function index()
    {

        $this->bloggers_model->logout();
        
        redirect('/signin', 'refresh');

    }


}

?>