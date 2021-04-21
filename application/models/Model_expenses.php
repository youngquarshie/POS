<?php 

class Model_expenses extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	public function getActiveBrands()
	{
		$sql = "SELECT * FROM expenses WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	/* get the brand data */
	public function getExpensesData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM expenses INNER JOIN users ON expenses.user_id = users.id WHERE expenses_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM expenses INNER JOIN users ON expenses.user_id = users.id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('expenses', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('expenses_id', $id);
			$update = $this->db->update('expenses', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('expenses_id', $id);
			$delete = $this->db->delete('expenses');
			return ($delete == true) ? true : false;
		}
	}

}