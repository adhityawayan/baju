<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 10/09/2016
 * Time: 21:37
 */

if(! function_exists('alert'))
{
    function alert($success=1)
    {
        $CI = & get_instance();
        switch($success)
        {
            case 0:
                $CI->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\"> <button class=\"close\" data-close=\"alert\"></button> Gagal Disimpan</div></div>");
                break;
            case 1:
                $CI->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\"><button class=\"close\" data-close=\"alert\"></button>Data berhasil disimpan</div></div>");
                break;
            case 2:
                $CI->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\"><button class=\"close\" data-close=\"alert\"></button>Data berhasil diupdate</div></div>");
                break;
            case 3:
                $CI->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-success\" id=\"alert\"><button class=\"close\" data-close=\"alert\"></button>Data berhasil dihapus</div></div>");
                break;
        }
    }
}