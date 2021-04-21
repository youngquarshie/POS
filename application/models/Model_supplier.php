<?php 

class Model_supplier extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* get active brand infromation */
	public function getActiveSupplier()
	{
		$sql = "SELECT * FROM suppliers";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the brand data */
	public function getSupplierData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM suppliers WHERE supplier_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM suppliers";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	
	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('suppliers', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('supplier_id', $id);
			$update = $this->db->update('suppliers', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('supplier_id', $id);
			$delete = $this->db->delete('suppliers');
			return ($delete == true) ? true : false;
		}
	}

	public function countTotalSuppliers()
	{
		$sql = "SELECT * FROM suppliers";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

}