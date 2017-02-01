<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 03/08/2016
 * Time: 8:37
 */
class Base_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get($table,$orderby='DESC',$by='id')
    {
        $this->db->select("*");
        $this->db->from($table);
        $this->db->order_by($table.'.'.$by, $orderby);
        return $this->db->get();
    }

    function getData($table, $condition,$orderby='DESC',$by='id')
    {
        $this->db->where($condition);
        $this->db->select("*");
        $this->db->from($table);
        $this->db->order_by($table.'.'.$by, $orderby);

        return $this->db->get();
    }

    function addData($table,$data)
    {
        $query = $this->db->insert($table, $data);
        if($query)
        {
            return TRUE;
        }

        return FALSE;
    }

    function getLastInsertId()
    {
        return $this->db->insert_id();
    }

    function updateData($table, $data, $condition)
    {
        $this->db->where($condition);
        $query = $this->db->update($table, $data);
        if($query)
        {
            return TRUE;
        }
        return FALSE;
    }

    function deleteData($table, $condition)
    {
        $this->db->where($condition);
        $query = $this->db->delete($table);
        if($query)
        {
            return TRUE;
        }
        return FALSE;
    }

    function pagingData($table,$num,$offset,$text)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->limit($num, $offset);
        if($text!=NULL) {
            $this->db->like($table . '.name', $text);
        }
        $this->db->order_by($table.'.id', 'DESC');
        return $this->db->get();
    }

    function likeData($table,$text)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->like($table . '.name', $text);
        $this->db->order_by($table.'.id', 'DESC');
        return $this->db->get();
    }

    public function getkodeunik($table,$kode='TR',$total=5) {
        $q = $this->db->query("SELECT MAX(id) AS idmax FROM ".$table);
        if($q->num_rows()>0){ //jika data ada
            foreach($q->result() as $k){
                $kd = ((int)$k->idmax)+1; //string kode diset ke integer dan ditambahkan 1 dari kode terakhir
//                $kd = sprintf("%04s", $tmp); //kode ambil 4 karakter terakhir
            }
        }else{ //jika data kosong diset ke kode awal
            $kd = "1";
        }
        //mulai bikin kode
        $bikin_kode = str_pad($kd, $total, "0", STR_PAD_LEFT);
        $kode_jadi = "$kode$bikin_kode";

        return $kode_jadi;
    }

    public function groupBy($table)
    {
        $this->db->select('SUM(grand_total) as total, MONTH(date) as month, YEAR(date) as year');
        $this->db->from($table);
        $this->db->group_by('MONTH(date)');
        return $this->db->get();
    }

    public function getSumCurrentMonth($table,$month)
    {
        $this->db->select('SUM(grand_total) as total');
        $this->db->from($table);
        $this->db->where('MONTH(date)',$month);
        $this->db->where('YEAR(date)',date('Y'));
        return $this->db->get();
    }

    public function getLimit($table,$limit,$order='id')
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->limit(0, $limit);
        $this->db->order_by($table.'.'.$order, 'ASC');
        return $this->db->get();
    }
}