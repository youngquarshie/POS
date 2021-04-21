<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Notifications';

		
		$this->load->model('model_notifications');
	}

	/* 
	* It only redirects to the manage product page and
	*/
	public function index()
	{
		if(!in_array('viewExpenses', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$result = $this->model_notifications->getNotificationsData();

		$this->data['results'] = $result;

		$this->render_template('notifications/index', $this->data);
	}

	/*
	* Fetches the brand data from the brand table 
	* this function is called from the datatable ajax function
	*/
	public function fetchNotificationsData()
	{
		$result = array('data' => array());

		$data = $this->model_notifications->getNotificationsData();

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
				"GH¢".$value['price'],
				$value['alert_level'],
                $value['qty'] . ' ' . $qty_status,
				$availability,
			);
		} // /foreach

		echo json_encode($result);
	}	




	/*
	* It removes the brand information from the database 
	* and returns the json format operation messages
	*/


}