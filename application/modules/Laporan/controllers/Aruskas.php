<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 25/11/2016
 * Time: 11:08
 */
class Aruskas extends My_controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('aruskas_model','model');

        /*active menu*/
        $this->session->set_flashdata('parent_menu_active', 'laporan');
        $this->session->set_flashdata('child_menu_active', 'aruskas');
    }

    public function index()
    {
        role(MODUL_ARUSKAS_SEWA_BAJU,'read');

        $data = array(
            'header_title' => 'Arus Kas',
            'header_desc' => 'Master',
        );
        $content = 'aruskas/v_aruskas_form';
        $this->pinky->output($data,$content);
    }

    public function report()
    {
        role(MODUL_ARUSKAS_SEWA_BAJU,'read');

        $tempData = array();
        $debit_total = array();
        $kredit_total = array();
        $piutang_total = array();

        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $mapp = $this->model->getDeal($date_from,$date_to);
        $moperasional = $this->model->getOperasional($date_from,$date_to);
//        return var_dump($moperasional);

//        return var_dump($mapp);

        foreach($mapp as $keyapp=>$app)
        {
            if($app->mdeal)
            {
                foreach($app->mdeal as $row)
                {
                    $tritem = $row->tritem;

                    $kredit = array();

                    foreach($tritem as $item)
                    {
                        $result = $this->model->getIdBaju($item->baju_id);
                        $partner = $result->partner;

                        if($partner)
                        {
                            $kredit[] = $result->konsinyasi;
                        }
                    }

                    $totkredit = array_sum($kredit);

                    $status = $row->mappointment->status;

                    $debit = $row->down_payment;
                    $piutang = $row->remaining_payment;

                    if($status > STATUS_SIAP_AMBIL)
                    {
                        $debit = $row->total - $totkredit;
                        $piutang = 0;
                    }

                    $tempData[] = array(
                        'invoice' => $row->mappointment->code,
                        'tanggal' => $row->date_dp,
                        'keterangan' => proses()[$row->process],
                        'debit' => 'Rp. '. rupiah($debit),
                        'kredit' => 'Rp. '.rupiah($totkredit),
                        'piutang' => 'Rp. '.rupiah($piutang)
                    );

                    $debit_total[] = $debit;
                    $kredit_total[] = $totkredit;
                    $piutang_total[] = $piutang;
                }
            }
        }

        foreach($moperasional as $row)
        {
            $tempData[] = array(
                'invoice' => $row->code,
                'tanggal' => $row->date,
                'keterangan' => $row->name.' - '.$row->deskripsi,
                'debit' => 'Rp. '. rupiah(0),
                'kredit' => 'Rp. '.rupiah($row->cost),
                'piutang' => 'Rp. '.rupiah(0)
            );

            $kredit_total[] = $row->cost;
        }

//        return var_dump($tempData);

        $data = array(
            'header_title' => 'Arus Kas',
            'header_desc' => 'Master',
            'deal' => $tempData,
            'total_debit' => rupiah(array_sum($debit_total)),
            'total_kredit' => rupiah(array_sum($kredit_total)),
            'total_piutang' => rupiah(array_sum($piutang_total)),
            'from' => $date_from,
            'to' => $date_to
        );

        $content = 'aruskas/v_aruskas_table';

        $this->pinky->output($data,$content);
    }

    public function print_aruskas($from,$to)
    {
        $tempData = array();
        $debit_total = array();
        $kredit_total = array();
        $piutang_total = array();

        $date_from = $from;
        $data_to = $to;
        $mdeal = $this->model->getDeal($date_from,$data_to);

        foreach($mdeal as $row)
        {
            $tritem = $row->tritem;

            $kredit = array();

            foreach($tritem as $item)
            {
                $result = $this->model->getIdBaju($item->baju_id);
                $partner = $result->partner;

                if($partner)
                {
                    $kredit[] = $result->konsinyasi;
                }
            }

            $totkredit = array_sum($kredit);

            $status = $row->mappointment->status;

            $debit = $row->down_payment;
            $piutang = $row->remaining_payment;

            if($status > STATUS_SIAP_AMBIL)
            {
                $debit = $row->total - $totkredit;
                $piutang = 0;
            }

            $tempData[] = array(
                'invoice' => $row->mappointment->code,
                'tanggal' => $row->date_dp,
                'keterangan' => 'Status - '.status_customer()[$row->mappointment->status],
                'debit' => 'Rp. '. rupiah($debit),
                'kredit' => 'Rp. '.rupiah($totkredit),
                'piutang' => 'Rp. '.rupiah($piutang)
            );

            $debit_total[] = $debit;
            $kredit_total[] = $totkredit;
            $piutang_total[] = $piutang;
        }



//        return var_dump($tempData);

        $data = array(
            'header_title' => 'Arus Kas',
            'header_desc' => 'Master',
            'deal' => $tempData,
            'total_debit' => rupiah(array_sum($debit_total)),
            'total_kredit' => rupiah(array_sum($kredit_total)),
            'total_piutang' => rupiah(array_sum($piutang_total)),
            'company' => $this->model->getCompany()
        );

        $this->load->view('aruskas/v_aruskas_print',$data);
    }
}