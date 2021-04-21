<?php 

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
}

class Admin_Controller extends MY_Controller 
{
	var $permission = array();

	public function __construct() 
	{
		parent::__construct();

		$group_data = array();
		if(empty($this->session->userdata('logged_in'))) {
			$session_data = array('logged_in' => FALSE);
			$this->session->set_userdata($session_data);
		}
		else {
			$user_id = $this->session->userdata('id');
			$this->load->model('model_notifications');
			$this->load->model('model_groups');
			$group_data = $this->model_groups->getUserGroupByUserId($user_id);
			$this->data['product_status'] = $this->model_notifications->countTotalProductsStatus();
			
			$this->data['user_permission'] = unserialize($group_data['permission']);
			$this->permission = unserialize($group_data['permission']);
		}
	}

	public function logged_in()
	{
		$session_data = $this->session->userdata();
		if($session_data['logged_in'] == TRUE) {
			redirect('dashboard', 'refresh');
		}
	}

	public function not_logged_in()
	{
		$session_data = $this->session->userdata();
		if($session_data['logged_in'] == FALSE) {
			redirect('auth/login', 'refresh');
		}
	}

	public function render_template($page = null, $data = array())
	{

		$this->load->view('templates/header',$data);
		$this->load->view('templates/header_menu',$data);
		$this->load->view('templates/side_menubar',$data);
		$this->load->view($page, $data);
		$this->load->view('templates/footer',$data);
	}

	public function company_currency()
	{
		$this->load->model('model_company');
		$company_currency = $this->model_company->getCompanyData(1);
		$currencies = $this->currency();
			
		$currency = '';
		foreach ($currencies as $key => $value) {
			if($key == $company_currency['currency']) {
				$currency = $value;
			}
		}

		return $currency;

	}

	
	public function currency()
	{
		return $currency_symbols = array(
		  'CAD' => '&#36;',
		  'CDF' => '&#70;&#67;',
		  'EGP' => '&#163;',
		  'ETB' => '&#66;&#114;',
		  'EUR' => '&#8364;',
		  'GBP' => '&#163;',
		  'GHS' => '&#162;',
		  'USD' => '&#36;',
		  'UYU' => '&#36;&#85;',
		  'UZS' => '&#1083;&#1074;',
		  'VEF' => '&#66;&#115;',
		  'VND' => '&#8363;',
		  'VUV' => '&#86;&#84;',
		  'WST' => '&#87;&#83;&#36;',
		  'XAF' => '&#70;&#67;&#70;&#65;',
		  'XCD' => '&#36;',
		  'XPF' => '&#70;',
		  'YER' => '&#65020;',
		  'ZAR' => '&#82;',
		  'ZMK' => '&#90;&#75;', // ?
		  'ZWL' => '&#90;&#36;',
		);
	}
}