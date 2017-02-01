<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 21/10/2016
 * Time: 10:07
 */
class Dashboard_model extends Base_model
{
    protected $tritem = 'tr_item';
    protected $trpromo = 'tr_promo';
    protected $mcustomer = 'm_customer';
    protected $mbaju = 'm_baju';
    protected $mdeal = 'm_deal';
    protected $maccessories = 'm_accessories';
    protected $mappointment = 'm_appointment';

    public function __construct()
    {
        parent::__construct();
    }

    public function getDataAllTr()
    {
        $data = $this->getData($this->tritem,array('returned'=>NULL))->result();
        foreach($data as $key=>$val)
        {
            $data[$key]->mcustomer = $this->getData($this->mcustomer,array('id'=>$val->customer_id))->row();
            $data[$key]->mbaju = $this->getData($this->mbaju,array('id'=>$val->baju_id))->row();
            $data[$key]->mdeal = $this->getData($this->mdeal,array('appointment_id'=>$val->appointment_id))->row();
        }

        if($data)
        {
            return $data;
        }
        return [];
    }

    public function getFittingDate()
    {
        $data = $this->getData($this->mdeal,array('fitting'=>NULL))->result();
        foreach($data as $key=>$row)
        {
            $data[$key]->mcustomer = $this->getData($this->mcustomer,array('id'=>$row->customer_id))->row();
        }
        if($data)
        {
            return $data;
        }
        return [];
    }

    public function getTrItem()
    {
        $result = $this->getData($this->mappointment,array('deleted'=>'0'))->result();
        foreach($result as $k=>$row) {
            $condition['back_status !='] = '1';
            $condition['baju_id !='] = '0';
            $condition['appointment_id'] = $row->id;
            $mdeal = $this->getData($this->mdeal,array('appointment_id'=>$row->id))->row();
            if($mdeal->process != PROSES_SALE)
            {
                $result[$k]->tritem = $this->getData($this->tritem, $condition)->result();
                foreach ($result[$k]->tritem as $key => $row)
                {
                    $result[$k]->tritem[$key]->mcustomer = $this->getData($this->mcustomer, array('id' => $row->customer_id))->row();
                    $result[$k]->tritem[$key]->mbaju = $this->getData($this->mbaju, array('id' => $row->baju_id))->row();
                }
            }
        }

        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getTrPromo()
    {
        $result = $this->getData($this->mappointment,array('deleted'=>'0'))->result();
        foreach($result as $k=>$row) {
            $condition['back_status !='] = '1';
            $condition['baju_id !='] = '0';
            $condition['appointment_id'] = $row->id;
            $result[$k]->trpromo = $this->getData($this->trpromo, $condition)->result();
            foreach ($result[$k]->trpromo as $key => $row) {
                $result[$k]->trpromo[$key]->mcustomer = $this->getData($this->mcustomer, array('id' => $row->customer_id))->row();
                $result[$k]->trpromo[$key]->mbaju = $this->getData($this->mbaju, array('id' => $row->baju_id))->row();
            }
        }

        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getAppointmentDeal()
    {
        $condition['created_at'] = date('Y-m-d');
        $condition['deleted !='] = '1';
        $result = $this->getData($this->mappointment,$condition)->result();
        foreach($result as $k=>$ap)
        {
            $result[$k]->mdeal = $this->getData($this->mdeal,array('appointment_id'=>$ap->id))->row();
        }
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getAppointment()
    {
        $condition['deleted !='] = '1';
        $result = $this->getData($this->mappointment,$condition)->result();
        foreach($result as $k=>$ap)
        {
            $result[$k]->mdeal = $this->getData($this->mdeal,array('appointment_id'=>$ap->id))->row();
        }
        if($result)
        {
            return $result;
        }
        return [];
    }
}