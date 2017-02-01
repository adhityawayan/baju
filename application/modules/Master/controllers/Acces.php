<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:10
 */
class Acces extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('acces_model','model');
        $this->load->model('partner_model','pmodel');

        $this->session->set_flashdata('parent_menu_active', 'master');
        $this->session->set_flashdata('child_menu_active', 'accessories');
    }

    public function index()
    {
        role(MODUL_ACCESSORIES_SEWA_BAJU,'read');

        $data = array(
            'header_title' => 'Accessories',
            'header_desc' => 'Master',
            'link_add' => site_url('master/acces/add'),
            'link_edit' => site_url('master/acces/update/'),
            'link_import' => site_url('master/acces/import'),
            'link_delete' => site_url('master/acces/delete'),
            'data' => $this->model->getAll()
        );
        $content = 'acces/v_acces_table';

        $this->pinky->output($data,$content);
    }

    public function add()
    {
        role(MODUL_ACCESSORIES_SEWA_BAJU,'create');

        $data = array(
            'header_title' => 'Form Accessories',
            'header_desc' => 'Master',
            'link_back' => site_url('master/acces'),
            'link_act' => site_url('master/acces/do_add'),
            'partner' => $this->pmodel->getAll(),
        );
        $content = 'acces/v_acces_add';
        $this->pinky->output($data,$content);
    }

    public function do_add()
    {
        role(MODUL_ACCESSORIES_SEWA_BAJU,'create');

        $code = $this->model->getKode();
        $name = $this->input->post('name');
        $rent_price = $this->input->post('rent_price');
//        $sale_price = $this->input->post('sale_price');
        $partner = $this->input->post('partner');

        $data = array(
            'code' => $code,
            'name' => $name,
            'rent_price' => $rent_price,
//            'sale_price' => $sale_price,
            'partner' => $partner,
        );
        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Accessories '.$name);
        $result = $this->model->create($data);
        if($result)
        {
            alert();
            redirect('master/acces');
        }
    }

    public function update($id)
    {
        role(MODUL_ACCESSORIES_SEWA_BAJU,'update');

        $data = array(
            'header_title' => 'Update Accessories',
            'header_desc' => 'Master',
            'link_back' => site_url('master/acces'),
            'link_act' => site_url('master/acces/do_update'),
            'd' => $this->model->getId($id),
            'partner' => $this->pmodel->getAll(),
        );

        $content = 'acces/v_acces_update';
        $this->pinky->output($data,$content);
    }

    public function do_update()
    {
        role(MODUL_ACCESSORIES_SEWA_BAJU,'update');

        $name = $this->input->post('name');
        $rent_price = $this->input->post('rent_price');
//        $sale_price = $this->input->post('sale_price');
        $partner = $this->input->post('partner');

        $id = $this->input->post('id');

        $data = array(
            'name' => $name,
            'rent_price' => $rent_price,
//            'sale_price' => $sale_price,
            'partner' => $partner,
        );

        $condition['id']= $id;
        $result = $this->model->update($id,$data);
        helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Accessories '.$name);
        if($result)
        {
            alert(2);
            redirect('master/acces');
        }
    }

    public function delete($id)
    {
        role(MODUL_ACCESSORIES_SEWA_BAJU,'delete');
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Accessories ID '.$id);
        $data['status'] = '1';
        $result = $this->model->update($id,$data);
        if($result)
        {
            alert(3);
        }
    }

    public function import()
    {
        role(MODUL_ACCESSORIES_SEWA_BAJU,'create');

        $data = array(
            'header_title' => 'Import Accessories',
            'header_desc' => 'Master',
            'link_back' => site_url('master/acces'),
            'link_act' => site_url('master/acces/do_import'),
            'link_download' => base_url('uploads/master/template_accessories.xlsx'),
        );

        $content = 'acces/v_acces_import';
        $this->pinky->output($data,$content);
    }

    public function do_import()
    {
        role(MODUL_ACCESSORIES_SEWA_BAJU,'create');

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
                "rent_price"=> $rowData[0][1],
                "code" => $this->model->getkode()
            );

//            return var_dump($data);

            //sesuaikan nama dengan nama tabel
            $insert = $this->model->create($data);

        }
        unlink($media['full_path']);
        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Accessories Dengan Import ');
        alert();
        redirect('master/acces');
    }
}