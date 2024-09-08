<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JsonModel extends CI_Model {
	
	    function __construct(){
			parent::__construct();
			$this->load->model('JsonModel');
		}
		
		// App Functions
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
		function viewBlocked($zip, $table){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where("blocked_pincode", $zip);
			$query = $this->db->get();
			$result = $query->result();
			return $result;
		}
		
		function viewData($table){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where("cm_status", "publish");
			$this->db->order_by("cm_id", "DESC");
			$this->db->limit(10);
			$query = $this->db->get();
			$result = $query->result();
			return $result;
		}
		
		function webData($table){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where("web_status", "publish");
			$query = $this->db->get();
			$result = $query->result();
			return $result;
		}
		
		function viewSocial($table){
			$this->db->select('*');
			$this->db->from($table);
			$query = $this->db->get();
			$result = $query->result();
			return $result;
		}
		
		//Ip Functions
    	function checkCountry($countryName, $table){
    		$this->db->select('*');
    		$this->db->from($table);
    		$this->db->where('country_name', $countryName);
    		$query = $this->db->get();
    		$result = $query->row();
    		return $result;
    	}
    	function checkRegion($countryID, $regionName, $table){
    		$this->db->select('*');
    		$this->db->from($table);
    		$this->db->where('country_id', $countryID);
    		$this->db->where('region_name', $regionName);
    		$query = $this->db->get();
    		$result = $query->row();
    		return $result;
    	}
    	function checkCity($countryID, $regionID, $cityName, $table){
    		$this->db->select('*');
    		$this->db->from($table);
    		$this->db->where('country_id', $countryID);
    		$this->db->where('region_id', $regionID);
    		$this->db->where('city_name', $cityName);
    		$query = $this->db->get();
    		$result = $query->row();
    		return $result;
    	}
    	function checkZip($countryID, $regionID, $cityID, $zipCode, $table){
    		$this->db->select('*');
    		$this->db->from($table);
    		$this->db->where('country_id', $countryID);
    		$this->db->where('region_id', $regionID);
    		$this->db->where('city_id', $cityID);
    		$this->db->where('postal_code', $zipCode);
    		$query = $this->db->get();
    		$result = $query->row();
    		return $result;
    	}
    	function viewZipData($zipID, $table){
    		$this->db->select('*');
    		$this->db->from($table);
    		$this->db->where('postal_id', $zipID);
    		$query = $this->db->get();
    		$result = $query->row();
    		return $result;
    	}
    	function checkVersion($appID, $versionID, $countryID, $regionID, $cityID, $zipCode, $table){
    		$this->db->select('*');
    		$this->db->from($table);
    		$this->db->where('app_id', $appID);
    		$this->db->where('version_id', $versionID);
    		$this->db->where('data_country', $countryID);
    		$this->db->where('data_region', $regionID);
    		$this->db->where('data_city', $cityID);
    		$this->db->where('data_postal', $zipCode);
    		$query = $this->db->get();
    		$result = $query->row();
    		return $result;
    	}
    	function checkData($appID, $countryID, $regionID, $cityID, $zipCode, $table){
    		$this->db->select('*');
    		$this->db->from($table);
    		$this->db->where('app_id', $appID);
    		$this->db->where('data_country', $countryID);
    		$this->db->where('data_region', $regionID);
    		$this->db->where('data_city', $cityID);
    		$this->db->where('data_postal', $zipCode);
    		$query = $this->db->get();
    		$result = $query->row();
    		return $result;
    	}
    	function editZData($dataID, $table, $editData){
    		$this->db->where('data_id', $dataID);
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
}	 
