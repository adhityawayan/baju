<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 03/11/2016
 * Time: 13:44
 */
class Company extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('company_model','model');

        $this->session->set_flashdata('parent_menu_active', 'setting');
        $this->session->set_flashdata('child_menu_active', 'company');
    }

    public function index()
    {
        role(MODUL_COMPANY_SEWA_BAJU,'read');

        $data = array(
            'header_title' => 'Company',
            'header_desc' => 'Master',
            'link_act' => site_url('setting/company/do_update'),
            'd' => $this->model->getId(1),
        );
        $content = 'company/v_company_add';

        $this->pinky->output($data,$content);
    }

    public function do_update()
    {
        role(MODUL_COMPANY_SEWA_BAJU,'update');

        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $email = $this->input->post('email');
        $term_condition = $this->input->post('term_condition');

        $id = $this->input->post('id');

        $data = array(
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'email' => $email,
            'term_condition' => $term_condition
        );

        $condition['id']= $id;

        $namelogo = "logo";
        $path = 'logo';

        $this->deletefileimages($path,$id);

        if($_FILES['logo'])
        {
            if($_FILES['logo']['size']!=0)
            {
                $resCover = $this->upload_image('logo',$namelogo,$path);
                $fileCov = $resCover['data'];
                $data['logo'] = $fileCov['file_name'];
            }

        }

        $result = $this->model->update($id,$data);
        if($result)
        {
            helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Company ');
            alert(2);
            redirect('setting/company');
        }
    }

    public function upload_image($input,$filename,$path)
    {

        $config['upload_path']          = './uploads/'.$path;
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['max_size']             = 2048;
        $config['file_name']            = $filename;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($input))
        {
            $error = $this->upload->display_errors();

            $data  =array(
                'status' => FALSE,
                'message' => $error
            );

            return $data;
        }
        else
        {
            $data = $this->upload->data();

            $data = array(
                'status' => TRUE,
                'message' => "Successfully upload Image",
                'data' => $data
            );

            return $data;
        }
    }

    public function deletefileimages($dir,$id)
    {
        $data = $this->model->getId($id);
        $file = $data->logo;
        if($file!=''){
            $path = "./uploads/".$dir."/".$file;
            $act = @unlink($path);
            return 'berhasil';
        }
        return 'gagal';
    }
}