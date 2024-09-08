<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataModel extends CI_Model {
	
    function __construct(){
		parent::__construct();
		$this->load->model('DataModel');
	}

	function getCategoryData($table){
		$this->db->select('*');
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function getMainData($table, $categoryID){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("category_id", $categoryID);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}    
