<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Expenses';

		$this->load->model('model_expenses');
	}

	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		if(!in_array('viewExpenses', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$result = $this->model_expenses->getExpensesData();

		$this->data['results'] = $result;

		$this->render_template('expenses/index', $this->data);
	}

	/*
	* Fetches the brand data from the brand table 
	* this function is called from the datatable ajax function
	*/
	public function fetchExpensesData()
	{
		$result = array('data' => array());

		$data = $this->model_expenses->getExpensesData();
		foreach ($data as $key => $value) {

			$date = date('d-m-Y', $value['expense_date']);
			$time = date('h:i a', $value['expense_date']);

			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if(in_array('viewExpenses', $this->permission)) {
				$buttons .= '<button type="button" class="btn btn-default" onclick="editBrand('.$value['expenses_id'].')" data-toggle="modal" data-target="#editBrandModal"><i class="fa fa-pencil"></i></button>';	
			}
			
			if(in_array('deleteExpenses', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeBrand('.$value['expenses_id'].')" data-toggle="modal" data-target="#removeBrandModal"><i class="fa fa-trash"></i></button>
				';
			}				

			// $status = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['purpose'],
				$value['amount'],
				$value['username'],
				$date_time,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* It checks if it gets the brand id and retreives
	* the brand information from the brand model and 
	* returns the data into json format. 
	* This function is invoked from the view page.
	*/
	public function fetchExpensesDataById($id)
	{
		if($id) {
			$data = $this->model_expenses->getExpensesData($id);
			echo json_encode($data);
		}

		return false;
	}

	/*
	* Its checks the brand form validation 
	* and if the validation is successfully then it inserts the data into the database 
	* and returns the json format operation messages
	*/
	public function create()
	{

		if(!in_array('createExpenses', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();
		$user_id = $this->session->userdata('id');

		$this->form_validation->set_rules('purpose', 'Purpose', 'trim|required');
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required');

		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'purpose' => $this->input->post('purpose'),
        		'amount' => $this->input->post('amount'),
				'user_id' => $user_id,
				'expense_date' => strtotime(date('Y-m-d h:i:s a'))	
        	);

        	$create = $this->model_expenses->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Succesfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the expenses information';			
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
	* Its checks the brand form validation 
	* and if the validation is successfully then it updates the data into the database 
	* and returns the json format operation messages
	*/
	public function update($id)
	{
		if(!in_array('updateExpenses', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();
		$user_id = $this->session->userdata('id');

		if($id) {
			$this->form_validation->set_rules('edit_purpose', 'Purpose', 'trim|required');
			$this->form_validation->set_rules('edit_amount', 'Amount', 'trim|required');

			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'purpose' => $this->input->post('edit_purpose'),
	        		'amount' => $this->input->post('edit_amount'),
					'user_id' => $user_id,
					'expense_date' => strtotime(date('Y-m-d h:i:s a'))	
	        	);

	        	$update = $this->model_expenses->update($data, $id);
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
	* It removes the brand information from the database 
	* and returns the json format operation messages
	*/
	public function remove()
	{
		if(!in_array('deleteExpenses', $this->permission)) {
			redirect('dashboard', 'refresh');
		}
		
		$brand_id = $this->input->post('brand_id');
		$response = array();
		if($brand_id) {
			$delete = $this->model_expenses->remove($brand_id);

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