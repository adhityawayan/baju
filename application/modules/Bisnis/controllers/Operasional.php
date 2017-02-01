<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 08/12/2016
 * Time: 14:19
 */
class Operasional extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('operasional_model', 'model');

        $this->session->set_flashdata('parent_menu_active', 'bisnis');
        $this->session->set_flashdata('child_menu_active', 'operasional');
    }

    public function index()
    {
        role(MODUL_OPERASIONAL_SEWA_BAJU, 'read');

        $data = array(
            'header_title' => 'Opersional',
            'header_desc' => 'Bisnis',
            'link_add' => site_url('bisnis/operasional/add'),
            'link_import' => site_url('bisnis/operasional/import'),
            'link_edit' => site_url('bisnis/operasional/update/'),
            'link_delete' => site_url('bisnis/operasional/delete'),
            'data' => $this->model->getAll()
        );
        $content = 'operasional/v_operasional_table';

        $this->pinky->output($data, $content);
    }

    public function add()
    {
        role(MODUL_OPERASIONAL_SEWA_BAJU, 'create');

        $data = array(
            'header_title' => 'Form Operasional',
            'header_desc' => 'Bisnis',
            'link_back' => site_url('bisnis/operasional'),
            'link_act' => site_url('bisnis/operasional/do_add'),
        );

        $content = 'operasional/v_operasional_add';
        $this->pinky->output($data, $content);
    }

    public function do_add()
    {
        role(MODUL_OPERASIONAL_SEWA_BAJU, 'create');

        $code = $this->model->getkode();
        $name = $this->input->post('name');
        $deskripsi = $this->input->post('deskripsi');
        $cost = $this->input->post('cost');
        $date = $this->input->post('date');

        $data = array(
            'code' => $code,
            'name' => $name,
            'deskripsi' => $deskripsi,
            'cost' => $cost,
            'date' => $date,
        );

        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Operasional '.$name);

        $result = $this->model->create($data);
        if ($result) {
            alert();
            redirect('bisnis/operasional');
        }
    }

    public function update($id)
    {
        role(MODUL_OPERASIONAL_SEWA_BAJU, 'update');

        $data = array(
            'header_title' => 'Update Operasional',
            'header_desc' => 'Bisnis',
            'link_back' => site_url('bisnis/operasional'),
            'link_act' => site_url('bisnis/operasional/do_update'),
            'd' => $this->model->getId($id)
        );

        $content = 'operasional/v_operasional_update';
        $this->pinky->output($data, $content);
    }

    public function do_update()
    {
        role(MODUL_OPERASIONAL_SEWA_BAJU, 'update');

        $name = $this->input->post('name');
        $deskripsi = $this->input->post('deskripsi');
        $cost = $this->input->post('cost');
        $date = $this->input->post('date');

        $id = $this->input->post('id');

        $data = array(
            'name' => $name,
            'deskripsi' => $deskripsi,
            'cost' => $cost,
            'date' => $date,
        );

        $condition['id'] = $id;
        $result = $this->model->update($id, $data);
        helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Operasional '.$name);
        if ($result) {
            alert(2);
            redirect('bisnis/operasional');
        }
    }

    public function delete($id)
    {
        role(MODUL_OPERASIONAL_SEWA_BAJU, 'delete');
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Operasional ID '.$id);
        $data['status'] = '1';
        $result = $this->model->update($id, $data);
        if ($result) {
            alert(3);
        }
    }

    public function import()
    {
        role(MODUL_KATEGORI_SEWA_BAJU, 'create');

        $data = array(
            'header_title' => 'Import Kategori',
            'header_desc' => 'Master',
            'link_back' => site_url('master/kategori'),
            'link_act' => site_url('master/kategori/do_import'),
            'link_download' => base_url('uploads/master/template_kategori.xlsx'),
        );

        $content = 'kategori/v_kategori_import';
        $this->pinky->output($data, $content);
    }

    public function do_import()
    {
        role(MODUL_KATEGORI_SEWA_BAJU, 'create');

        $this->load->library('Libexcel');

        $fileName = time() . $_FILES['file']['name'];

        $config['upload_path'] = './uploads/master/'; //buat folder dengan nama assets di root folder
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file'))
            $this->upload->display_errors();

        $media = $this->upload->data();

        $inputFileName = './uploads/master/' . $media['file_name'];

        $objPHPExcel = $this->libexcel->identifikasi($inputFileName);

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row = 2; $row <= $highestRow; $row++) {                  //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                NULL,
                TRUE,
                FALSE);

            //Sesuaikan sama nama kolom tabel di database
            $data = array(
                "name" => $rowData[0][0],
            );

            //sesuaikan nama dengan nama tabel
            $insert = $this->model->create($data);
            delete_files($media['file_path']);

        }
        alert();
        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Operasional Dengan Import ');
        redirect('bisnis/operasional');
    }
}