<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:10
 */
class Appointment extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appointment_model', 'model');
        $this->load->model('../../master/models/customer_model', 'cmodel');
        $this->load->model('deal_model', 'dmodel');
        $this->load->model('made_model', 'mmodel');

        $this->session->set_flashdata('parent_menu_active', 'bisnis');
        $this->session->set_flashdata('child_menu_active', 'appointment');
    }

    public function index()
    {
        role(MODUL_APPOINTMENT_SEWA_BAJU, 'read');

        $data = array(
            'header_title' => 'Appointment',
            'header_desc' => 'Master',
            'link_add' => site_url('bisnis/appointment/add'),
            'link_edit' => site_url('bisnis/appointment/update/'),
            'link_delete' => site_url('bisnis/appointment/delete'),
            'link_deal' => site_url('bisnis/appointment/deal/'),
            'link_invoice' => site_url('bisnis/appointment/invoice/'),
            'link_delivery' => site_url('bisnis/appointment/delivery/'),
            'link_returninvoice' => site_url('bisnis/appointment/returninvoice/'),
            'link_ajaxkembali' => site_url('bisnis/appointment/ajax_kembali/'),
            'link_ttd' => site_url('bisnis/appointment/signature/'),
            'link_ttdpickup' => site_url('bisnis/appointment/signaturepickup/'),
            'link_ttdreturn' => site_url('bisnis/appointment/signaturereturn/'),
            'link_process' => site_url('bisnis/appointment/process_detail/'),
            'data' => $this->model->getAll()
        );

        foreach ($data['data'] as $key => $row) {
            $data['data'][$key]->status_data = $row->status == STATUS_SIAP_AMBIL ? 'Pick Up' : 'Return';
            $data['data'][$key]->link_change = $row->status == STATUS_SIAP_AMBIL ? site_url('bisnis/appointment/pickup/' . $row->id) : site_url('bisnis/appointment/kembali/' . $row->id);
        }

        $content = 'appointment/v_appointment_table';

        $this->pinky->output($data, $content);
    }

    public function add()
    {
        $data = array(
            'header_title' => 'Form Appointment',
            'header_desc' => 'Master',
            'link_back' => site_url('bisnis/appointment'),
            'link_act' => site_url('bisnis/appointment/do_add'),
            'link_cus' => site_url('bisnis/appointment/form_customer'),
            'link_cus_id' => site_url('bisnis/appointment/historyCustomer'),
            'customer' => $this->cmodel->getAll()
        );
        $content = 'appointment/v_appointment_add';
        $this->pinky->output($data, $content);
    }

    public function do_add()
    {
        $code = $this->model->getkode();
        $date = $this->input->post('date');
        $customer_id = $this->input->post('customer_id');
        $note = $this->input->post('note');
        $user_id = $this->user_id();
        $created_at = date('Y-m-d');

        $data = array(
            'code' => $code,
            'date' => $date,
            'customer_id' => $customer_id,
            'note' => $note,
            'status' => 1,
            'user_id' => $user_id,
            'created_at' => $created_at
        );

        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.$code);

        $app_id = $this->model->create($data);
        if ($app_id) {
            $this->sendmail_appointment($app_id);
            alert();
            redirect('bisnis/appointment');
        }
    }

    public function update($id)
    {
        $data = array(
            'header_title' => 'Update Appointment',
            'header_desc' => 'Master',
            'link_back' => site_url('bisnis/appointment'),
            'link_act' => site_url('bisnis/appointment/do_update'),
            'd' => $this->model->getId($id),
            'customer' => $this->cmodel->getAll()
        );

        $content = 'appointment/v_appointment_update';
        $this->pinky->output($data, $content);
    }

    public function do_update()
    {
        $code = $this->input->post('code');
        $date = $this->input->post('date');
        $customer_id = $this->input->post('customer_id');
        $note = $this->input->post('note');
        $updated_at = date('Y-m-d');

        $id = $this->input->post('id');

        $data = array(
            'date' => $date,
            'customer_id' => $customer_id,
            'note' => $note,
            'updated_at' => $updated_at
        );

        $result = $this->model->update($id, $data);

        helper_log("add", $this->session->userdata('name').LANG_EDIT_LOG.$code);

        if ($result) {
            alert(2);
            redirect('bisnis/appointment');
        }
    }

    public function delete($id)
    {
        $app = $this->mode->getId($id);

        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.$app->code);

        $data['deleted'] = '1';
        $data['cancel'] = $cancel = $this->input->post('cancel');
        $result = $this->model->update($id, $data);

        if ($result) {
            alert(3);
        }
    }

    public function form_customer()
    {
        $data = array(
            'link_act' => site_url('bisnis/appointment/do_addcustomer'),
        );
        $this->load->view('appointment/v_customer_add', $data);
    }

    public function do_addcustomer()
    {
        $name = $this->input->post('name');
        $card = $this->cmodel->getkode();
        $born_date = $this->input->post('born_date');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');

        $data = array(
            'card' => $card,
            'name' => $name,
            'born_date' => $born_date,
            'phone' => $phone,
            'address' => $address,
        );

        helper_log("delete", $this->session->userdata('name').LANG_ADD_LOG.'Customer '.$name);

        $result = $this->cmodel->create($data);
        if ($result) {
            alert();
            redirect('bisnis/appointment/add');
        }
    }

    public function deal($id)
    {
        $data = array(
            'header_title' => 'Deal Appointment',
            'header_desc' => 'Master',
            'link_back' => site_url('bisnis/appointment'),
            'link_act' => site_url('bisnis/appointment/do_deal'),

            'link_baju' => site_url('bisnis/appointment/viewbaju'),
            'link_bajumaderent' => site_url('bisnis/appointment/viewbajumaderent'),
            'link_bajusale' => site_url('bisnis/appointment/viewbajusale'),
            'link_addbaju' => site_url('bisnis/appointment/addbaju'),
            'link_addbajusale' => site_url('bisnis/appointment/addbajusale'),
            'link_del_allitem' => site_url('bisnis/appointment/delete_item'),
            'link_del_iditem' => site_url('bisnis/appointment/delete_itemid'),
            'link_del_iditemformaster' => site_url('bisnis/appointment/delete_itemidformaster'),

            'link_accessories' => site_url('bisnis/appointment/viewaccessories'),
            'link_addaccessories' => site_url('bisnis/appointment/addaccessories'),
            'link_del_allaccessories' => site_url('bisnis/appointment/delete_accessories'),
            'link_del_idaccessories' => site_url('bisnis/appointment/delete_accessoriesid'),

            'link_jobs' => site_url('bisnis/appointment/viewjobs'),
            'link_addjobs' => site_url('bisnis/appointment/addjobs'),
            'link_del_alljobs' => site_url('bisnis/appointment/delete_jobs'),
            'link_del_idjobs' => site_url('bisnis/appointment/delete_jobsid'),

            'link_deposit' => site_url('bisnis/appointment/viewdeposit'),
            'link_adddeposit' => site_url('bisnis/appointment/adddeposit'),
            'link_del_alldeposit' => site_url('bisnis/appointment/delete_deposit'),
            'link_del_iddeposit' => site_url('bisnis/appointment/delete_depositid'),

            'link_made' => site_url('bisnis/appointment/viewmade'),
            'link_addmade' => site_url('bisnis/appointment/addmade'),
            'link_del_allmade' => site_url('bisnis/appointment/delete_made'),
            'link_del_idmade' => site_url('bisnis/appointment/delete_madeid'),

            'link_promo' => site_url('bisnis/appointment/viewpromo'),
            'link_addpromo' => site_url('bisnis/appointment/addpromo'),
            'link_del_allpromo' => site_url('bisnis/appointment/delete_promo'),
            'link_del_idpromo' => site_url('bisnis/appointment/delete_promoid'),

            'link_formtrpromo' => site_url('bisnis/appointment/form_promo'),
            'link_updatetrpromo' => site_url('bisnis/appointment/update_trpromo'),

            'link_formtritem' => site_url('bisnis/appointment/form_item'),
            'link_updatetritem' => site_url('bisnis/appointment/update_tritem'),

            'link_formtritemsale' => site_url('bisnis/appointment/form_itemsale'),
            'link_updatetritemsale' => site_url('bisnis/appointment/update_tritemsale'),

            'link_formmadesale' => site_url('bisnis/appointment/form_madesale'),
            'link_madeforrentact' => site_url('bisnis/appointment/do_form_madesale'),

            'link_urlvoucher' => site_url('bisnis/appointment/voucher'),

            'link_total_transaksi' => site_url('bisnis/appointment/totalTransaksi'),
            'link_invoice' => site_url('bisnis/appointment/invoice/' . $id),

            'link_lockdp' => site_url('bisnis/appointment/lockdp/'),

            'd' => $this->model->getId($id),
            'baju' => $this->model->getBaju(),
            'accessories' => $this->model->getAccessories(),
            'deal' => $this->dmodel->getDataByAppointment($id),
            'promo' => $this->model->getPromoAll()
        );

        if (count($data['deal'])) {
            $data['link_act'] = site_url('bisnis/appointment/update_deal');
        }

        $content = 'appointment/v_appointment_deal';
        $this->pinky->output($data, $content);
    }

    public function do_deal()
    {
        $appointment_id = $this->input->post('appointment_id');
        $customer_id = $this->input->post('customer_id');
        $date_borrow = $this->input->post('date_borrow');
        $date_pickup = $this->input->post('date_pickup');
        $date_back = $this->input->post('date_back');
        $date_fitting = $this->input->post('date_fitting');
        $down_payment = $this->input->post('down_payment');
        $date_dp = $this->input->post('date_dp');
        $pay_dp = $this->input->post('pay_dp');
        $remaining_payment = $this->input->post('remaining_payment');
        $date_rp = $this->input->post('date_rp');
        $pay_rp = $this->input->post('pay_rp');
        $total = $this->input->post('total');
        $note = $this->input->post('note');
        $deposit = $this->input->post('deposit');
        $fitting = $this->input->post('fitting');
        $process = $this->input->post('process');
        $shipping = $this->input->post('shipping');
        $shipping_address = $this->input->post('shipping_address');
        $shipping_cost = $this->input->post('shipping_cost');
        $promo = $this->input->post('promo');
        $code_voucher = $this->input->post('codevoucher');
        $disc_voucher = $this->input->post('discvoucher');

        if ($this->input->post('total')) {
            $data_up = array(
                'status' => STATUS_DEAL
            );

            $this->model->update($appointment_id, $data_up);
        }

        $data = array(
            'appointment_id' => $appointment_id,
            'customer_id' => $customer_id,
            'date_borrow' => $date_borrow,
            'date_back' => $date_back,
            'date_fitting' => $date_fitting,
            'down_payment' => $down_payment,
            'date_dp' => $date_dp,
            'pay_dp' => $pay_dp,
            'remaining_payment' => $remaining_payment,
            'date_rp' => $date_rp,
            'pay_rp' => $pay_rp,
            'total' => $total,
            'note' => $note,
            'deposit' => $deposit,
            'fitting' => $fitting,
            'process' => $process,
            'shipping' => $shipping,
            'shipping_address' => $shipping_address,
            'shipping_cost' => $shipping_cost,
            'promo' => $promo,
            'code_voucher' => $code_voucher,
            'disc_voucher' => $disc_voucher,
        );

        if ($date_pickup) {
            $data['date_borrow'] = $date_pickup;
        }

        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.app_for_log($appointment_id)->code);

        $result = $this->dmodel->create($data);
        if ($result) {
            alert();
            redirect('bisnis/appointment/deal/' . $appointment_id);
        }
    }

    public function update_deal()
    {
        $appointment_id = $this->input->post('appointment_id');
        $customer_id = $this->input->post('customer_id');
        $date_borrow = $this->input->post('date_borrow');
        $date_pickup = $this->input->post('date_pickup');
        $date_back = $this->input->post('date_back');
        $date_fitting = $this->input->post('date_fitting');
        $down_payment = $this->input->post('down_payment');
        $date_dp = $this->input->post('date_dp');
        $pay_dp = $this->input->post('pay_dp');
        $remaining_payment = $this->input->post('remaining_payment');
        $date_rp = $this->input->post('date_rp');
        $pay_rp = $this->input->post('pay_rp');
        $total = $this->input->post('total');
        $note = $this->input->post('note');
        $deposit = $this->input->post('deposit');
        $fitting = $this->input->post('fitting');
        $process = $this->input->post('process');
        $shipping = $this->input->post('shipping');
        $shipping_address = $this->input->post('shipping_address');
        $shipping_cost = $this->input->post('shipping_cost');
        $promo = $this->input->post('promo');
        $code_voucher = $this->input->post('codevoucher');
        $disc_voucher = $this->input->post('discvoucher');

        $id = $this->input->post('id');

//        return var_dump($date_borrow);

        $data = array(
            'appointment_id' => $appointment_id,
            'customer_id' => $customer_id,
            'date_borrow' => $date_borrow,
            'date_back' => $date_back,
            'date_fitting' => $date_fitting,
            'down_payment' => $down_payment,
            'date_dp' => $date_dp,
            'pay_dp' => $pay_dp,
            'remaining_payment' => $remaining_payment,
            'date_rp' => $date_rp,
            'pay_rp' => $pay_rp,
            'total' => $total,
            'note' => $note,
            'deposit' => $deposit,
            'fitting' => $fitting,
            'process' => $process,
            'shipping' => $shipping,
            'shipping_address' => $shipping_address,
            'shipping_cost' => $shipping_cost,
            'promo' => $promo,
            'code_voucher' => $code_voucher,
            'disc_voucher' => $disc_voucher,
        );

        if ($date_pickup) {
            $data['date_borrow'] = $date_pickup;
        }

        if ($this->input->post('fitting')) {
            $data_up = array(
                'status' => STATUS_SIAP_AMBIL
            );

            $this->model->update($appointment_id, $data_up);
        }

        helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.app_for_log($appointment_id)->code);

        $result = $this->dmodel->update($id, $data);
        if ($result) {
            alert();
            redirect('bisnis/appointment/deal/' . $appointment_id);
        }
    }

    public function totalTransaksi()
    {
        $appointment_id = $this->input->post('appointment_id');
        $shipping_cost = $this->input->post('shipping_cost');
        $disc_voucher = $this->input->post('disc_voucher');

        $app = $this->model->getId($appointment_id);
        $lock_dp = 0;
        $dp_old = 0;

        if($app->mdeal)
        {
            $lock_dp = $app->mdeal->lock_dp;
            $dp_old = $app->mdeal->down_payment;
        }

        $total = array();
//        $lop = 1;
        $ids = array();

        $baju = $this->model->getTrItem($appointment_id);
        foreach ($baju as $row) {
            $total[] = $row->total;
        }

        $dpromo = $this->model->getDpromo($appointment_id);
        foreach ($dpromo as $row) {
            $total[] = $row->price;
        }

        $accessories = $this->model->getTrAccessories($appointment_id);
        foreach ($accessories as $row) {
            $total[] = $row->total;
        }

        $jobs = $this->model->getTrJobs($appointment_id);
        foreach ($jobs as $row) {
            $total[] = $row->price;
        }

        $made = $this->model->getTrMade($appointment_id);
        foreach ($made as $row) {
            $total[] = $row->price;
        }

        $grandtotal = array_sum($total);
        $grandtotal = ($grandtotal + $shipping_cost) - $disc_voucher;

        $dp = $grandtotal / 2;

        if($lock_dp==1)
        {
            $dp = $dp_old;
        }

        $data = array(
            'total' => $grandtotal,
            'dp' => $dp,
            'labeltotal' => rupiah($grandtotal),
            'labeldp' => rupiah($dp)
        );
        echo json_encode($data);
    }

    public function viewbaju($appointment_id)
    {
        $total = array();
        $data['tritem'] = $this->model->getTrItem($appointment_id);
        foreach ($data['tritem'] as $key => $row) {
            $total[] = $row->total;
        }
        $data['total'] = array_sum($total);
        $this->load->view('appointment/v_list_baju', $data);
    }

    public function viewbajusale($appointment_id)
    {
        $total = array();
        $data['tritem'] = $this->model->getTrItem($appointment_id);
        foreach ($data['tritem'] as $key => $row) {
            $total[] = $row->total;
        }
        $data['total'] = array_sum($total);
        $this->load->view('appointment/v_list_bajusale', $data);
    }

    public function viewbajumaderent($appointment_id)
    {
        $total = array();
        $data['tritem'] = $this->model->getTrItem($appointment_id);
        foreach ($data['tritem'] as $key => $row) {
            $total[] = $row->total;
        }
        $data['total'] = array_sum($total);
        $this->load->view('appointment/v_list_bajumaderent', $data);
    }

    public function addbaju()
    {
        $appointment_id = $this->input->post('appointment_id');
        $baju_id = $this->input->post('baju_id');
        $customer_id = $this->input->post('customer_id');
        $qty = 1;

        $bajus = $this->model->getBajuById($baju_id);
        $baju_price = $bajus->rent_price;

        $data = array(
            'appointment_id' => $appointment_id,
            'customer_id' => $customer_id,
            'baju_id' => $baju_id,
            'qty' => $qty,
            'price' => $baju_price,
            'total' => $qty * $baju_price
        );

        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Transaksi '.app_for_log($appointment_id)->code);

        $lastid = $this->model->addItem($data);
        echo $lastid;

    }

    public function addbajusale()
    {
        $appointment_id = $this->input->post('appointment_id');
        $baju_id = $this->input->post('baju_id');
        $customer_id = $this->input->post('customer_id');
        $qty = 1;

        $bajus = $this->model->getBajuById($baju_id);
        $baju_price = $bajus->sale_price;

        $data = array(
            'appointment_id' => $appointment_id,
            'customer_id' => $customer_id,
            'baju_id' => $baju_id,
            'qty' => $qty,
            'price' => $baju_price,
            'total' => $qty * $baju_price
        );

        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Transaksi Sale '.app_for_log($appointment_id)->code);

        $this->model->addItem($data);
    }

    public function delete_item($appointment_id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Product '.app_for_log($appointment_id)->code);

        $result = $this->model->delAllTrItem($appointment_id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete_itemid($id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Product Per Id');

        $result = $this->model->delItemId($id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete_itemidformaster($id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Made For Rent Product Per ID');

        $result = $this->model->delItemIdformaster($id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function viewaccessories($appointment_id)
    {
        $data['traccessories'] = $this->model->getTrAccessories($appointment_id);
        $this->load->view('appointment/v_list_accessories', $data);
    }

    public function addAccessories()
    {
        $appointment_id = $this->input->post('appointment_id');
        $accessories_id = $this->input->post('accessories_id');
        $customer_id = $this->input->post('customer_id');
        $qty = 1;

        $accessories = $this->model->getAccessoriesById($accessories_id);
        $accessories_price = $accessories->rent_price;

        $data = array(
            'appointment_id' => $appointment_id,
            'customer_id' => $customer_id,
            'accessories_id' => $accessories_id,
            'qty' => $qty,
            'price' => $accessories_price,
            'total' => $qty * $accessories_price
        );

        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Transaksi Detail Accesories');

        $this->model->addAccessories($data);

    }

    public function delete_accessories($appointment_id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Accesoriess Semua '.app_for_log($appointment_id)->code);

        $result = $this->model->delAllTrAccessories($appointment_id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete_accessoriesid($id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Accesoriess Per ID');

        $result = $this->model->delAccessoriesId($id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function viewjobs($appointment_id)
    {
        $data['trjobs'] = $this->model->getTrJobs($appointment_id);
        $this->load->view('appointment/v_list_jobs', $data);
    }

    public function addJobs()
    {
        $appointment_id = $this->input->post('appointment_id');
        $job = $this->input->post('job');
        $price = $this->input->post('price');

        $data = array(
            'appointment_id' => $appointment_id,
            'job' => $job,
            'price' => $price,
        );

        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Transaksi Detail Jobs '.app_for_log($appointment_id)->code);

        $this->model->addJobs($data);

    }

    public function delete_jobs($appointment_id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Jobs Semua '.app_for_log($appointment_id)->code);
        $result = $this->model->delAllTrJobs($appointment_id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete_jobsid($id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Jobs Per ID');

        $result = $this->model->delJobsId($id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function viewdeposit($appointment_id)
    {
        $data['trdeposit'] = $this->model->getTrDeposit($appointment_id);
        $this->load->view('appointment/v_list_deposit', $data);
    }

    public function adddeposit()
    {
        $appointment_id = $this->input->post('appointment_id');
        $deposit = $this->input->post('deposit');

        $data = array(
            'appointment_id' => $appointment_id,
            'deposit' => $deposit,
            'date' => date('Y-m-d')
        );

        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Transaksi Deposit '.app_for_log($appointment_id)->code);

        $this->model->addTrDeposit($data);

    }

    public function delete_deposit($appointment_id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Deposit Semua '.app_for_log($appointment_id)->code);

        $result = $this->model->getTrDepositByAppointment($appointment_id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete_depositid($id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Deposit Per ID ');
        $result = $this->model->deleteTrDeposit($id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function viewmade($appointment_id)
    {
        $data['trmade'] = $this->model->getTrMade($appointment_id);
        $this->load->view('appointment/v_list_made', $data);
    }

    public function addMade()
    {
        $appointment_id = $this->input->post('appointment_id');
        $disc = $this->input->post('disc');
        $price = $this->input->post('price');

        $data = array(
            'appointment_id' => $appointment_id,
            'disc' => $disc,
            'price' => $price,
        );

        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Transaksi Detail Made '.app_for_log($appointment_id)->code);

        $this->model->addmade($data);

    }

    public function delete_made($appointment_id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Made '.app_for_log($appointment_id)->code);
        $result = $this->model->delAllTrMade($appointment_id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete_madeid($id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Made Per ID ');
        $result = $this->model->delMadeId($id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function invoice($appointment_id)
    {
        $product = array();
        $schedule = array();

        $data['deal'] = $this->dmodel->getDataByAppointment($appointment_id);
        $data['appointment'] = $this->model->getId($appointment_id);

        $traccessories = $this->model->getTrAccessories($appointment_id);
        $tritem = $this->model->getTrItem($appointment_id);
        $dpromo = $this->model->getDpromo($appointment_id);
        $trjobs = $this->model->getTrJobs($appointment_id);
        $trmade = $this->model->getTrMade($appointment_id);

        foreach ($tritem as $row) {
            $product[] = array(
                'name' => $row->mbaju->name,
                'qty' => $row->qty,
                'total' => rupiah($row->total),
            );

            $schedule[] = array(
                'name' => $row->mbaju->name,
                'qty' => $row->qty,
                'total' => rupiah($row->total),
                'tglfitting' => $row->fitting_date,
                'tglsewa' => $row->rent_date,
                'tglkembali' => $row->back_date,
            );
        }

        foreach ($dpromo as $dp) {
            $product[] = array(
                'name' => '<b>' . $dp->mpromo->name . '</b>',
                'qty' => '',
                'total' => rupiah($dp->price),
            );

            foreach ($dp->trpromo as $row) {
                $product[] = array(
                    'name' => $row->mbaju ? $row->mbaju->name : 'Belum Dipilih',
                    'qty' => $row->qty,
                    'total' => '',
                );

                $schedule[] = array(
                    'name' => $row->mbaju ? $row->mbaju->name : 'Belum Dipilih',
                    'qty' => $row->qty,
                    'total' => rupiah($row->total),
                    'tglfitting' => $row->fitting_date,
                    'tglsewa' => $row->rent_date,
                    'tglkembali' => $row->back_date,
                );
            }
        }

        if ($traccessories) {
            $product[] = array(
                'name' => '<b>ACCESSORIES</b>',
                'qty' => '',
                'total' => '',
            );

            foreach ($traccessories as $row) {
                $product[] = array(
                    'name' => $row->maccessories->name,
                    'qty' => $row->qty,
                    'total' => rupiah($row->total),
                );
            }
        }

        if ($trjobs) {
            $product[] = array(
                'name' => '<b>JOBS</b>',
                'qty' => '',
                'total' => '',
            );
            foreach ($trjobs as $row) {
                $product[] = array(
                    'name' => $row->job,
                    'qty' => '-',
                    'total' => rupiah($row->price)
                );
            }
        }

        if ($trmade) {
            $product[] = array(
                'name' => '<b>MADE</b>',
                'qty' => '',
                'total' => '',
            );

            foreach ($trmade as $row) {
                $product[] = array(
                    'name' => $row->disc,
                    'qty' => '-',
                    'total' => rupiah($row->price)
                );
            }

            $schedule[] = array(
                'name' => 'Made',
                'qty' => '',
                'total' => '',
                'tglfitting' => $data['deal']->date_fitting,
                'tglsewa' => $data['deal']->date_borrow,
                'tglkembali' => $data['deal']->date_back,
            );
        }

        $data['product'] = $product;
        $data['schedule'] = $schedule;
//        return var_dump($data);
        $data['company'] = $this->model->getCompany();
        $this->load->view('appointment/v_invoice', $data);
    }

    public function invoice_print($appointment_id)
    {
        $data['deal'] = $this->dmodel->getDataByAppointment($appointment_id);
        $traccessories = $this->model->getTrAccessories($appointment_id);
        $tritem = $this->model->getTrItem($appointment_id);
        $trjobs = $this->model->getTrJobs($appointment_id);
        $trmade = $this->model->getTrMade($appointment_id);

        foreach ($tritem as $row) {
            $product[] = array(
                'name' => $row->mbaju->name,
                'qty' => $row->qty,
                'total' => rupiah($row->total)
            );
        }

        foreach ($traccessories as $row) {
            $product[] = array(
                'name' => $row->maccessories->name,
                'qty' => $row->qty,
                'total' => rupiah($row->total)
            );
        }

        foreach ($trjobs as $row) {
            $product[] = array(
                'name' => $row->job,
                'qty' => '-',
                'total' => rupiah($row->price)
            );
        }

        foreach ($trmade as $row) {
            $product[] = array(
                'name' => $row->disc,
                'qty' => '-',
                'total' => rupiah($row->price)
            );
        }

        $data['product'] = $product;
        $data['company'] = $this->model->getCompany();
        $this->load->view('appointment/v_invoice_print', $data);
    }

    public function historyCustomer($id)
    {
        $result = $this->model->getCustomerById($id);
        $result = json_encode($result);
        if ($result) {
            echo $result;
        } else {
            echo json_encode(array('cancel' => ''));
        }

    }

    public function pickup($appointment_id)
    {
        /*Update status data appointment */
        $data_up = array(
            'status' => STATUS_DIPINJAM,
            'pickuped' => date('Y-m-d')
        );
        $this->model->update($appointment_id, $data_up);

        $detail = $this->model->getId($appointment_id);
        $status = $detail->mdeal->process;

        /*Update data master baju*/
        if ($status == PROSES_RENT) {
            $trItem = $this->model->getTrItem($appointment_id);
            foreach ($trItem as $row) {
                $idbaju = $row->baju_id;
                $bajudata = $this->model->getBajuById($idbaju);
                $hpp_price = $bajudata->hpp_price;
                $data['hpp_price'] = $hpp_price - $row->total;

                $this->model->updateBaju($idbaju, $data);
            }
        }

        /*Update tabel deal tgl remaining payment*/

        $data = array(
            'date_rp' => date('Y-m-d'),
        );

        $this->dmodel->updateByApp($appointment_id, $data);

        redirect('bisnis/appointment');
    }

    public function kembali($appointment_id)
    {
        $data_up = array(
            'status' => STATUS_KEMBALI,
            'returned' => date('Y-m-d'),
            'pinalty' => $this->input->post('pinalty'),
            'day' => $this->input->post('day'),
            'back_deposit' => $this->input->post('back_deposit'),
            'status_return' => $this->input->post('status_return'),
        );

        $this->model->updateAllTrItemByAppointmentId($appointment_id);

        $this->model->update($appointment_id, $data_up);

        $data = array(
            'return_note' => $this->input->post('return_note'),
            'pinalty' => $this->input->post('pinalty'),
        );

        $result = $this->dmodel->updateByApp($appointment_id, $data);
        if ($result) {
            return TRUE;
        }
        return FALSE;

//        redirect('bisnis/appointment');
    }

    public function delivery($appointment_id)
    {
        $data['deal'] = $this->dmodel->getDataByAppointment($appointment_id);
        $data['appointment'] = $this->model->getId($appointment_id);
        $data['appointment']->title = 'DATE OF PICK UP';
        $data['appointment']->date_delivery = $data['appointment']->status == STATUS_DIPINJAM ? $data['appointment']->pickuped : $data['appointment']->returned;
        $data['appointment']->ttd = $data['appointment']->status == STATUS_DIPINJAM ? $data['appointment']->ttd_pickup : $data['appointment']->ttd_return;
        $data['traccessories'] = $this->model->getTrAccessories($appointment_id);
        $data['tritem'] = $this->model->getTrItem($appointment_id);
        $data['dpromo'] = $this->model->getDpromo($appointment_id);
        $data['trjobs'] = $this->model->getTrJobs($appointment_id);
        $data['trmade'] = $this->model->getTrMade($appointment_id);

        $data['company'] = $this->model->getCompany();
        $this->load->view('appointment/v_delivery', $data);
    }

    public function returninvoice($appointment_id)
    {
        $data['deal'] = $this->dmodel->getDataByAppointment($appointment_id);
        $data['appointment'] = $this->model->getId($appointment_id);
        $data['appointment']->title = 'DATE OF RETURN';
        $data['appointment']->date_delivery = $data['appointment']->status == STATUS_DIPINJAM ? $data['appointment']->pickuped : $data['appointment']->returned;
        $data['appointment']->ttd = $data['appointment']->status == STATUS_DIPINJAM ? $data['appointment']->ttd_pickup : $data['appointment']->ttd_return;
        $data['traccessories'] = $this->model->getTrAccessories($appointment_id);
        $data['tritem'] = $this->model->getTrItem($appointment_id);
        $data['dpromo'] = $this->model->getDpromo($appointment_id);
        $data['trjobs'] = $this->model->getTrJobs($appointment_id);
        $data['trmade'] = $this->model->getTrMade($appointment_id);

        $data['company'] = $this->model->getCompany();
        $this->load->view('appointment/v_return', $data);
    }

    public function returninvoice_print($appointment_id)
    {
        $data['deal'] = $this->dmodel->getDataByAppointment($appointment_id);
        $data['appointment'] = $this->model->getId($appointment_id);
        $data['appointment']->title = 'DATE OF RETURN';
        $data['appointment']->date_delivery = $data['appointment']->status == STATUS_DIPINJAM ? $data['appointment']->pickuped : $data['appointment']->returned;
        $data['appointment']->ttd = $data['appointment']->status == STATUS_DIPINJAM ? $data['appointment']->ttd_pickup : $data['appointment']->ttd_return;
        $data['traccessories'] = $this->model->getTrAccessories($appointment_id);
        $data['tritem'] = $this->model->getTrItem($appointment_id);
        $data['dpromo'] = $this->model->getDpromo($appointment_id);
        $data['trjobs'] = $this->model->getTrJobs($appointment_id);
        $data['trmade'] = $this->model->getTrMade($appointment_id);

        $data['company'] = $this->model->getCompany();
        $this->load->view('appointment/v_return_print', $data);
    }

    public function delivery_print($appointment_id)
    {
        $data['deal'] = $this->dmodel->getDataByAppointment($appointment_id);
        $data['appointment'] = $this->model->getId($appointment_id);
        $data['appointment']->title = 'DATE OF PICK UP';
        $data['appointment']->date_delivery = $data['appointment']->status == STATUS_DIPINJAM ? $data['appointment']->pickuped : $data['appointment']->returned;
        $data['appointment']->ttd = $data['appointment']->status == STATUS_DIPINJAM ? $data['appointment']->ttd_pickup : $data['appointment']->ttd_return;
        $data['traccessories'] = $this->model->getTrAccessories($appointment_id);
        $data['tritem'] = $this->model->getTrItem($appointment_id);
        $data['dpromo'] = $this->model->getDpromo($appointment_id);
        $data['trjobs'] = $this->model->getTrJobs($appointment_id);
        $data['trmade'] = $this->model->getTrMade($appointment_id);

        $data['company'] = $this->model->getCompany();
        $this->load->view('appointment/v_delivery_print', $data);
    }

    public function viewpromo($appointment_id)
    {
        $data['promo'] = $this->model->getDpromo($appointment_id);
        $this->load->view('appointment/v_list_promo', $data);
    }

    public function addpromo()
    {
        $promo_id = $this->input->post('promo_id');

        $promo = $this->model->getPromoById($promo_id);
        $price_promo = $promo->disc;


        /*Input D promo*/
        $data = array(
            'appointment_id' => $this->input->post('appointment_id'),
            'promo_id' => $promo_id,
            'price' => $price_promo
        );
        /*Ambil id input dari dpromo*/
        $lastid = $this->model->addPromo($data);

        $datapromo = $this->model->getPromoById($promo_id);
        $appointment_id = $this->input->post('appointment_id');

        for ($i = 1; $i <= $datapromo->qty; $i++) {
            $data_trpromo = array(
                'appointment_id' => $appointment_id,
                'dpromo_id' => $lastid,
                'customer_id' => $this->input->post('customer_id'),
                'baju_id' => 0,
                'qty' => 1,
                'price' => 0,
                'total' => 0,
            );

            $this->model->addTrPromo($data_trpromo);
        }
        helper_log("add", $this->session->userdata('name').LANG_ADD_LOG.'Transaksi Detail Promo '.app_for_log($appointment_id)->code);
    }

    public function delete_promo($appointment_id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Promo Semua '.app_for_log($appointment_id)->code);
        $result = $this->model->delDpromoAll($appointment_id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function delete_promoid($id)
    {
        helper_log("delete", $this->session->userdata('name').LANG_DELETE_LOG.'Transaksi Detail Promo Per ID ');
        $result = $this->model->delDpromo($id);
        if ($result) {
            return TRUE;
        }
        return FALSE;
    }

    public function form_promo($id)
    {
        $data = array(
            'baju' => $this->model->getBaju(),
            'd' => $this->model->getTrPromoId($id)
        );
        $this->load->view('appointment/v_promo_update', $data);
    }

    public function update_trpromo()
    {
        $baju_id = $this->input->post('baju_id');
        $qty = 1;

        $bajus = $this->model->getBajuById($baju_id);
        $baju_price = $bajus->rent_price;

        $data = array(
            'baju_id' => $baju_id,
            'qty' => $qty,
            'price' => $baju_price,
            'total' => $baju_price * $qty,
            'fitting_date' => $this->input->post('fitting_date'),
            'rent_date' => $this->input->post('rent_date'),
            'back_date' => $this->input->post('back_date'),
            'deposit' => $this->input->post('deposit'),
        );
        $id = $this->input->post('id');

        $this->model->updateTrPromo($id, $data);
    }

    public function form_item($id)
    {
        $data = array(
            'd' => $this->model->getTrItemById($id)
        );
        $this->load->view('appointment/v_item_update', $data);
    }

    public function form_itemsale($id)
    {
        $data = array(
            'd' => $this->model->getTrItemById($id)
        );
        $this->load->view('appointment/v_itemsale_update', $data);
    }

    public function update_tritem()
    {
        $data = array(
            'fitting_date' => $this->input->post('fitting_date'),
            'rent_date' => $this->input->post('rent_date'),
            'back_date' => $this->input->post('back_date'),
            'deposit' => $this->input->post('deposit'),
        );
        $id = $this->input->post('id');

        $this->model->updateTrItem($id, $data);
    }

    public function update_tritemsale()
    {
        $data = array(
            'fitting_date' => $this->input->post('fitting_date'),
            'rent_date' => $this->input->post('rent_date'),
        );
        $id = $this->input->post('id');

        $this->model->updateTrItem($id, $data);
    }

    public function signature($id)
    {
        $data = array(
            'header_title' => 'Signature',
            'header_desc' => 'Master',
            'urlsignature' => site_url('bisnis/appointment/update_signature'),
            'urlback' => site_url('bisnis/appointment/process_detail/' . $id),
            'id' => $id
        );
        $content = 'appointment/v_signature';
        $this->pinky->output($data, $content);
    }

    public function signaturepickup($id)
    {
        $data = array(
            'header_title' => 'Signature',
            'header_desc' => 'Master',
            'urlsignature' => site_url('bisnis/appointment/update_signaturepickup'),
            'urlback' => site_url('bisnis/appointment/process_detail/' . $id),
            'id' => $id
        );
        $content = 'appointment/v_signaturepickup';
        $this->pinky->output($data, $content);
    }

    public function signaturereturn($id)
    {
        $data = array(
            'header_title' => 'Signature',
            'header_desc' => 'Master',
            'urlsignature' => site_url('bisnis/appointment/update_signaturereturn'),
            'urlback' => site_url('bisnis/appointment/process_detail/' . $id),
            'id' => $id
        );
        $content = 'appointment/v_signaturereturn';
        $this->pinky->output($data, $content);
    }

    public function update_signature()
    {
        $id = $this->input->post('id');
        $data = array(
            'ttd_invoice' => $this->input->post('ttd_invoice'),
            'receiver_invoice' => $this->input->post('receiver')
        );
        $this->model->update($id, $data);
    }

    public function update_signaturepickup()
    {
        $id = $this->input->post('id');
        $data = array(
            'ttd_pickup' => $this->input->post('ttd_pickup'),
            'receiver_pickup' => $this->input->post('receiver'),
            'pickuped' => date('Y-m-d')
        );
        $this->model->update($id, $data);
    }

    public function update_signaturereturn()
    {
        $id = $this->input->post('id');
        $data = array(
            'ttd_return' => $this->input->post('ttd_return'),
            'receiver_return' => $this->input->post('receiver'),
            'returned' => date('Y-m-d')
        );
        $this->model->update($id, $data);
    }

    public function voucher($kode)
    {
        $data = array();
        $result = $this->model->getDiscVoucher($kode);

        if ($result) {
            $data = array(
                'disc' => $result->disc,
                'code' => $result->code,
            );
        }

        echo json_encode($data);

    }

    public function process_detail($appointment_id)
    {
        $data = array(
            'header_title' => 'Process Detail',
            'header_desc' => 'Master',

            'dpromo' => $this->model->getDpromo($appointment_id),
            'tritem' => $this->model->getTrItem($appointment_id),
            'trpromo' => $this->model->getTrPromoByAppointment($appointment_id),

            'trdeposit' => $this->model->getTrDeposit($appointment_id),
            'trmade' => $this->model->getTrMade($appointment_id),
            'mappointment' => $this->model->getId($appointment_id),
            'appointment_id' => $appointment_id,
            'link_back' => site_url('bisnis/appointment/'),
            'link_act' => site_url('bisnis/appointment/do_process_detail'),
            'link_ttd' => site_url('bisnis/appointment/signature/'),
            'link_ttdpickup' => site_url('bisnis/appointment/signaturepickup/'),
            'link_ttdreturn' => site_url('bisnis/appointment/signaturereturn/'),
        );

        $tritem_minus = array();
        $trpromo_minus = array();
        $tritem_deposit = array();
        $trpromo_deposit = array();

        foreach ($data['tritem'] as $keyitem => $row) {
            $tritem_minus[] = $row->minus;
            $tritem_deposit[] = $row->deposit;
        }

        foreach ($data['trpromo'] as $keypromo => $row) {
            $trpromo_minus[] = $row->minus;
            $trpromo_deposit[] = $row->deposit;
        }
        $tot_deposit = array_sum($tritem_deposit) + array_sum($trpromo_deposit);
        $tot_minus = array_sum($tritem_minus) + array_sum($trpromo_minus);

        $tot_dikembalikan = $tot_deposit - $tot_minus;

        $data['total_deposit'] = $tot_deposit;
        $data['total_minus'] = $tot_minus;
        $data['total_dikembalikan'] = $tot_dikembalikan;

        $content = 'appointment/v_process_detail';
        $this->pinky->output($data, $content);
    }

    public function do_process_detail()
    {
        $promo_fitting_status = $this->input->post('promo_fitting_status');
        $promo_rent_status = $this->input->post('promo_rent_status');
        $promo_back_status = $this->input->post('promo_back_status');

        $item_fitting_status = $this->input->post('item_fitting_status');
        $item_rent_status = $this->input->post('item_rent_status');
        $item_back_status = $this->input->post('item_back_status');

        $appoitment_fitting_status = $this->input->post('appoitment_fitting_status');
        $appoitment_rent_status = $this->input->post('appoitment_rent_status');

        $appointment_id = $this->input->post('appointment_id');

        if ($promo_fitting_status) {
            foreach ($promo_fitting_status as $key => $row) {
                $this->model->updateTrPromo($row, $data = array('fitting_status' => 1));
            }

            $data_up = array(
                'status' => STATUS_SIAP_AMBIL
            );

            $this->model->update($appointment_id, $data_up);
        }

        if ($appoitment_fitting_status) {
            $result = $this->dmodel->updateByApp($appointment_id, array('fitting' => 1));
            if ($result) {
                $data_up = array(
                    'status' => STATUS_SIAP_AMBIL,
                );
                $this->model->update($appointment_id, $data_up);
            }
        }

        if ($promo_rent_status) {
            foreach ($promo_rent_status as $key => $row) {
                $this->model->updateTrPromo($row, $data = array('rent_status' => 1));
            }

            $data_up = array(
                'status' => STATUS_DIPINJAM,
                'pickuped' => date('Y-m-d')
            );

            $this->model->update($appointment_id, $data_up);
        }

        if ($appoitment_rent_status) {
            $result = $this->dmodel->updateByApp($appointment_id, array('pickup' => 1));
            if ($result) {
                $data_up = array(
                    'status' => STATUS_DIPINJAM,
                );
                $this->model->update($appointment_id, $data_up);
            }
        }

        if ($promo_back_status) {
            foreach ($promo_back_status as $key => $row) {
                $this->model->updateTrPromo($row, $data = array('back_status' => 1));
            }

            $data_up = array(
                'status' => STATUS_KEMBALI
            );

            $this->model->update($appointment_id, $data_up);
        }

        if ($item_fitting_status) {
            foreach ($item_fitting_status as $key => $row) {
                $this->model->updateTrItem($row, $data = array('fitting_status' => 1));
            }

            $data_up = array(
                'status' => STATUS_SIAP_AMBIL
            );
            $this->model->update($appointment_id, $data_up);
        }

        if ($item_rent_status) {
            foreach ($item_rent_status as $key => $row) {
                $this->model->updateTrItem($row, $data = array('rent_status' => 1));
            }
            $data_up = array(
                'status' => STATUS_DIPINJAM,
                'pickuped' => date('Y-m-d')
            );

            $this->model->update($appointment_id, $data_up);
        }

        if ($item_back_status) {
            foreach ($item_back_status as $key => $row) {
                $this->model->updateTrItem($row, $data = array('back_status' => 1));
            }

            $data_up = array(
                'status' => STATUS_KEMBALI
            );

            $this->model->update($appointment_id, $data_up);
        }

        helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Transaksi Detail Proses '.app_for_log($appointment_id)->code);

        alert();
        redirect('bisnis/appointment');
    }

    public function return_sewa($id, $jenis)
    {
        $data = array(
            'header_title' => 'Return Baju',
            'header_desc' => 'Bisnis',
            'link_back' => site_url('bisnis/appointment/process_detail/'),
            'link_act' => site_url('bisnis/appointment/act_return'),
            'jenis' => $jenis,
        );

        if ($jenis == 'item') {
            $data['rowdata'] = $this->model->getTrItemById($id);
        } elseif ($jenis == 'promo') {
            $data['rowdata'] = $this->model->getTrPromoId($id);
        } else {
            $data['rowdata'] = $this->model->getId($id);
        }

        $content = 'appointment/v_return_sewa';
        $this->pinky->output($data, $content);
    }

    public function act_return()
    {
        $jenis = $this->input->post('jenis');
        $status_return = $this->input->post('status_return');
        $hari_telat = $this->input->post('hari_telat');
        $denda = $this->input->post('pinalty');
        $keterangan = $this->input->post('keterangan');
        $id = $this->input->post('id');

        $deposit = $this->input->post('deposit');
        $tot_hari_telat = $hari_telat * 100000;
        $minus = $tot_hari_telat + $denda;

//        return var_dump($jenis);

        $appointment_id = $this->input->post('appointment_id');

        $data = array(
            'status_return' => $status_return,
            'back_status' => 1,
            'hari_telat' => $hari_telat,
            'denda' => $denda,
            'keterangan' => $keterangan,
            'minus' => $minus
        );

        if($jenis == 'promo')
        {
            $this->model->updateTrPromo($id, $data);
        }
        elseif($jenis == 'made')
        {
            $datadeal = array(
                'returned' => $status_return,
                'hari_telat' => $hari_telat,
                'pinalty' => $denda,
                'return_note' => $keterangan,
                'minus' => $minus

            );
            $this->model->UpdateDeal($id, $datadeal);
        }
        elseif($jenis == 'item')
        {
            $this->model->updateTrItem($id, $data);

        }

        helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Transaksi Detail Proses Return Product '.app_for_log($appointment_id)->code);

        alert(2);
        redirect('bisnis/appointment/process_detail/' . $appointment_id);
    }

    /*View Made for rent add baju*/

    public function form_madesale($id)
    {
        $data = array(
//            'd' => $this->model->getTrItemById($id),
            'kategori' => $this->model->getKategori(),
            'type' => $this->model->getType(),
            'app' => $this->model->getId($id)
        );
        $this->load->view('appointment/v_form_made', $data);
    }

    /*Do add baju */

    public function do_form_madesale()
    {
        $name = $this->input->post('name');
        $code = $this->model->getkodeBaju();
        $colour = $this->input->post('colour');
        $type = $this->input->post('type');
        $kategori = $this->input->post('kategori');
        $hpp_first = $this->input->post('hpp_first');
        $rent_price = $this->input->post('rent_price');
        $sale_price = $this->input->post('sale_price');
        $qty = 1;
        $note = $this->input->post('note');
        $new_item = 1;

        $appointment_id = $this->input->post('appointment_id');
        $customer_id = $this->input->post('customer_id');

        $data = array(
            'code' => $code,
            'name' => $name,
            'colour' => $colour,
            'type' => $type,
            'kategori' => $kategori,
            'hpp_price' => $hpp_first,
            'hpp_first' => $hpp_first,
            'rent_price' => $rent_price,
            'sale_price' => $sale_price,
            'qty' => $qty,
            'note' => $note,
            'new_item' => $new_item
        );

        $dataitem = array(
            'appointment_id' => $appointment_id,
            'customer_id' => $customer_id,
            'qty' => $qty,
            'price' => $rent_price,
            'total' => $rent_price * $qty,
        );
        $getId = $this->model->addBaju($data);
        $dataitem['baju_id'] = $getId;

        $iditem =  $this->model->addItem($dataitem);
        if($iditem)
        {
            echo $iditem;
        }
        else
        {
            echo 0;
        }

    }

    public function lockdp($id)
    {
        $data = array(
            'lock_dp'=>1
        );
        $this->model->UpdateDeal($id,$data);
    }

    public function back_deposit_for_sale($appointment_id)
    {
        $data = array(
            'back_deposit' => 1,
        );

        $app = $this->model->getId($appointment_id);
        $deal_id = $app->mdeal->id;

        $this->model->UpdateDeal($deal_id,$data);
        helper_log("edit", $this->session->userdata('name').LANG_EDIT_LOG.'Made For Sale (Deposit) '.app_for_log($appointment_id)->code);
        redirect('bisnis/appointment/process_detail/'.$appointment_id);
    }

    public function change_complete($appointment_id)
    {
        $data = array(
            'status' => STATUS_COMPLETE
        );
        $this->model->update($appointment_id,$data);
        alert(2);
        redirect('bisnis/appointment/process_detail/'.$appointment_id);
    }

    protected function mailing($subject,$body,$emailuser)
    {
        $this->load->library('email');

        $this->email
            ->from('infosewabaju@jasa-programmer-jakarta.com')
            ->reply_to($emailuser)// Optional, an account where a human being reads.
            ->to($emailuser)
            ->subject($subject)
            ->message($body)
            ->send();
    }

    public function sendmail_appointment($appointment_id)
    {
        $app = $this->model->getId($appointment_id);
        $emailuser = $app->mcustomer->email;

        $data['tgl'] = $app->date;

        $subject = 'Appointment';
        $body = $this->load->view('pinky/email/appointment',$data,TRUE);
        $this->mailing($subject,$body,$emailuser);
    }

    public function sendmail_deal($appointment_id)
    {
        $app = $this->model->getId($appointment_id);
        $emailuser = $app->mcustomer->email;

        $subject = 'Deal Transaksi';
        $body = $this->load->view('pinky/email/dealing','',TRUE);
        $this->mailing($subject,$body,$emailuser);
    }

    public function sendmail_completed($appointment_id)
    {
        $app = $this->model->getId($appointment_id);
        $emailuser = $app->mcustomer->email;

        $subject = 'Completed Transaksi';
        $body = $this->load->view('pinky/email/completed','',TRUE);
        $this->mailing($subject,$body,$emailuser);
    }

    public function sendmail_thanks($appointment_id)
    {
        $app = $this->model->getId($appointment_id);
        $emailuser = $app->mcustomer->email;

        $data['tgl'] = $app->date;

        $subject = 'Terimakasih';
        $body = $this->load->view('pinky/email/thanks',$data,TRUE);
        $this->mailing($subject,$body,$emailuser);
    }

}