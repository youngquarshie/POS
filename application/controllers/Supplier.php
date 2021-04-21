<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Supplier';

		$this->load->model('model_supplier');
	}

	/* 
	* It only redirects to the manage Supplier page
	*/
	public function index()
	{

		if(!in_array('viewSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('supplier/index', $this->data);	
	}	

	/*
	* It checks if it gets the Supplier id and retreives
	* the supplier information from the Supplier model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchSupplierDataById($id) 
	{
		if($id) {
			$data = $this->model_supplier->getSupplierData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Fetches the category value from the category table 
	* this function is called from the datatable ajax function
	*/
	public function fetchSupplierData()
	{
		$result = array('data' => array());

		$data = $this->model_supplier->getSupplierData();

		foreach ($data as $key => $value) {

			// button
			$buttons = '';

			if(in_array('updateSupplier', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editFunc('.$value['supplier_id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteSupplier', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['supplier_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}
				

			// $status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['supplier_name'],
				$value['supplier_address'],
				$value['supplier_contact'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* Its checks the category form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{
		if(!in_array('createSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('supplier_name', 'Supplier Name', 'trim|required');
		$this->form_validation->set_rules('supplier_address', 'Supplier Address', 'trim|required');
		$this->form_validation->set_rules('supplier_contact', 'Supplier Contact', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'supplier_name' => $this->input->post('supplier_name'),
				'supplier_address' => $this->input->post('supplier_address'),
				'supplier_contact' => $this->input->post('supplier_contact')	
        	);

        	$create = $this->model_supplier->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the brand information';			
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}

	/*
	* Its checks the Supplier form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{

		if(!in_array('updateSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_supplier_name', 'Supplier Name', 'trim|required');
			$this->form_validation->set_rules('edit_supplier_address', 'Supplier Address', 'trim|required');
			$this->form_validation->set_rules('edit_supplier_contact', 'Supplier Contact', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'supplier_name' => $this->input->post('edit_supplier_name'),
					'supplier_address' => $this->input->post('edit_supplier_address'),
					'supplier_contact' => $this->input->post('edit_supplier_contact'),
	  
	        	);

			

	        	$update = $this->model_supplier->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Succesfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updated the brand information';			
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again!!';
		}

		echo json_encode($response);
	}

	/*
	* It removes the category information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteSupplier', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$supplier_id = $this->input->post('supplier_id');

		$response = array();
		if($supplier_id) {
			$delete = $this->model_supplier->remove($supplier_id);
			if($delete == true) {
				$response['success'] = true;
				$response['messages'] = "Successfully removed";	
			}
			else {
				$response['success'] = false;
				$response['messages'] = "Error in the database while removing the brand information";
			}
		}
		else {
			$response['success'] = false;
			$response['messages'] = "Refersh the page again!!";
		}

		echo json_encode($response);
	}

}