<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
    function __construct() {
		parent::__construct();
	}
	
	function rowData($where, $table){
		$this->db->select('*');
		$this->db->where($where);
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function viewData($limit, $where, $table){
		$this->db->select('*');
		$this->db->limit($limit);
		$this->db->where($where);
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function viewCategoryData($table){
		$this->db->select('*');
		$this->db->order_by("category_id", "ASC");
		$this->db->where("category_status","Publish");
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function viewChargingData($table, $where, $params = array()){
	    $this->db->select('*');
	    $this->db->order_by('charging_id','ASC');
	    $this->db->from($table);
	    $this->db->where($where);
	    $this->db->where("charging_status","Publish");
	    if(array_key_exists("charging_id",$params)){
	        $this->db->where('charging_id',$params['charging_id']);
	        $query = $this->db->get();
	        $result = $query->row_array();
	    } else {
	        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
	            $this->db->limit($params['limit'],$params['start']);
	        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
	            $this->db->limit($params['limit']);
	        }
	        if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
	            $result = $this->db->count_all_results();
	        } else {
	            $query = $this->db->get();
	            $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
	        }
	    }
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
	
	// UnPublish Data Functions
	function getData($limit, $where, $table){
		$this->db->select('*');
		$this->db->limit($limit);
		$this->db->where($where);
		$this->db->where("charging_status","Unpublish");
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function getCategoryData($table){
		$this->db->select('*');
		$this->db->order_by("category_id", "ASC");
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function getChargingData($table, $where, $params = array()){
	    $this->db->select('*');
	    $this->db->order_by('charging_id','ASC');
	    $this->db->from($table);
	    $this->db->where($where);
	    $this->db->where("charging_status","Unpublish");
	    if(array_key_exists("charging_id",$params)){
	        $this->db->where('charging_id',$params['charging_id']);
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