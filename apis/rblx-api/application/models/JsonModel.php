<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
    function __construct() {
		parent::__construct();
	}
	
	// ====================================================================== //
    /* Common Functions */
    // ====================================================================== //
    function getData($where, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($where){ $this->db->where($where); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function viewData($order, $limit, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order);
		if($order){ $this->db->order_by($order); }
		if($limit){ $this->db->limit($limit); }
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
    
    // ====================================================================== //
    /* Skin Functions */
    // ====================================================================== //
	function viewSkinData($order, $limit, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		if($order){ $this->db->order_by($order); }
		if($limit){ $this->db->limit($limit); }
		$this->db->where('skin_status','Publish');
		$this->db->where_in('category_id',$where);
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function rblxSkinData($params, $order, $where, $table){
	    $this->db->select('*');
	    $this->db->from($table);
	    $this->db->order_by($order);
	    if($where){ $this->db->where($where); }
	    $this->db->where("skin_status","Publish");
	    if(array_key_exists("skin_id",$params)){
	        $this->db->where('skin_id',$params['skin_id']);
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
	
	function viewRblxSkinData($params, $order, $where, $table){
	    $this->db->select('*');
	    $this->db->from($table);
	    $this->db->order_by($order);
	    $this->db->where_in('category_id',$where);
	    $this->db->where("skin_status","Publish");
	    if(array_key_exists("skin_id",$params)){
	        $this->db->where('skin_id',$params['skin_id']);
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
	
	function searchSkinData($params, $where, $table){
	    $this->db->select('*');
	    $this->db->from($table);
	    $this->db->where("(skin_name LIKE '%$where%')");
	    $this->db->where("skin_status","Publish");
	    if(array_key_exists("skin_id",$params)){
	        $this->db->where('skin_id',$params['skin_id']);
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