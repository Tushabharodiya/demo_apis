<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
	
    function __construct(){
		parent::__construct();
		$this->load->model('JsonModel');
	}
	
	// Data Function
	
	function viewUserData($table){
		$this->db->select('*');
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function viewBusinessDatabyID($cat_id,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('business_cat_id',$cat_id);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

}	 
