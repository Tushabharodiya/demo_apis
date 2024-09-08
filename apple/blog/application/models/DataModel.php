<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataModel extends CI_Model {
	
	    function __construct(){
			parent::__construct();
			$this->load->model('DataModel');
		}
		
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
		function viewAds($appID,$table){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where("app_id", $appID);
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
		
		
		

		function addUser($table,$data){
    		$result = $this->db->insert($table,$data);
    		if($result)
    			return true;
    		else
    			return false;
    	}
    	
    	function viewUser($userDevice,$table){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where("user_device", $userDevice);
			$query = $this->db->get();
			$result = $query->row();
			return $result;
		}
    	
    	function editUser($userDevice, $table, $editData){
    		$this->db->where('user_device', $userDevice);
            $result = $this->db->update($table, $editData);
    		if($result)
    			return  true;
    		else
    			return false;
    	}
    	
    	function getData($table){
			$this->db->select('*');
            $this->db->from($table); 
            $this->db->limit(10);
            $query = $this->db->get();
            $result = $query->result();
            return $result; 
		}
		
		function getBlogData($table){
			$this->db->select('*');
            $this->db->from($table); 
            $this->db->order_by("blog_id", "desc");
            $this->db->limit(10);
            $query = $this->db->get();
            $result = $query->result();
            return $result; 
		}
		
		function viewBlogData($blogID, $table){
    		$this->db->select('*');
    		$this->db->where('blog_id', $blogID);
    		$this->db->from($table);
    		$query = $this->db->get();
    		$result = $query->row();
    		return $result;
	    }
	    
	    function editBlog($blogID, $table, $editData){
    		$this->db->where('blog_id', $blogID);
            $result = $this->db->update($table, $editData);
    		if($result)
    			return  true;
    		else
    			return false;
    	}
    	
		
		function getBlogCount($blogID,$table){
			$this->db->select('*');
            $this->db->from($table); 
            $this->db->where('blog_id', $blogID);
            $query = $this->db->get();
            $result = $query->num_rows();
            return $result; 
		}
		
		function blogData($blogID,$table){
			$this->db->select('*');
            $this->db->from($table); 
            $this->db->where('blog_id', $blogID);
            $query = $this->db->get();
            $result = $query->result();
            return $result; 
		}
		
		function getBannerData($table){
			$this->db->select('*');
            $this->db->from($table); 
            $query = $this->db->get();
            $result = $query->result();
            return $result; 
		}
		
		function getQuoteData($table){
			$this->db->select('*');
            $this->db->from($table); 
            $this->db->order_by("quote_id");
            $this->db->limit(10);
            $query = $this->db->get();
            $result = $query->result();
            return $result; 
		}
		
		function getSubscriptionData($table,$order){
			$this->db->select('*');
            $this->db->from($table); 
            $this->db->where('product_status', 'true');
            $this->db->order_by('product_id',$order);
            $query = $this->db->get();
            $result = $query->result();
            return $result; 
		}
}    

