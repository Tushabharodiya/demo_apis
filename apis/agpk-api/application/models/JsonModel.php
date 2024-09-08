<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
    function __construct() {
		parent::__construct();
	}
	
	function getData($limit, $where, $table){
		$this->db->select('*');
		$this->db->limit($limit);
		$this->db->where($where);
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function getKeyboardCategoryData($limit, $table){
		$this->db->select('*');
		$this->db->limit($limit);
		$this->db->order_by("category_id", "ASC");
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function viewKeyboardData($table, $where, $params = array()){
	    $this->db->select('*');
	    $this->db->order_by('keyboard_id','ASC');
	    $this->db->from($table);
	    $this->db->where($where);
	    if(array_key_exists("keyboard_id",$params)){
	        $this->db->where('keyboard_id',$params['keyboard_id']);
	        $query = $this->db->get();
	        $result = $query->row_array();
	    }else{
	        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
	            $this->db->limit($params['limit'],$params['start']);
	        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
	            $this->db->limit($params['limit']);
	        }
	        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
	            $result = $this->db->count_all_results();
	        }else{
	            $query = $this->db->get();
	            $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
	        }
	    }
	    return $result;
	}
}