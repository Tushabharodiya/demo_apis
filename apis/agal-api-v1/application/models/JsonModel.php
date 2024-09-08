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
		$this->db->where("category_status","publish");
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function viewApplockData($table, $where, $params = array()){
	    $this->db->select('*');
	    $this->db->order_by('applock_id','ASC');
	    $this->db->from($table);
	    $this->db->where($where);
	    $this->db->where("applock_status","publish");
	    if(array_key_exists("applock_id",$params)){
	        $this->db->where('applock_id',$params['applock_id']);
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
		$this->db->where("applock_status","unpublish");
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
	function getApplockData($table, $where, $params = array()){
	    $this->db->select('*');
	    $this->db->order_by('applock_id','ASC');
	    $this->db->from($table);
	    $this->db->where($where);
	    $this->db->where("applock_status","unpublish");
	    if(array_key_exists("applock_id",$params)){
	        $this->db->where('applock_id',$params['applock_id']);
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