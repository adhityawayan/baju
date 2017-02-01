<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 04/11/2016
 * Time: 15:36
 */
class Role extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_model','model');

        $this->session->set_flashdata('parent_menu_active', 'setting');
        $this->session->set_flashdata('child_menu_active', 'user_group');
    }

    public function access($id)
    {
        $data = array(
            'header_title' => 'Form Role',
            'header_desc' => 'Master',
            'link_back' => site_url('setting/group'),
            'link_act' => site_url('setting/role/do_access'),
            'id' => $id,
            'role' => $this->model->getByGroup($id)
        );

//        return var_dump($data['role']);
        $content = 'role/v_role_add';
        if($data['role'])
        {
            $data['link_act'] = site_url('setting/role/update_access');
            $content = 'role/v_role_update';
        }

        $this->pinky->output($data,$content);
    }

    public function update_access()
    {
        $group_id = $this->input->post('group_id');
        $attr = $this->input->post('attr');
        $id = $this->input->post('id');

//        return var_dump($id);
//        helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Role Akses ');

        foreach($id as $key=>$val)
        {
            $row = isset($attr[$val])?$attr[$val]:[];

            $data['c'] = isset($row['c'])?$row['c']:0;
            $data['r'] = isset($row['r'])?$row['r']:0;
            $data['u'] = isset($row['u'])?$row['u']:0;
            $data['d'] = isset($row['d'])?$row['d']:0;

            $id = $val;

//            return var_dump($data);

            $this->model->update($id,$data);
        }

        alert();
        redirect('setting/role/access/'.$group_id);
    }

    public function do_access()
    {
        $group_id = $this->input->post('group_id');
        $attr = $this->input->post('attr');

        foreach(modul() as $key=>$val)
        {
            $data['group_id'] = $group_id;
            $data['modul'] = $key;
            $m = $attr[$key];
            $data['c'] = isset($m['c'])?'1':'0';
            $data['r'] = isset($m['r'])?'1':'0';
            $data['u'] = isset($m['u'])?'1':'0';
            $data['d'] = isset($m['d'])?'1':'0';

            $this->model->create($data);
        }
        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Role Akses');
        alert();
        redirect('setting/role/access/'.$group_id);
    }
}