<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 30/12/2016
 * Time: 19:39
 */
class Log extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('log_model','model');

        $this->session->set_flashdata('parent_menu_active', 'setting');
        $this->session->set_flashdata('child_menu_active', 'log');
    }

    public function index()
    {
        role(MODUL_LOG_SEWA_BAJU,'read');

        $data = array(
            'header_title' => 'Log',
            'header_desc' => 'Master',
            'data' => $this->model->getAll()
        );

        $content = 'log/v_log_table';

        $this->pinky->output($data,$content);
    }
}