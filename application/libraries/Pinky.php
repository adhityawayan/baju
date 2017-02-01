<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 11:43
 */
class Pinky
{
    protected 	$ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    public function output($data=null, $content)
    {
        $this->ci->load->view('pinky/template/header', $data);
        $this->ci->load->view('pinky/template/sidebar', $data);
        $this->ci->load->view($content, $data);
        $this->ci->load->view('pinky/template/footer', $data);
    }
}