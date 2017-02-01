<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:26
 */
class User_model extends Base_model
{
    protected $table = 'm_user';
    protected $table_group = 'm_group';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $pagedata = $this->get($this->table)->result();
        foreach($pagedata as $key=>$row)
        {
            $pagedata[$key]->status = $row->active?'Aktif':'Tidak';
            $pagedata[$key]->mgroup = $this->getData($this->table_group,array('id'=>$row->group_id))->row();
        }
        if($pagedata)
        {
            return $pagedata;
        }
        return [];
    }

    public function getRowId($id)
    {
        $condition['id']=$id;
        $pagedata = $this->getData($this->table,$condition)->result();
        foreach($pagedata as $key=>$row)
        {
            $pagedata[$key]->status = $row->active?'Aktif':'Tidak';
            $pagedata[$key]->mgroup = $this->getData($this->table_group,array('id'=>$row->group_id))->row();
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

}