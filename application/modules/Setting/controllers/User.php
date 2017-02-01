<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:10
 */
class User extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model','model');
        $this->load->model('group_model','gmodel');

        $this->session->set_flashdata('parent_menu_active', 'setting');
        $this->session->set_flashdata('child_menu_active', 'user');

    }

    public function index()
    {
        role(MODUL_USER_SEWA_BAJU,'read');

        $data = array(
            'header_title' => 'User',
            'header_desc' => 'Master',
            'link_add' => site_url('setting/user/add'),
            'link_edit' => site_url('setting/user/update/'),
            'link_delete' => site_url('setting/user/delete'),
            'data' => $this->model->getAll()
        );

        if($this->user_level() != 1)
        {
            $data['data'] = $this->model->getRowId($this->user_id());
        }

        $content = 'user/v_user_table';

        $this->pinky->output($data,$content);
    }

    public function add()
    {
        role(MODUL_USER_SEWA_BAJU,'create');

        $data = array(
            'header_title' => 'Form User',
            'header_desc' => 'Master',
            'link_back' => site_url('setting/user'),
            'link_act' => site_url('setting/user/do_add'),
            'group' => $this->gmodel->getAll()
        );
        $content = 'user/v_user_add';
        $this->pinky->output($data,$content);
    }

    public function do_add()
    {
        role(MODUL_USER_SEWA_BAJU,'create');

        $name = $this->input->post('name');
        $username = $this->input->post('username');
        $group_id = $this->input->post('group_id');
        $password = md5($this->input->post('password'));

        $data = array(
            'name' => $name,
            'username' => $username,
            'group_id' => $group_id,
            'password' => $password,
        );

        $result = $this->model->create($data);
        if($result)
        {
            helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'User '.$name);
            alert();
            redirect('setting/user');
        }
    }

    public function update($id)
    {
        role(MODUL_USER_SEWA_BAJU,'update');

        $data = array(
            'header_title' => 'Update User',
            'header_desc' => 'Master',
            'link_back' => site_url('setting/user'),
            'link_act' => site_url('setting/user/do_update'),
            'd' => $this->model->getId($id),
            'group' => $this->gmodel->getAll()
        );

        $content = 'user/v_user_update';
        $this->pinky->output($data,$content);
    }

    public function do_update()
    {
        role(MODUL_USER_SEWA_BAJU,'update');

        $name = $this->input->post('name');
        $username = $this->input->post('username');
        $group_id = $this->input->post('group_id');

        $id = $this->input->post('id');

        $data = array(
            'name' => $name,
            'group_id' => $group_id,
            'username' => $username,
        );
        if($this->input->post('password'))
        {
            $data['password'] = md5($this->input->post('password'));
        }
        $condition['id']= $id;
        $result = $this->model->update($id,$data);
        if($result)
        {
            helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'User '.$name);
            alert(2);
            redirect('setting/user');
        }
    }

    public function delete($id)
    {
        role(MODUL_USER_SEWA_BAJU,'delete');

        $result = $this->model->delete($id);
        if($result)
        {
            helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'User ID'.$id);
            alert(3);
        }
    }
}