<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 03/12/2016
 * Time: 14:18
 */
class Privilege_model extends Base_model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function active($modul,$group_id,$act)
    {
        $table = 'm_role';
        $status=0;
        $condition['modul'] = $modul;
        $condition['group_id'] = $group_id;

        $result = $this->getData($table,$condition)->row();

        switch ($act)
        {
            case 'create':
                $status = $result->c;
                break;
            case 'read':
                $status = $result->r;
                break;
            case 'update':
                $status = $result->u;
                break;
            case 'delete':
                $status = $result->d;
                break;
        }

        if($status)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function appDetailById($id)
    {
        $m_appointment = 'm_appointment';
        $m_deal = 'm_deal';
        $m_customer = 'm_customer';

        $condition['id'] = $id;
        $result = $this->getData($m_appointment,$condition)->row();
        $result->mdeal = $this->getData($m_deal,array('appointment_id'=>$id))->row();
        $result->mcustomer = $this->getData($m_customer,array('id'=>$result->customer_id))->row();

        if($result)
        {
            return $result;
        }
        return [];
    }
}