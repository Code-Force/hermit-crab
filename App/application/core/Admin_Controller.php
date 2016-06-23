<?php

class Admin_Controller extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        if($this->data['user']['group'] !== 'admin')
        {
            show_error('Shove off, this is for admins.');
        }
    }
}