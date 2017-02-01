<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 01/09/2016
 * Time: 3:39
 */
class Auth_model extends Base_model
{
    public function check($username,$password)
    {
        $tabel = 'm_user';
        $condition['username'] = $username;
        $condition['password'] = md5($password);
        $condition['active'] = 1;

        $result = $this->getData($tabel,$condition);
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function time_log($id)
    {
        $table='m_user';
        $condition['id'] = $id;
        $data = array(
          'log_time' => date('Y-m-d H:i:s')
        );
        $this->updateData($table,$data,$condition);
    }
}