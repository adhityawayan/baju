<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 15/09/2016
 * Time: 13:23
 */

if(! function_exists('rupiah'))
{
    function rupiah($nilai, $pecahan = 0)
    {
        return number_format($nilai, $pecahan, ',', '.');
    }
}

if(!function_exists('diskon'))
{
    function diskon($persen,$total)
    {
        if($persen!=0)
        {
            $ppersen = $persen/100;
            $pure = $total*$ppersen;
            return $pure;
        }
        else
        {
            return 0;
        }

    }

}

if(!function_exists('modul'))
{
    function modul()
    {
        return array(
            MODUL_USER_SEWA_BAJU => 'User',
            MODUL_COMPANY_SEWA_BAJU => 'Company',
            MODUL_USER_GROUP_SEWA_BAJU => 'User Group',
            MODUL_KATEGORI_SEWA_BAJU => 'Kategori',
            MODUL_BAJU_SEWA_BAJU => 'Baju',
            MODUL_CUSTOMER_SEWA_BAJU => 'Customer',
            MODUL_PARTNER_SEWA_BAJU => 'Partner',
            MODUL_PROMO_SEWA_BAJU => 'Promo',
            MODUL_ACCESSORIES_SEWA_BAJU => 'Accessories',
            MODUL_TYPE_SEWA_BAJU => 'Type',
            MODUL_APPOINTMENT_SEWA_BAJU => 'Appointment',
            MODUL_HISTORY_SEWA_BAJU => 'History',
            MODUL_ARUSKAS_SEWA_BAJU => 'Arus Kas',
            MODUL_LABARUGI_SEWA_BAJU => 'Laba Rugi',
            MODUL_OPERASIONAL_SEWA_BAJU => 'Operasional',
            MODUL_VOUCHER_SEWA_BAJU => 'Voucher',
            MODUL_LOG_SEWA_BAJU => 'Log Activity',
        );
    }
}

if(!function_exists('status_customer'))
{
    function status_customer()
    {
        return array(
            STATUS_APPOINTMENT => 'Appointment',
            STATUS_DEAL => 'Deal',
            STATUS_SIAP_AMBIL => 'Siap Ambil',
            STATUS_DIPINJAM => 'Out',
            STATUS_KEMBALI => 'Return'
        );
    }
}

if(!function_exists('proses'))
{
    function proses()
    {
        return array(
            PROSES_RENT => 'Rent',
            PROSES_MADE_FOR_RENT => 'Made For Rent',
            PROSES_MADE_FOR_SALE => 'Made For Sale',
            PROSES_SALE => 'Sale',
        );
    }
}

if(!function_exists('shipping'))
{
    function shipping()
    {
        return array(
            SHIPPING_PICKUP => 'Pick Up',
            SHIPPING_TO => 'Shipped To'
        );
    }
}

if(!function_exists('pay'))
{
    function pay()
    {
        return array(
            PAY_CASH => 'CA',
            PAY_CREDIT => 'CR',
            PAY_DEBIT => 'DB',
            PAY_TRANSFER => 'TR',
        );
    }
}

if(!function_exists('status_return'))
{
    function status_return()
    {
        return array(
            RETURN_COMPLETE => 'Complete',
            RETURN_RUSAK => 'Rusak',
            RETURN_TELAT => 'Telat',
        );
    }
}

if(!function_exists('deposit_status'))
{
    function deposit_status()
    {
        return array(
            DEPOSIT_STATUS_BELUM => 'Belum',
            DEPOSIT_STATUS_SUDAH => 'Sudah'
        );
    }
}

if(!function_exists('log_status'))
{
    function log_status()
    {
        return array(
            LOG_LOGIN => 'Login',
            LOG_LOGOUT => 'Logout',
            LOG_ADD => 'Add',
            LOG_EDIT => 'Edit',
            LOG_DELETE => 'Delete'
        );
    }
}


