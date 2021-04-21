<?php 

class Model_receiving extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get active brand infromation */
	public function getActiveSupplies()
	{
		$sql = "SELECT * FROM received_supplies";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the brand data */
	public function getReceivingData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM received_supplies_items 
			INNER JOIN received_supplies ON received_supplies.receiving_id= received_supplies_items.id_receiving 
			INNER JOIN products ON products.id = received_supplies_items.product_id 
			INNER JOIN users on users.id = 	received_supplies.user_id WHERE received_supplies.receiving_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM received_supplies_items 
		INNER JOIN received_supplies ON received_supplies.receiving_id= received_supplies_items.id_receiving 
		INNER JOIN products ON products.id = received_supplies_items.product_id 
		INNER JOIN users on users.id = 	received_supplies.user_id
		ORDER BY receiving_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// get the orders item data
	public function getReceivingItemData($receiving_id = null)
	{
		if(!$receiving_id) {
			return false;
		}

		$sql = "SELECT * FROM received_supplies_items 
		INNER JOIN received_supplies ON received_supplies.receiving_id= received_supplies_items.id_receiving 
		INNER JOIN products ON products.id = received_supplies_items.product_id 
		INNER JOIN users on users.id = 	received_supplies.user_id WHERE received_supplies_items.id_receiving = ?";
		$query = $this->db->query($sql, array($receiving_id));
		return $query->result_array();
	}


	public function create()
	{
		$user_id = $this->session->userdata('id');
		// $bill_no = 'KCL-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));
    	$data = array(
    		'invoice_no' => $this->input->post('invoice_no'),
    		'receiving_date' => strtotime(date('Y-m-d h:i:s a')),
    		'user_id' => $user_id
    	);

		
		//$insert = $this->db->insert('orders', $data); 
		$insert = $this->db->insert('received_supplies', $data); 
		$receiving_id = $this->db->insert_id();

		$this->load->model('model_products');

		$count_product = count($this->input->post('product'));
    	for($x = 0; $x < $count_product; $x++) {
    		$items = array(
    			'id_receiving' => $receiving_id,
    			'product_id' => $this->input->post('product')[$x],
    			'supplies_qty' => $this->input->post('qty')[$x],
    			'amount' => $this->input->post('amount')[$x]
    		);

			//var_dump($items);
			
    		$this->db->insert('received_supplies_items', $items);

    		//now increase the stock from the product
    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
    		$qty = (int) $product_data['qty'] + (int) $this->input->post('qty')[$x];

    		$update_product = array('qty' => $qty);

    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
    	}

		//exit();

		return ($receiving_id) ? $receiving_id : false;
	}

	public function update($id)
	{
		if($id) {
			$user_id = $this->session->userdata('id');
			// fetch the order data 

			$data = array(
				'customer_name' => $this->input->post('customer_name'),
	    		'customer_phone' => $this->input->post('customer_phone'),
	    		'gross_amount' => $this->input->post('gross_amount_value'),
	    		'vat_charge_rate' => $this->input->post('vat_charge_rate'),
	    		'vat_charge' => ($this->input->post('vat_charge_value') > 0) ? $this->input->post('vat_charge_value') : 0,
	    		'net_amount' => $this->input->post('net_amount_value'),
	    		'discount' => $this->input->post('discount'),
	    		'paid_status' => $this->input->post('paid_status'),
	    		'user_id' => $user_id
	    	);

			$this->db->where('id', $id);
			$update = $this->db->update('orders', $data);

			// now the order item 
			// first we will replace the product qty to original and subtract the qty again
			$this->load->model('model_products');
			$get_order_item = $this->getOrdersItemData($id);
			foreach ($get_order_item as $k => $v) {
				$product_id = $v['product_id'];
				$qty = $v['qty'];
				// get the product 
				$product_data = $this->model_products->getProductData($product_id);
				$update_qty = $qty + $product_data['qty'];
				$update_product_data = array('qty' => $update_qty);
				
				// update the product qty
				$this->model_products->update($update_product_data, $product_id);
			}

			// now remove the order item data 
			$this->db->where('order_id', $id);
			$this->db->delete('orders_item');

			// now decrease the product qty
			$count_product = count($this->input->post('product'));
	    	for($x = 0; $x < $count_product; $x++) {
	    		$items = array(
	    			'order_id' => $id,
	    			'product_id' => $this->input->post('product')[$x],
	    			'qty' => $this->input->post('qty')[$x],
	    			'rate' => $this->input->post('rate_value')[$x],
	    			'amount' => $this->input->post('amount_value')[$x],
	    		);
	    		$this->db->insert('orders_item', $items);

	    		// now decrease the stock from the product
	    		$product_data = $this->model_products->getProductData($this->input->post('product')[$x]);
	    		$qty = (int) $product_data['qty'] - (int) $this->input->post('qty')[$x];

	    		$update_product = array('qty' => $qty);
	    		$this->model_products->update($update_product, $this->input->post('product')[$x]);
	    	}

			return true;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('receiving_id', $id);
			$delete = $this->db->delete('received_supplies');

			$this->db->where('id_receiving', $id);
			$delete_item = $this->db->delete('received_supplies_items');
			return ($delete == true && $delete_item) ? true : false;
		}
	}



	public function countReceivingItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM received_supplies_item WHERE id_receiving = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

}