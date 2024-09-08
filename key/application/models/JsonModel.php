<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
	
    function __construct(){
		parent::__construct();
		$this->load->model('JsonModel');
	}
	
	function viewData($table){
		$this->db->select('*');
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
}	 
