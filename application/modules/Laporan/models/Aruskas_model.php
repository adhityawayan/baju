<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 25/11/2016
 * Time: 11:11
 */
class Aruskas_model extends Base_model
{
    protected $mdeal = 'm_deal';
    protected $mappointemnt = 'm_appointment';
    protected $tritem = 'tr_item';
    protected $trpromo = 'tr_promo';
    protected $mcompany = 'm_company';
    protected $mbaju = 'm_baju';
    protected $moperasional = 'm_operasional';
    protected $mcustomer = 'm_customer';

    public function __construct()
    {
        parent::__construct();
    }

    public function getDeal($from,$to)
    {
        $result = $this->getData($this->mappointemnt,array('deleted'=>'0'))->result();
        foreach($result as $keyapp=>$app)
        {
            $condition['date_dp >= '] = $from;
            $condition['date_dp <= '] = $to;
            $condition['appointment_id'] = $app->id;
            $result[$keyapp]->mdeal = $this->getData($this->mdeal,$condition)->result();

            foreach($result[$keyapp]->mdeal as $key=>$row)
            {
                $result[$keyapp]->mdeal[$key]->mappointment = $this->getData($this->mappointemnt,array('id'=>$row->appointment_id))->row();
                $result[$keyapp]->mdeal[$key]->tritem = $this->getData($this->tritem,array('appointment_id'=>$row->appointment_id))->result();
            }
        }

        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getOperasional($from,$to)
    {
        $condition['date >= '] = $from;
        $condition['date <= '] = $to;
        $condition['status'] = '0';
        $result = $this->getData($this->moperasional,$condition)->result();

        if($result)
        {
            return $result;
        }
        return [];

    }

    public function getIdBaju($id)
    {
        $result = $this->getData($this->mbaju,array('id'=>$id))->row();

        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getCompany()
    {
        $result = $this->getData($this->mcompany,array('id'=>1))->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getAllBaju()
    {
        $condition['partner']=0;
        $appointment = array();

        $result = $this->getData($this->mbaju,$condition)->result();
        foreach($result as $key=>$row)
        {
            $trData = $this->getData($this->tritem,array('baju_id'=>$row->id))->result();
            $trPromo = $this->getData($this->trpromo,array('baju_id'=>$row->id))->result();
            $result[$key]->tritem = $trData;
            $result[$key]->trpromo = $trPromo;
            $result[$key]->disewa = count($trData)+count($trPromo);
            $result[$key]->balance = $row->hpp_price<0?abs($row->hpp_price):0-$row->hpp_price;
        }

        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getInvoice($id)
    {
        $appointment_id = array();
        $appointmentData = array();

        $condition['id'] = $id;
        $result = $this->getData($this->mbaju,$condition)->row();
        $tritem = $this->getData($this->tritem,array('baju_id'=>$id))->result();
        $trpromo = $this->getData($this->trpromo,array('baju_id'=>$id))->result();
        foreach($tritem as $key=>$row)
        {
            $appointment_id[] = $row->appointment_id;
        }

        foreach($trpromo as $key=>$row)
        {
            $appointment_id[] = $row->appointment_id;
        }
        $appointmentlist = array_unique($appointment_id);

        foreach($appointmentlist as $row)
        {
            $data = $this->getData($this->mappointemnt,array('id'=>$row))->row();
            $data->mcustomer = $this->getData($this->mcustomer,array('id'=>$data->customer_id))->row();
            $data->mdeal = $this->getData($this->mdeal,array('appointment_id'=>$row))->row();
            $appointmentData[] = $data;
        }

        $appointment = count($appointmentlist);

        $result->count = $appointment;
        $result->appointment = $appointmentData;
        if($result)
        {
            return $result;
        }
        return [];
    }
}