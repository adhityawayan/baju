<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/12/2016
 * Time: 12:58
 */
class Labarugi extends My_controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('aruskas_model','model');
        /*active menu*/
        $this->session->set_flashdata('parent_menu_active', 'laporan');
        $this->session->set_flashdata('child_menu_active', 'labarugi');
    }

    public function index()
    {
        role(MODUL_LABARUGI_SEWA_BAJU,'read');

        $total =0;
        $baju = $this->model->getAllBaju();
        foreach($baju as $row)
        {
            $total = $total + (0-$row->hpp_price);
        }

        $data = array(
            'header_title' => 'Arus Kas',
            'header_desc' => 'Laporan',
            'linkinvoice' => site_url('laporan/labarugi/invoice/'),
            'baju' => $baju,
            'total' => $total
        );
        $content = 'labarugi/v_labarugi_table';
        $this->pinky->output($data,$content);
    }

    public function invoice($id)
    {
        $data = array(
            'header_title' => 'Invoice List',
            'header_desc' => 'Laporan',
            'rowdata' => $this->model->getInvoice($id),
            'linkback' => site_url('laporan/labarugi')
        );
        $content = 'labarugi/v_invoice_list';
        $this->pinky->output($data,$content);
    }
}