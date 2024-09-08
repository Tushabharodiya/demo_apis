<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
    function __construct() {
		parent::__construct();
	}
	
	// ====================================================================== //
    /* Common Functions */
    // ====================================================================== //
    function insertData($table, $data){
		$result = $this->db->insert($table, $data);
		if($result)
			return $this->db->insert_id();
		else
			return false;
	}
	
	function getData($where, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($where){ $this->db->where($where); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function viewData($limit, $order, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->limit($limit);
		if($order){ $this->db->order_by($order); }
		if($where){ $this->db->where($where); }
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
	
	function deleteData($where, $table){
		$this->db->where($where);
		$result = $this->db->delete($table);
		if($result)
			return true;
		else
			return false;
	}
	
	// ====================================================================== //
    /* Ai Gallery Functions */
    // ====================================================================== //
    // Category Functions
	function viewAiGalleryCategory($params, $table){
	    $this->db->select('*');
	    $this->db->order_by('category_id','DESC');
	    $this->db->from($table);
	    $this->db->where("category_status","publish");
	    if(array_key_exists("category_id",$params)){
	        $this->db->where('category_id',$params['category_id']);
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
	
	// Data Functions
	function viewAiGalleryData($params, $where, $table){
	    $this->db->select('*');
	    $this->db->order_by('image_id','DESC');
	    $this->db->from($table);
	    $this->db->where('category_id', $where);
	    $this->db->where("image_status","publish");
	    if(array_key_exists("image_id",$params)){
	        $this->db->where('image_id',$params['image_id']);
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
}