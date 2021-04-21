<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';
		
		$this->load->model('model_products');
		$this->load->model('model_orders');
		$this->load->model('model_users');
		$this->load->model('model_supplier');
		$this->load->model('model_notifications');
	}

	/* 
	* It only redirects to the manage category page
	* It passes the total product, total paid orders, total users, and total stores information
	into the frontend.
	*/
	public function index()
	{
		$this->data['total_products'] = $this->model_products->countTotalProducts();
		$this->data['product_status'] = $this->model_notifications->countTotalProductsStatus();
		$this->data['total_paid_orders'] = $this->model_orders->countTotalPaidOrders();
		$this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_suppliers'] = $this->model_supplier->countTotalSuppliers();

		$user_id = $this->session->userdata('id');
		$username = $this->session->userdata('username');
		$is_admin = ($user_id == 1) ? true :false;
		$is_admin2 = ($user_id == 6) ? true :false;

		$this->data['is_admin'] = $is_admin;
		$this->data['is_admin2'] = $is_admin2;
		$this->render_template('dashboard', $this->data);
	}
}