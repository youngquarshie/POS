<?php 

class Model_notifications extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	

	/* get the brand data */
	public function getNotificationsData($id = null)
	{
		
		$sql = "SELECT * FROM products where qty <= alert_level";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function countTotalProductsStatus()
	{
		$sql = "SELECT * FROM products where qty <= alert_level";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}