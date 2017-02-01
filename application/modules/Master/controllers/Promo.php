<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:10
 */
class Promo extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('promo_model','model');
        $this->load->model('kategori_model','kmodel');

        $this->session->set_flashdata('parent_menu_active', 'master');
        $this->session->set_flashdata('child_menu_active', 'promo');
    }

    public function index()
    {
        role(MODUL_PROMO_SEWA_BAJU,'read');

        $data = array(
            'header_title' => 'Promo',
            'header_desc' => 'Master',
            'link_add' => site_url('master/promo/add'),
            'link_edit' => site_url('master/promo/update/'),
            'link_delete' => site_url('master/promo/delete'),
            'data' => $this->model->getAll(),
        );
        $content = 'promo/v_promo_table';

        $this->pinky->output($data,$content);
    }

    public function add()
    {
        role(MODUL_PROMO_SEWA_BAJU,'create');

        $data = array(
            'header_title' => 'Form Promo',
            'header_desc' => 'Master',
            'link_back' => site_url('master/promo'),
            'link_act' => site_url('master/promo/do_add'),
            'kategori' => $this->kmodel->getAll(),
        );
        $content = 'promo/v_promo_add';
        $this->pinky->output($data,$content);
    }

    public function do_add()
    {
        role(MODUL_PROMO_SEWA_BAJU,'create');

        $name = $this->input->post('name');
        $note = $this->input->post('note');
        $disc = $this->input->post('disc');
        $qty = $this->input->post('qty');
        $kategori = $this->input->post('kategori');

        $data = array(
            'name' => $name,
            'note' => $note,
            'disc' => $disc,
            'qty' => $qty,
            'kategori' => $kategori,
        );

        $result = $this->model->create($data);
        if($result)
        {
            helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Promo '.$name);
            alert();
            redirect('master/promo');
        }
    }

    public function update($id)
    {
        role(MODUL_PROMO_SEWA_BAJU,'update');

        $data = array(
            'header_title' => 'Update Promo',
            'header_desc' => 'Master',
            'link_back' => site_url('master/promo'),
            'link_act' => site_url('master/promo/do_update'),
            'd' => $this->model->getId($id),
            'kategori' => $this->kmodel->getAll(),
        );

        $content = 'promo/v_promo_update';
        $this->pinky->output($data,$content);
    }

    public function do_update()
    {
        role(MODUL_PROMO_SEWA_BAJU,'update');

        $name = $this->input->post('name');
        $note = $this->input->post('note');
        $disc = $this->input->post('disc');
        $qty = $this->input->post('qty');
        $kategori = $this->input->post('kategori');

        $id = $this->input->post('id');

        $data = array(
            'name' => $name,
            'note' => $note,
            'disc' => $disc,
            'qty' => $qty,
            'kategori' => $kategori,
        );

        $condition['id']= $id;
        $result = $this->model->update($id,$data);
        if($result)
        {
            helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Promo '.$name);
            alert(2);
            redirect('master/promo');
        }
    }

    public function delete($id)
    {
        role(MODUL_PROMO_SEWA_BAJU,'delete');

        $data['status'] = '1';
        $result = $this->model->update($id,$data);
        if($result)
        {
            helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Promo ID '.$id);
            alert(3);
        }
    }
}