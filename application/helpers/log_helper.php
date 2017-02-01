<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 10/09/2016
 * Time: 22:30
 */
if(!function_exists('helper_log'))
{
    function helper_log($tipe = "", $str = "")
    {
        $CI = & get_instance();

        if (strtolower($tipe) == "login"){
            $log_tipe   = LOG_LOGIN;
        }
        elseif(strtolower($tipe) == "logout")
        {
            $log_tipe   = LOG_LOGOUT;
        }
        elseif(strtolower($tipe) == "add"){
            $log_tipe   = LOG_ADD;
        }
        elseif(strtolower($tipe) == "edit"){
            $log_tipe  = LOG_EDIT;
        }
        else{
            $log_tipe  = LOG_DELETE;
        }

        // paramter
        $param['name']      = $CI->session->userdata('name');
        $param['tipe']      = $log_tipe;
        $param['activity']  = $str;

        //load model log
        $CI->load->model('log_model');

        //save to database
        $CI->log_model->save($param);

    }
}

if(!function_exists('role'))
{
    function role($modul,$act)
    {
        $CI = & get_instance();

        $level = $CI->session->level;

        /*Call Status*/
        $result = $CI->privilege_model->active($modul,$level,$act);

        if(!$result)
        {
            redirect('welcome/denied');
        }
        return TRUE;
    }
}

if(!function_exists('app_for_log'))
{
    function app_for_log($id)
    {
        $CI = & get_instance();

        $result = $CI->privilege_model->appDetailById($id);
        return $result;
    }
}
