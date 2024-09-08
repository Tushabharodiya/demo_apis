<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
    function __construct() {
		parent::__construct();
	}
	
	// common Functions
	function viewDevice($where, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("device_string", $where);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function viewSearch($query, $where, $table){  
	    $this->db->select('*');    
	    $this->db->from($table);  
	    $this->db->where($where);
	    $this->db->like('data_name', $query);
	    $query = $this->db->get()->result(); 
	    return $query;
	}
	function viewData($where, $order, $limit, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		if($limit){ $this->db->limit($limit); }
		$this->db->order_by($order, "ASC");
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function getData($where, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->row();
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
	function insertData($table,$data){
		$result = $this->db->insert($table,$data);
		if($result)
			return $this->db->insert_id();
		else
			return false;
	}
	
	// App Functions
	function getAppData($appCode, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("app_code", $appCode);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function getVersionData($appID, $appVersion, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("app_id", $appID);
		$this->db->where("version_name", $appVersion);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function getAdsData($appID,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("app_id", $appID);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function getJsonData($appID, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("app_id", $appID);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function getBannerData($bannerID, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("banner_id", $bannerID);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function getAppSubscriptionData($appID, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("app_id", $appID);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function getSubscriptionData($subscriptionID, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("subscription_id", $subscriptionID);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
	// Pagination Function
	function viewAllData($categoryID, $params, $table){
	    $this->db->select('*');
	    $this->db->order_by('unique_id','DESC');
	    $this->db->where('data_status', 'publish');
	    $this->db->where('category_id', $categoryID);
	    $this->db->from($table);
	    if(array_key_exists("unique_id",$params)){
	        $this->db->where('unique_id',$params['unique_id']);
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
	            $result = ($query->num_rows() > 0)?$query->result():FALSE;
	        }
	    }
	    return $result;
	}
}