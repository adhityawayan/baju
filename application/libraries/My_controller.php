<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 01/09/2016
 * Time: 4:03
 */
class My_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!$this->is_logged_in())
        {
            redirect('auth/login');
        }
    }

    public function is_logged_in()
    {
        $user = $this->session->userdata('user_id');
        return isset($user);
    }

    public function user_id()
    {
        $user = $this->session->userdata('user_id');
        return $user;
    }

    public function user_name()
    {
        $name = $this->session->userdata('name');
        return $name;
    }

    public function user_level()
    {
        $level = $this->session->userdata('level');
        return $level;
    }

}