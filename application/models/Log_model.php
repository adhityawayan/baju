<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 10/09/2016
 * Time: 23:21
 */
class Log_model extends Base_model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save($param)
    {
        $sql        = $this->db->insert_string('m_log',$param);
        $ex         = $this->db->query($sql);
        return $this->db->affected_rows($sql);
    }
}