<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends My_controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard_model','model');
		/* Active Menu */

		$this->session->set_flashdata('parent_menu_active', 'dashboard');
		$this->session->set_flashdata('child_menu_active',  '');
	}

	public function index()
	{
		$data['header_title'] = 'Dashboard';
		$data['header_desc'] = 'Master | Sewa Baju';

		$tritem = $this->model->getTrItem();
		$trpromo = $this->model->getTrPromo();
		$fitingData = $this->model->getFittingDate();
		$dataCalendar = array();

//		return var_dump($tritem);

		foreach($tritem as $rows)
		{
			if(isset($rows->tritem))
			{
				foreach($rows->tritem as $row)
				{
					$dataCalendar[] = array(
						'title' => $row->mbaju->name,
						'start' => $row->fitting_date,
						'end' => $row->back_date.'T23:59:00',
						'description' => $row->mcustomer->name,
						'appointment_id' => $row->appointment_id
					);
				}
			}
		}

		foreach($trpromo as $rows)
		{
			if($rows->trpromo)
			{
				foreach($rows->trpromo as $row)
				{
					$dataCalendar[] = array(
						'title' => $row->mbaju->name,
						'start' => $row->fitting_date,
						'end' => $row->back_date.'T23:59:00',
						'description' => $row->mcustomer->name,
						'appointment_id' => $row->appointment_id
					);
				}
			}
		}

		$rowTransToday = array();

		$boxsell = $this->model->getAppointmentDeal();
		foreach($boxsell as $row)
		{
			if($row->mdeal)
			{
				$rowTransToday[] = $row->mdeal->total;
			}
		}
		$trans_today = array_sum($rowTransToday);

		$rowTransAll = array();

		$boxIncome = $this->model->getAppointment();
		foreach($boxIncome as $row)
		{
			if($row->mdeal)
			{
				$rowTransAll[] = $row->mdeal->total;
			}
		}
		$trans_all = array_sum($rowTransAll);

		$data['dcalendar'] = json_encode($dataCalendar);
		$data['trans_today'] = $trans_today;
//		$data['return_today'];
		$data['total_all'] = $trans_all;

		$this->pinky->output($data,'pinky/home');

		//$this->load->view('view_barcode');
	}

	public function denied()
	{
		$this->pinky->output(NULL,'pinky/denied');
	}

	function bikin_barcode($kode)
	{
//kita load library nya ini membaca file Zend.php yang berisi loader
//untuk file yang ada pada folder Zend
		$this->load->library('zend');

//load yang ada di folder Zend
		$this->zend->load('Zend/Barcode');

//generate barcodenya
//$kode = 12345abc;
		Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
	}
//end of class
}
