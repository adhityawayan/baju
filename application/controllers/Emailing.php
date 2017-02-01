<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 05/01/2017
 * Time: 11:15
 */
class Emailing extends My_controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function thanks()
    {
        $this->load->view('pinky/email/thanks');
    }
}