<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:26
 */
class Baju_model extends Base_model
{
    protected $table = 'm_baju';
    protected $tritem = 'tr_item';
    protected $mcustomer = 'm_customer';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('kategori_model','mkategori');
        $this->load->model('type_model','mtype');
        $this->load->model('partner_model','mpartner');
    }

    public function getAll()
    {
        $pagedata = $this->getData($this->table,array('status'=>0))->result();

        foreach($pagedata as $key=>$row)
        {
            $pagedata[$key]->mkategori = $this->mkategori->getId($row->kategori);
            $pagedata[$key]->mtype = $this->mtype->getId($row->type);
            $pagedata[$key]->mpartner = $this->mpartner->getId($row->partner);
        }

        if($pagedata)
        {
            return $pagedata;
        }
        return [];
    }

    public function getId($id)
    {
        $condition['id']=$id;
        $pagedata = $this->getData($this->table,$condition)->row();
        $pagedata->mkategori = $this->mkategori->getId($pagedata->kategori);
        $pagedata->mpartner = $this->mpartner->getId($pagedata->partner);

        if($pagedata)
        {
            return $pagedata;
        }
        return [];
    }

    public function create($data=array())
    {
        $query = $this->addData($this->table,$data);
        if($query)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function update($id,$data=array())
    {
        $condition['id'] = $id;
        $query = $this->updateData($this->table,$data,$condition);
        if($query)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function delete($id)
    {
        $condition['id']=$id;
        $query = $this->deleteData($this->table,$condition);
        if($query)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getkode()
    {
        $kode = $this->getkodeunik($this->table,'BA');
        return $kode;
    }

    public function getCustomerRentById($id)
    {
        $result = $this->getData($this->tritem,array('baju_id'=>$id))->result();
        foreach($result as $key=>$row)
        {
            $result[$key]->mcustomer = $this->getData($this->mcustomer,array('id'=>$row->customer_id))->row();
        }

        if($result)
        {
            return $result;
        }
        return [];
    }

}