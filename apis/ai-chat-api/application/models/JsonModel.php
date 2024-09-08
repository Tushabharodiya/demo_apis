<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
    function __construct() {
		parent::__construct();
	}
	
    function getData($where, $table){
		$this->db->select('*');
		$this->db->where($where);
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function viewData($limit, $where, $table){
		$this->db->select('*');
		$this->db->limit($limit);
		$this->db->where($where);
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function editData($where, $table, $editData){
		$this->db->where($where);
        $result = $this->db->update($table, $editData);
		if($result)
			return  true;
		else
			return false;
	}
}