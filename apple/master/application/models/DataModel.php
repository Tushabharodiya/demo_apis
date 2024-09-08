<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataModel extends CI_Model {
	
    function __construct(){
		parent::__construct();
		$this->load->model('DataModel');
	}
	
	function getData($table){
		$this->db->select('*');
        $this->db->from($table); 
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
    
    function editBlogData($blogID, $table, $editData){
		$this->db->where('blog_id', $blogID);
        $result = $this->db->update($table, $editData);
		if($result)
			return  true;
		else
			return false;
	}
}    
