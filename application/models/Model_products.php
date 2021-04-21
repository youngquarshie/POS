<?php 

class Model_products extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get the brand data */
	public function getProductData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM products where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM products ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getActiveProductDataforSupplies($id)
	{
		if($id) {
			$sql = "SELECT * FROM products 
			INNER JOIN received_supplies_items ON received_supplies_items.product_id= products.id
			where received_supplies_items.id_receiving = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

	}

	


	public function getActiveProductData()
	{
		$sql = "SELECT * FROM products WHERE availability = ? AND qty > ?  ORDER BY id DESC";
		$query = $this->db->query($sql, array(1, 0));
		return $query->result_array();
	}

	public function getAllProductData()
	{
		$sql = "SELECT * FROM products ORDER BY id DESC";
		$query = $this->db->query($sql, array(1, 0));
		return $query->result_array();
	}

	public function checkDuplicate($data)
	{
		
	
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where($data);
		$query = $this->db->get();
		echo $query->num_rows();
	}


	

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('products', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('products', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('products');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalProducts()
	{
		$sql = "SELECT * FROM products";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}