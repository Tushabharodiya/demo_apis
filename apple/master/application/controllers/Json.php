<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct(){
			parent::__construct();
			$this->load->model('DataModel');
	}

	public function index(){
		$this->load->view('welcome');
	}
	
	public function blogs(){
	    $blogData = $this->DataModel->getData('apple_blogs');
        echo json_encode($blogData);
	}
	
	public function wallpapers(){
	    $blogData = $this->DataModel->getData('apple_wallpapers');
        echo json_encode($blogData);
	}
	
	public function quotes(){
	    $blogData = $this->DataModel->getData('apple_quotes');
        echo json_encode($blogData);
	}
	
	public function liked(){
	    if($this->input->post('blog_id')){
	       $blogID = $this->input->post('blog_id');
	       $data = $this->DataModel->viewBlogData($blogID,'apple_blogs');
	       
	       if($data){
	        $oldView = $data->blog_views;
	        $totalView = $oldView + 1;
    	    }
    	    $editData = array(
    	        'blog_views'=>$totalView
    		);
    		
    	    $result = $this->DataModel->editBlogData($blogID,'apple_blogs',$editData);
    	    if($result){
    	       $status = "success";
               echo json_encode(array("response"=>$status));
    	    }
	    } else {
	        $status = "error";
            echo json_encode(array("response"=>$status)); 
	    }
	}
	
	public function viewed(){
	    if($this->input->post('blog_id')){
    	    $blogID = $this->input->post('blog_id');
    	    $data = $this->DataModel->viewBlogData($blogID,'apple_blogs');
    	    
    	    if($data){
    	    $oldLike = $data->blog_likes;
    	    $totalLike = $oldLike + 1;
    	    }
    	    $editData = array(
    	        'blog_likes'=>$totalLike
    		);
    	
    	    $result = $this->DataModel->editBlogData($blogID,'apple_blogs',$editData);
    	    if($result){
    	       $status = "success";
               echo json_encode(array("response"=>$status));
    	    }
	    } else {
	        $status = "error";
            echo json_encode(array("response"=>$status));
	    }
	}
}
