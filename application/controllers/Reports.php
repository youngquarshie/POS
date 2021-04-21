<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Reports';
		$this->load->model('model_reports');
		$this->load->model('model_category');
		$this->load->model('model_products');
	}

	/* 
    * It redirects to the report page
    * and based on the year, all the orders data are fetch from the database.
    */
	public function index()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$today_year = date('Y');

		if($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$parking_data = $this->model_reports->getOrderData($today_year);
		$this->data['report_years'] = $this->model_reports->getOrderYear();
		

		$final_parking_data = array();
		foreach ($parking_data as $k => $v) {
			
			if(count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if($v2) {
						$total_amount_earned[] = $v2['gross_amount'];						
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);	
			}
			else {
				$final_parking_data[$k] = 0;	
			}
			
		}
		
		$this->data['selected_year'] = $today_year;
		$this->data['company_currency'] = $this->company_currency();
		$this->data['results'] = $final_parking_data;

		$this->render_template('reports/index', $this->data);
	}

	public function products_reports()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Products Reports';
		
		$today_date = date('Y-m-d');		
		$this->data['selected_day'] = $today_date;
		$this->data['company_currency'] = $this->company_currency();



		$this->render_template('reports/products_reports', $this->data);
	}

	public function daily_products_reports()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Daily Sales Reports';
		
		$today_date = date('Y-m-d');		
		$this->data['selected_day'] = $today_date;
		$this->data['company_currency'] = $this->company_currency();



		$this->render_template('reports/daily_products_reports', $this->data);
	}

	public function sales_by_products_reports()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$this->data['page_title'] = 'Sales by Products Report';
		$this->data['company_currency'] = $this->company_currency();
		$this->data['products'] = $this->model_products->getAllProductData(); 


		$this->render_template('reports/sales_by_products_reports', $this->data);
	}

	public function sales_by_category_reports()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Sales by Category Reports';
		$this->data['category'] = $this->model_category->getActiveCategroy();  
		$this->data['company_currency'] = $this->company_currency();



		$this->render_template('reports/sales_by_category_reports', $this->data);
	}


	public function fetchOrderData()
	{
		$result = array('data' => array());

		$submited_date = $this->uri->segment(3);
		
		$data = $this->model_reports->getOrderDatabyDate($submited_date);
	
		foreach ($data as $key => $value) {

				
			$date = date('Y-m-d', $value['date_sold']);
			$time = date('h:i a', $value['time_sold']);

			$date_time = $date . ' ' . $time;
			$only_date = $date;
        
			

            $qty_status = '';
            if($value['qty'] <= 10) {
                $qty_status = '<span class="label label-warning">Low !</span>';
            } else if($value['qty'] <= 0) {
                $qty_status = '<span class="label label-danger">Out of stock !</span>';
            }


			$result['data'][$key] = array(
                $value['name']." ".$value['variation_name'],
                $value['order_qty'],
				$date_time,
				"GH¢".$value['amount']
				
			);
		} // /foreach

		

		echo json_encode($result);
	}


	public function fetchOrderDatabyCategory()
	{
		$result = array('data' => array());

		$submited_category = $this->uri->segment(3);
		
		$data = $this->model_reports->getOrderDatabyCategory($submited_category);
	
		foreach ($data as $key => $value) {

				
			$date = date('Y-m-d', $value['date_sold']);
			$time = date('h:i a', $value['time_sold']);

			$date_time = $date . ' ' . $time;
			$only_date = $date;
        
			

            $qty_status = '';
            if($value['qty'] <= 10) {
                $qty_status = '<span class="label label-warning">Low !</span>';
            } else if($value['qty'] <= 0) {
                $qty_status = '<span class="label label-danger">Out of stock !</span>';
            }


			$result['data'][$key] = array(
                $value['name']." ".$value['variation_name'],
                $value['order_qty'],
				$date_time,
				"GH¢".$value['amount']
				
			);
		} // /foreach

		

		echo json_encode($result);
	}

	public function fetchOrderDatabyProduct()
	{
		$result = array('data' => array());

		$product_id = $this->uri->segment(3);
		
		$data = $this->model_reports->getOrderDatabyProduct($product_id);
	
		foreach ($data as $key => $value) {

				
			$date = date('Y-m-d', $value['date_sold']);
			$time = date('h:i a', $value['time_sold']);

			$date_time = $date . ' ' . $time;
			$only_date = $date;
        
			

            $qty_status = '';
            if($value['qty'] <= 10) {
                $qty_status = '<span class="label label-warning">Low !</span>';
            } else if($value['qty'] <= 0) {
                $qty_status = '<span class="label label-danger">Out of stock !</span>';
            }


			$result['data'][$key] = array(
                $value['name']." ".$value['variation_name'],
                $value['order_qty'],
				$date_time,
				"GH¢".$value['amount']
				
			);
		} // /foreach

		

		echo json_encode($result);
	}

	public function fetchAllProducts()
	{
		$result = array('data' => array());
		
		$data = $this->model_reports->getAllProducts();
	
		foreach ($data as $key => $value) {

				
		
            $qty_status = '';
            if($value['qty'] <= 10) {
                $qty_status = '<span class="label label-warning">Low !</span>';
            } else if($value['qty'] <= 0) {
                $qty_status = '<span class="label label-danger">Out of stock !</span>';
            }


			$result['data'][$key] = array(
                $value['name']." ".$value['variation_name'],
				"GH¢".$value['wholesale_price'],
				"GH¢".$value['price'],
                $value['qty'],
				"GH¢".$value['profit'],
				
			);
		} // /foreach

		

		echo json_encode($result);
	}
}	