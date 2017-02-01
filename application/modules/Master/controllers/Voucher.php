<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:10
 */
class Voucher extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('voucher_model','model');

        $this->session->set_flashdata('parent_menu_active', 'master');
        $this->session->set_flashdata('child_menu_active', 'voucher');
    }

    public function index()
    {
        role(MODUL_VOUCHER_SEWA_BAJU,'read');

        $data = array(
            'header_title' => 'Voucher',
            'header_desc' => 'Master',
            'link_add' => site_url('master/voucher/add'),
            'link_edit' => site_url('master/voucher/update/'),
            'link_delete' => site_url('master/voucher/delete'),
            'data' => $this->model->getAll(),
        );
        $content = 'voucher/v_voucher_table';

        $this->pinky->output($data,$content);
    }

    public function add()
    {
        role(MODUL_VOUCHER_SEWA_BAJU,'create');

        $data = array(
            'header_title' => 'Form Voucher',
            'header_desc' => 'Master',
            'link_back' => site_url('master/voucher'),
            'link_act' => site_url('master/voucher/do_add'),
        );
        $content = 'voucher/v_voucher_add';
        $this->pinky->output($data,$content);
    }

    public function do_add()
    {
        role(MODUL_VOUCHER_SEWA_BAJU,'create');

        $code = $this->input->post('code');
        $disc = $this->input->post('disc');
        $due_date = $this->input->post('due_date');

        $data = array(
            'code' => $code,
            'disc' => $disc,
            'due_date' => $due_date
        );

        $result = $this->model->create($data);
        if($result)
        {
            helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Voucher '.$code);
            alert();
            redirect('master/voucher');
        }
    }

    public function update($id)
    {
        role(MODUL_VOUCHER_SEWA_BAJU,'update');

        $data = array(
            'header_title' => 'Update Voucher',
            'header_desc' => 'Master',
            'link_back' => site_url('master/voucher'),
            'link_act' => site_url('master/voucher/do_update'),
            'd' => $this->model->getId($id),
        );

        $content = 'voucher/v_voucher_update';
        $this->pinky->output($data,$content);
    }

    public function do_update()
    {
        role(MODUL_VOUCHER_SEWA_BAJU,'update');

        $code = $this->input->post('code');
        $disc = $this->input->post('disc');
        $due_date = $this->input->post('due_date');

        $data = array(
            'code' => $code,
            'disc' => $disc,
            'due_date' => $due_date
        );

        $id = $this->input->post('id');

        $condition['id']= $id;
        $result = $this->model->update($id,$data);
        if($result)
        {
            helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Voucher '.$code);
            alert(2);
            redirect('master/voucher');
        }
    }

    public function delete($id)
    {
        role(MODUL_VOUCHER_SEWA_BAJU,'delete');

        $data['status'] = '1';
        $result = $this->model->update($id,$data);
        if($result)
        {
            helper_log("delete", $this->session->userdata('name').LANG_ADD_LOG.'Voucher ID'.$id);
            alert(3);
        }
    }
}