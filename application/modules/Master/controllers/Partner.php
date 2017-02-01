<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:10
 */
class Partner extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('partner_model','model');

        $this->session->set_flashdata('parent_menu_active', 'master');
        $this->session->set_flashdata('child_menu_active', 'partner');
    }

    public function index()
    {
        role(MODUL_PARTNER_SEWA_BAJU,'read');

        $data['partner'] = $this->model->getAll();
        $data = array(
            'header_title' => 'Partner',
            'header_desc' => 'Master',
            'link_add' => site_url('master/partner/add'),
            'link_edit' => site_url('master/partner/update/'),
            'link_import' => site_url('master/partner/import'),
            'link_delete' => site_url('master/partner/delete'),
            'partner' => $this->model->getAll()
        );
        $content = 'partner/v_partner_table';

        $this->pinky->output($data,$content);
    }

    public function add()
    {
        role(MODUL_PARTNER_SEWA_BAJU,'create');

        $data = array(
            'header_title' => 'Form Partner',
            'header_desc' => 'Master',
            'link_back' => site_url('master/partner'),
            'link_act' => site_url('master/partner/do_add'),
        );
        $content = 'partner/v_partner_add';
        $this->pinky->output($data,$content);
    }

    public function do_add()
    {
        role(MODUL_PARTNER_SEWA_BAJU,'create');

        $name = $this->input->post('name');
        $code = $this->model->getkode();
        $born_date = $this->input->post('born_date');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $data = array(
            'code' => $code,
            'name' => $name,
            'born_date' => $born_date,
            'phone' => $phone,
            'address' => $address,
        );

        $result = $this->model->create($data);
        if($result)
        {
            helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Partner '.$name);
            alert();
            redirect('master/partner');
        }
    }

    public function update($id)
    {
        role(MODUL_PARTNER_SEWA_BAJU,'update');

        $data = array(
            'header_title' => 'Update Partner',
            'header_desc' => 'Master',
            'link_back' => site_url('master/partner'),
            'link_act' => site_url('master/partner/do_update'),
            'd' => $this->model->getId($id)
        );

        $content = 'partner/v_partner_update';
        $this->pinky->output($data,$content);
    }

    public function do_update()
    {
        role(MODUL_PARTNER_SEWA_BAJU,'update');

        $name = $this->input->post('name');
        $code = $this->model->getkode();
        $born_date = $this->input->post('born_date');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $id = $this->input->post('id');

        $data = array(
            'code' => $code,
            'name' => $name,
            'born_date' => $born_date,
            'phone' => $phone,
            'address' => $address,
        );

        $condition['id']= $id;
        $result = $this->model->update($id,$data);
        if($result)
        {
            helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Partner '.$name);
            alert(2);
            redirect('master/partner');
        }
    }

    public function delete($id)
    {
        role(MODUL_PARTNER_SEWA_BAJU,'delete');

        $data['status'] = '1';
        $result = $this->model->update($id,$data);
        if($result)
        {
            helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Partner ID '.$id);
            alert(3);
        }
    }

    public function import()
    {
        role(MODUL_PARTNER_SEWA_BAJU,'create');

        $data = array(
            'header_title' => 'Import Partner',
            'header_desc' => 'Master',
            'link_back' => site_url('master/partner'),
            'link_act' => site_url('master/partner/do_import'),
            'link_download' => base_url('uploads/master/template_partner.xlsx'),
        );

        $content = 'partner/v_partner_import';
        $this->pinky->output($data,$content);
    }

    public function do_import()
    {
        role(MODUL_PARTNER_SEWA_BAJU,'create');

        $this->load->library('Libexcel');

        $fileName = time().$_FILES['file']['name'];

        $config['upload_path'] = './uploads/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if(! $this->upload->do_upload('file') )
            $this->upload->display_errors();

        $media = $this->upload->data();

        $inputFileName = './uploads/'.$media['file_name'];

        $objPHPExcel = $this->libexcel->identifikasi($inputFileName);

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row <= $highestRow; $row++){                  //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                NULL,
                TRUE,
                FALSE);

            //Sesuaikan sama nama kolom tabel di database
            $data = array(
                "name"=> $rowData[0][0],
                "born_date"=> date('Y-m-d',$this->libexcel->convertDate($rowData[0][1])),
                "phone"=> $rowData[0][2],
                "address"=> $rowData[0][3],
                "code" => $this->model->getkode()
            );

//            return var_dump($data);

            //sesuaikan nama dengan nama tabel
            $insert = $this->model->create($data);
        }
        unlink($media['full_path']);
        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Partner Dengan Import');
        alert();
        redirect('master/partner');
    }
}