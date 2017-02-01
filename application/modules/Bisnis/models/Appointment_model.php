<?php

/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 02/11/2016
 * Time: 13:26
 */
class Appointment_model extends Base_model
{
    protected $table = 'm_appointment';
    protected $table_baju = 'm_baju';
    protected $table_acessories = 'm_accessories';
    protected $tr_item = 'tr_item';
    protected $tr_accessories = 'tr_accessories';
    protected $mdeal = 'm_deal';
    protected $mcompany = 'm_company';
    protected $tr_jobs = 'tr_jobs';
    protected $tr_made = 'tr_made';
    protected $m_promo = 'm_promo';
    protected $d_promo = 'd_promo';
    protected $tr_promo = 'tr_promo';
    protected $mvoucher = 'm_voucher';
    protected $tr_deposit = 'tr_deposit';
    protected $m_type = 'm_type';
    protected $m_kategori = 'm_kategori';
    protected $m_baju = 'm_baju';
    protected $m_customer = 'm_customer';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('../../master/models/customer_model','cmodel');
    }

    public function getAll()
    {
        $condition['deleted']='0';
        $condition['status !='] = STATUS_COMPLETE;

        $pagedata = $this->getData($this->table,$condition)->result();
        foreach($pagedata as $key=>$row)
        {
            $pagedata[$key]->mcustomer = $this->cmodel->getId($row->customer_id);
            $pagedata[$key]->mdeal = $this->getData($this->mdeal,array('appointment_id'=>$row->id))->row();
            $pagedata[$key]->tritem = $this->getData($this->tr_item,array('appointment_id'=>$row->id))->result();
            $pagedata[$key]->trpromo = $this->getData($this->tr_promo,array('appointment_id'=>$row->id))->result();
            $pagedata[$key]->trdeposit = $this->getData($this->tr_deposit,array('appointment_id'=>$row->id,'back_status'=>0))->row();
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
        $pagedata->mdeal = $this->getData($this->mdeal,array('appointment_id'=>$id))->row();
        $pagedata->mcustomer = $this->getData($this->m_customer,array('id'=>$pagedata->customer_id))->row();
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
            return $this->getLastInsertId();
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
        $kode = $this->getkodeunik($this->table,'APP');
        return $kode;
    }

    public function UpdateDeal($id,$data=array())
    {
        $condition['id'] = $id;
        $result = $this->updateData($this->mdeal,$data,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getBaju()
    {
        $result = $this->getData($this->table_baju,array('status'=>0))->result();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getAccessories()
    {
        $result = $this->getData($this->table_acessories,array('status'=>0))->result();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getBajuById($id)
    {
        $condition['id'] = $id;
        $result = $this->getData($this->table_baju,$condition)->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getAccessoriesById($id)
    {
        $condition['id'] = $id;
        $result = $this->getData($this->table_acessories,$condition)->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function addItem($data=array())
    {
        $result = $this->addData($this->tr_item,$data);
        if($result)
        {
            return $this->getLastInsertId();
        }
        return FALSE;
    }

    public function getTrItem($appointment_id)
    {
        $condition['appointment_id'] = $appointment_id;
        $result = $this->getData($this->tr_item,$condition)->result();

        foreach($result as $key=>$row)
        {
            $result[$key]->mbaju = $this->getData($this->table_baju,array('id'=>$row->baju_id))->row();
        }
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getTrItemById($id)
    {
        $condition['id'] = $id;
        $result = $this->getData($this->tr_item,$condition)->row();

        if($result)
        {
            return $result;
        }
        return [];
    }

    public function delAllTrItem($appointment_id)
    {
        $condition['appointment_id'] = $appointment_id;
        $result = $this->deleteData($this->tr_item,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function delItemId($id)
    {
        $condition['id'] = $id;
        $result = $this->deleteData($this->tr_item,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function delItemIdformaster($id)
    {
        $tritem = $this->getTrItemById($id);
        $baju_id = $tritem->baju_id;
        $this->deleteData($this->m_baju,array('id'=>$baju_id));

        $condition['id'] = $id;
        $result = $this->deleteData($this->tr_item,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function addAccessories($data=array())
    {
        $result = $this->addData($this->tr_accessories,$data);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getTrAccessories($appointment_id)
    {
        $condition['appointment_id'] = $appointment_id;
        $result = $this->getData($this->tr_accessories,$condition)->result();
        foreach($result as $key=>$row)
        {
            $result[$key]->maccessories = $this->getData($this->table_acessories,array('id'=>$row->accessories_id))->row();
        }
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function delAllTrAccessories($appointment_id)
    {
        $condition['appointment_id'] = $appointment_id;
        $result = $this->deleteData($this->tr_accessories,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function delAccessoriesId($id)
    {
        $condition['id'] = $id;
        $result = $this->deleteData($this->tr_accessories,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    //job transaksi

    public function addJobs($data=array())
    {
        $result = $this->addData($this->tr_jobs,$data);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getTrJobs($appointment_id)
    {
        $condition['appointment_id'] = $appointment_id;
        $result = $this->getData($this->tr_jobs,$condition)->result();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function delAllTrJobs($appointment_id)
    {
        $condition['appointment_id'] = $appointment_id;
        $result = $this->deleteData($this->tr_jobs,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function delJobsId($id)
    {
        $condition['id'] = $id;
        $result = $this->deleteData($this->tr_jobs,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    //made transaksi

    public function addMade($data=array())
    {
        $result = $this->addData($this->tr_made,$data);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getTrMade($appointment_id)
    {
        $condition['appointment_id'] = $appointment_id;
        $result = $this->getData($this->tr_made,$condition)->result();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function delAllTrMade($appointment_id)
    {
        $condition['appointment_id'] = $appointment_id;
        $result = $this->deleteData($this->tr_made,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function delMadeId($id)
    {
        $condition['id'] = $id;
        $result = $this->deleteData($this->tr_made,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getCompany()
    {
        $result = $this->getData($this->mcompany,array('id'=>1))->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getCustomerById($id)
    {
        $result = $this->getData($this->table,array('customer_id'=>$id))->result();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getHistory()
    {
        $condition['deleted']='0';
        $condition['status'] = STATUS_COMPLETE;

        $pagedata = $this->getData($this->table,$condition)->result();
        foreach($pagedata as $key=>$row)
        {
            $pagedata[$key]->mcustomer = $this->cmodel->getId($row->customer_id);
            $pagedata[$key]->mdeal = $this->getData($this->mdeal,array('appointment_id'=>$row->id))->row();
        }
        if($pagedata)
        {
            return $pagedata;
        }
        return [];
    }

    public function updateAllTrItemByAppointmentId($id)
    {
        $condition['appointment_id'] = $id;
        $data = $this->getData($this->tr_item,$condition)->result();
        foreach($data as $row)
        {
            $this->updateData($this->tr_item,array('returned'=>1),array('id'=>$row->id));
        }
    }

    public function updateTrItem($id,$data=array())
    {
        $condition['id'] = $id;
        $result = $this->updateData($this->tr_item,$data,$condition);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getPromo($kategori)
    {
        $result = $this->getData($this->m_promo,array('kategori'=>$kategori))->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getPromoById($id)
    {
        $result = $this->getData($this->m_promo,array('id'=>$id))->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getPromoAll()
    {
        $pagedata = $this->getData($this->m_promo,array('status'=>0))->result();
        if($pagedata)
        {
            return $pagedata;
        }
        return [];
    }

    public function updateBaju($id,$data=array())
    {
        $result = $this->updateData($this->table_baju,$data,array('id'=>$id));
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function addPromo($data=array())
    {
        $result = $this->addData($this->d_promo,$data);
        if($result)
        {
            return $this->getLastInsertId();
        }
        return FALSE;
    }

    public function getDpromo($id)
    {
        $result = $this->getData($this->d_promo,array('appointment_id'=>$id))->result();
        foreach($result as $key=>$val)
        {
            $result[$key]->trpromo = $this->getData($this->tr_promo,array('dpromo_id'=>$val->id))->result();
            foreach($result[$key]->trpromo as $k=>$row)
            {
                $result[$key]->trpromo[$k]->mbaju = $this->getData($this->table_baju, array('id'=>$row->baju_id))->row();
            }
            $result[$key]->mpromo = $this->getData($this->m_promo,array('id'=>$val->promo_id))->row();
        }
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function delDpromo($id)
    {
        $result = $this->deleteData($this->d_promo,array('id'=>$id));
        if($result)
        {
            $this->deleteData($this->tr_promo,array('dpromo_id'=>$id));
            return TRUE;
        }
        return FALSE;
    }

    public function delDpromoAll($appointment_id)
    {
        $data = $this->getData($this->d_promo,array('appointment_id'=>$appointment_id))->result();
        foreach($data as $row)
        {
            $this->deleteData($this->tr_promo,array('dpromo_id'=>$row->id));
        }

        $result = $this->deleteData($this->d_promo,array('appointment_id'=>$appointment_id));
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function addTrPromo($data=array())
    {
        $result = $this->addData($this->tr_promo,$data);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getTrPromoId($id)
    {
        $result = $this->getData($this->tr_promo,array('id'=>$id))->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getTrPromoByAppointment($appointment_id)
    {
        $result = $this->getData($this->tr_promo,array('appointment_id'=>$appointment_id))->result();
        foreach($result as $key=>$row)
        {
            $result[$key]->mbaju = $this->getData($this->table_baju,array('id'=>$row->baju_id))->row();
        }
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function updateTrPromo($id,$data=array())
    {
        $result = $this->updateData($this->tr_promo,$data,array('id'=>$id));
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getDiscVoucher($kode)
    {
        $result = $this->getData($this->mvoucher,array('code'=>$kode))->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function addTrDeposit($data=array())
    {
        $result = $this->addData($this->tr_deposit,$data);
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getTrDeposit($appointment_id)
    {
        $result = $this->getData($this->tr_deposit,array('appointment_id'=>$appointment_id))->result();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getTrDepositNotLunas($appointment_id)
    {
        $condition = array(
            'appointment_id'=>$appointment_id,
            'back_status' => '0',
        );

        $result = $this->getData($this->tr_deposit,$condition)->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getTrDepositId($id)
    {
        $result = $this->getData($this->tr_deposit,array('id'=>$id))->row();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function updateTrDeposit($id,$data=array())
    {
        $result = $this->updateData($this->tr_deposit,$data,array('id'=>$id));
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function deleteTrDeposit($id)
    {
        $result = $this->deleteData($this->tr_deposit,array('id'=>$id));
        if($result)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function getTrDepositByAppointment($appointment_id)
    {
        $condition['appointment_id']=$appointment_id;
        $result = $this->getData($this->tr_deposit,$condition)->result();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getKategori()
    {
        $condition['status'] = 0;
        $result = $this->getData($this->m_kategori,$condition)->result();
        if($result)
        {
            return $result;
        }
        return [];
    }

    public function getType()
    {
        $condition['status'] = 0;
        $result = $this->getData($this->m_type,$condition)->result();
        if($result)
        {
            return $result;
        }
        return [];
    }

    /*Tambah Baju*/
    public function addBaju($data=array())
    {
        $query = $this->addData($this->m_baju,$data);
        if($query)
        {
            return $this->getLastInsertId();
        }
        return FALSE;
    }

    public function getkodeBaju()
    {
        $kode = $this->getkodeunik($this->m_baju,'BA');
        return $kode;
    }
}