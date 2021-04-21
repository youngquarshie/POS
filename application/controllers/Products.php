<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Products';

		$this->load->model('model_products');
		$this->load->model('model_category');
		$this->load->model('model_stores');
        $this->load->model('model_supplier');
		$this->load->model('model_attributes');

        $this->load->library('session');
	}

    /* 
    * It only redirects to the manage product page
    */
	public function index()
	{
        if(!in_array('viewProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->render_template('products/index', $this->data);	
	}

    /*
    * It Fetches the products data from the product table 
    * this function is called from the datatable ajax function
    */
	public function fetchProductData()
	{
		$result = array('data' => array());

		$data = $this->model_products->getProductData();

		foreach ($data as $key => $value) {

            //$store_data = $this->model_stores->getStoresData($value['store_id']);
			// button
            $buttons = '';
            if(in_array('updateProduct', $this->permission)) {
    			$buttons .= '<a href="'.base_url('products/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if(in_array('deleteProduct', $this->permission)) { 
    			$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }
			
            $availability = ($value['availability'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

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
                $value['qty'] . ' ' . $qty_status,
				$availability,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}	

    /*
    * If the validation is not valid, then it redirects to the create page.
    * If the validation for each input field is valid then it inserts the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function create()
	{
		if(!in_array('createProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        $user_id = $this->session->userdata('id');

		$this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('variation_name', 'Variation name', 'trim|required');
        $this->form_validation->set_rules('alert_level', 'Alert Level', 'trim|required');
        $this->form_validation->set_rules('wholesale_price', 'Wholesale Price', 'trim|required');
        $this->form_validation->set_rules('expiry_date', 'Expiry Date', 'trim|required');
		$this->form_validation->set_rules('price', 'Price', 'trim|required');
		$this->form_validation->set_rules('qty', 'Qty', 'trim|required');
		$this->form_validation->set_rules('availability', 'Availability', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {
            // true case
        	//$upload_image = $this->upload_image();

        	$data = array(
        		'name' => $this->input->post('product_name'),
                'variation_name' => $this->input->post('variation_name'),
        		'price' => $this->input->post('price'),
        		'alert_level' => $this->input->post('alert_level'),
                'wholesale_price' => $this->input->post('wholesale_price'),
                'profit' => $this->input->post('price') - $this->input->post('wholesale_price'),
                'expiry_date' => $this->input->post('expiry_date'),
                'supplier_id' => $this->input->post('supplier'),
                'qty' => $this->input->post('qty'),
        		'description' => $this->input->post('description'),
        		'category_id' => $this->input->post('category'),
                'user_id' => $user_id,
        		'availability' => $this->input->post('availability'),
        	);

            $create = $this->model_products->create($data);
                if($create == true) {
                    $this->session->set_flashdata('success', 'Product Successfully created');
                    redirect('products/', 'refresh');
                }
                else {
                    $this->session->set_flashdata('errors', 'Error occurred!!');
                    redirect('products/create', 'refresh');
                }

            // $duplicate =array(
            //     'name' => $this->input->post('product_name'),
            //     'variation_name' => $this->input->post('variation_name')
            // );

            //$check = $this->model_products->checkDuplicate($duplicate);

            //echo $check;
            //exit();
            // if($check !== 0){
            //     $this->session->set_flashdata('item','Error | Duplicate Entry, Try Again'); 
            //     redirect('products/create');
            // }
            // else{

                

            // }
            

        	
        }
        else {
            // false case
     	
			$this->data['category'] = $this->model_category->getActiveCategroy();        
            $this->data['supplier'] = $this->model_supplier->getActiveSupplier();
                  	
            $this->render_template('products/create', $this->data);
        }	
	}

    /*
    * This function is invoked from another function to upload the image into the assets folder
    * and returns the image path
    */
	public function upload_image()
    {
    	// assets/images/product_image
        $config['upload_path'] = 'assets/images/product_image';
        $config['file_name'] =  uniqid();
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '1000';

        // $config['max_width']  = '1024';s
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('product_image'))
        {
            $error = $this->upload->display_errors();
            return $error;
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $type = explode('.', $_FILES['product_image']['name']);
            $type = $type[count($type) - 1];
            
            $path = $config['upload_path'].'/'.$config['file_name'].'.'.$type;
            return ($data == true) ? $path : false;            
        }
    }

    /*
    * If the validation is not valid, then it redirects to the edit product page 
    * If the validation is successfully then it updates the data into the database 
    * and it stores the operation message into the session flashdata and display on the manage product page
    */
	public function update($product_id)
	{      
        if(!in_array('updateProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

        if(!$product_id) {
            redirect('dashboard', 'refresh');
        }

        $this->form_validation->set_rules('product_name', 'Product name', 'trim|required');
        $this->form_validation->set_rules('wholesale_price', 'Wholesale Price', 'trim|required');
        $this->form_validation->set_rules('price', 'Price', 'trim|required');
        $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
        $this->form_validation->set_rules('availability', 'Availability', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            // true case
            
            $data = array(
                'name' => $this->input->post('product_name'),
                'variation_name' => $this->input->post('variation_name'),
                'price' => $this->input->post('price'),
                'qty' => $this->input->post('qty'),
                'description' => $this->input->post('description'),
                'alert_level' => $this->input->post('alert_level'),
                'expiry_date' => $this->input->post('expiry_date'),
                'wholesale_price' => $this->input->post('wholesale_price'),
                'category_id' => $this->input->post('category'),
                'supplier_id' => $this->input->post('supplier'),
                'availability' => $this->input->post('availability'),
            );

            
            $update = $this->model_products->update($data, $product_id);
            if($update == true) {
                $this->session->set_flashdata('success', 'Successfully updated');
                redirect('products/', 'refresh');
            }
            else {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('products/update/'.$product_id, 'refresh');
            }
        }
        else {
                    
            $this->data['category'] = $this->model_category->getActiveCategroy();           
            $this->data['supplier'] = $this->model_supplier->getActiveSupplier();         
            
            $product_data = $this->model_products->getProductData($product_id);
            $this->data['product_data'] = $product_data;
            
            $this->render_template('products/edit', $this->data); 
        }   
	}

    /*
    * It removes the data from the database
    * and it returns the response into the json format
    */
	public function remove()
	{
        if(!in_array('deleteProduct', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
        
        $product_id = $this->input->post('product_id');

        $response = array();
        if($product_id) {
            $delete = $this->model_products->remove($product_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response);
	}

   

}