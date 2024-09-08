<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
	
    function __construct(){
		parent::__construct();
		$this->load->model('JsonModel');
	}
	
	// App Data Function
	function viewApp($appCode,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("app_code", $appCode);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function viewVersion($appID,$appVersion,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("app_id", $appID);
		$this->db->where("version_name", $appVersion);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function viewJson($appID,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("app_id", $appID);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function viewBanner($bannerID,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("banner_id", $bannerID);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
	function getData($whereOne, $whereTwo, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($whereOne){ $this->db->where($whereOne); }
		if($whereTwo){ $this->db->where($whereTwo); }
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
	function viewData($whereOne, $whereTwo, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($whereOne){ $this->db->where($whereOne); }
		if($whereTwo){ $this->db->where($whereTwo); }
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function isDiscountActive($where, $table){
		$this->db->select('*');
		$this->db->where($where);
		$this->db->where('discount_status', "activated");
		$this->db->from($table);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	//Category Function
	function getMainCategoryData($table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("main_category_status", "publish");
		$this->db->order_by("main_category_position", "ASC");
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function getFestivalData($categoryID, $todayDate, $nextDate, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("main_category_id", $categoryID);
		$this->db->order_by("sub_category_position", "ASC");
		$this->db->where('sub_category_timestamp >=', $todayDate);
        $this->db->where('sub_category_timestamp <=', $nextDate);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function getSubCategoryData($categoryID, $whereNot, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("main_category_id", $categoryID);
		//$this->db->order_by("sub_category_position", "ASC");
		$this->db->order_by('RAND()');
		$this->db->where_not_in('main_category_id', $whereNot);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function getBusinessThemeData($categoryID, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("main_category_id", $categoryID);
		$this->db->where("sub_category_data", "Theme");
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function getBusinessStoryData($categoryID, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("main_category_id", $categoryID);
		$this->db->where("sub_category_data", "Story");
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	function getFestivalStoryData($categoryID, $todayDate, $nextDate, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("main_category_id", $categoryID);
		$this->db->order_by("sub_category_position", "ASC");
		$this->db->where("sub_category_data", "Story");
		$this->db->where('sub_category_timestamp >=', $todayDate);
        $this->db->where('sub_category_timestamp <=', $nextDate);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	//Theme Function
	function getThemeData($table, $limit, $where){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->order_by("theme_id", "DESC");
		$this->db->where($where);
		$this->db->limit($limit);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	function getCoupon($where, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($where){ $this->db->where("coupon_code", $where); }
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
    
	//Common Function
	function insertData($table,$data){
		$result = $this->db->insert($table,$data);
		if($result)
			return $this->db->insert_id();
		else
			return false;
	}
	function editData($where, $table, $editData){
		$this->db->where($where);
        $result = $this->db->update($table, $editData);
		if($result)
			return  true;
		else
			return false;
	}
	
	// Download Insight
	function viewDownloadYear($whereOne, $whereTwo, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($whereOne){ $this->db->where($whereOne); }
		if($whereTwo){ $this->db->where('user_year', $whereTwo); }
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function viewDownloadMonth($whereOne, $whereTwo, $whereThree, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($whereOne){ $this->db->where($whereOne); }
		if($whereTwo){ $this->db->where('user_year', $whereTwo); }
		if($whereThree){ $this->db->where('user_month', $whereThree); }
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	function viewDownloadDate($whereOne, $whereTwo, $whereThree, $whereFour, $whereFive, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($whereOne){ $this->db->where($whereOne); }    
		if($whereTwo){ $this->db->where('user_year', $whereTwo); }
		if($whereThree){ $this->db->where('user_month', $whereThree); }
		if($whereFour){ $this->db->where($whereFour, ''); }
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
}	 
