<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:10
 */
class Deal extends My_controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appointment_model','model');
        $this->load->model('../../master/models/customer_model','cmodel');
    }

    public function index()
    {
        $data = array(
            'header_title' => 'Appointment',
            'header_desc' => 'Master',
            'link_add' => site_url('bisnis/appointment/add'),
            'link_edit' => site_url('bisnis/appointment/update/'),
            'link_delete' => site_url('bisnis/appointment/delete'),
            'data' => $this->model->getAll()
        );
        $content = 'appointment/v_appointment_table';

        $this->pinky->output($data,$content);
    }

    public function add()
    {
        $data = array(
            'header_title' => 'Form Appointment',
            'header_desc' => 'Master',
            'link_back' => site_url('bisnis/appointment'),
            'link_act' => site_url('bisnis/appointment/do_add'),
            'link_cus' => site_url('bisnis/appointment/form_customer'),
            'customer' => $this->cmodel->getAll()
        );
        $content = 'appointment/v_appointment_add';
        $this->pinky->output($data,$content);
    }

    public function do_add()
    {
        $code = $this->model->getkode();
        $date = $this->input->post('date');
        $customer_id = $this->input->post('customer_id');
        $note = $this->input->post('note');

        $data = array(
            'code' => $code,
            'date' => $date,
            'customer_id' => $customer_id,
            'note' => $note,
        );

        $result = $this->model->create($data);
        if($result)
        {
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
        $this->pinky->output($data,$content);
    }

    public function do_update()
    {
        $date = $this->input->post('date');
        $customer_id = $this->input->post('customer_id');
        $note = $this->input->post('note');

        $id = $this->input->post('id');

        $data = array(
            'date' => $date,
            'customer_id' => $customer_id,
            'note' => $note,
        );

        $condition['id']= $id;
        $result = $this->model->update($id,$data);
        if($result)
        {
            alert(2);
            redirect('bisnis/appointment');
        }
    }

    public function delete($id)
    {
        $result = $this->model->delete($id);
        if($result)
        {
            alert(3);
        }
    }

    public function form_customer()
    {
        $data = array(
            'link_act' => site_url('bisnis/appointment/do_addcustomer'),
        );
        $this->load->view('appointment/v_customer_add',$data);
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

        $result = $this->cmodel->create($data);
        if($result)
        {
            alert();
            redirect('bisnis/appointment/add');
        }
    }
}