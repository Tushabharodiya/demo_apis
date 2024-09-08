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
	
	public function pquotes(){
	    $quotes = $this->DataModel->getCategoryData('wg_popular_quotes');
	    if($quotes != null){
	        echo json_encode(array("pquotes"=>$quotes));
	    } else {
    		$response['message']="failure";
    		echo json_encode($response);
	    }
    }
	
	public function quotes(){
	    $category = $this->DataModel->getCategoryData('wg_quotes_category');
	    if($category != null){
	        echo json_encode(array("quotes"=>$category));
	    } else {
    		$response['message']="failure";
    		echo json_encode($response);
	    }
    }
    
    public function quote(){
        $catID = $this->input->post('category_id');
        if(ctype_digit($catID)){
    	    $quote = $this->DataModel->getMainData('wg_quotes', $catID);
    	    if($quote != null){
    	        echo json_encode(array("quote"=>$quote));
    	    } else {
        		$response['message']="failure";
        		echo json_encode($response);
    	    }
        } else {
            $response['message']="failure";
    		echo json_encode($response);
        }
    }
    
    public function wallpapers(){
	    $category = $this->DataModel->getCategoryData('wg_wallpaper_category');
	    if($category != null){
	        echo json_encode(array("wallpapers"=>$category));
	    } else {
    		$response['message']="failure";
    		echo json_encode($response);
	    }
    }
    
    public function wallpaper(){
        $catID = $this->input->post('category_id');
        if(ctype_digit($catID)){
    	    $wallpaper = $this->DataModel->getMainData('wg_wallpaper', $catID);
    	    if($wallpaper != null){
    	        echo json_encode(array("wallpaper"=>$wallpaper));
    	    } else {
        		$response['message']="failure";
        		echo json_encode($response);
    	    }
        } else {
            $response['message']="failure";
    		echo json_encode($response);
        }
    }
	
    public function widget(){
    	$response = array();
    	
	    $response['data'] = array();
	    $category = $this->DataModel->getCategoryData('widget_category');
	    
	    if($category != null){
	        foreach ($category as $categoryRow){
    			$categoryData=array();
    			$categoryData['category_id'] = (int)$categoryRow->category_id;
    			$categoryData['category_name'] = $categoryRow->category_name;
    			$categoryData['category_image'] = $categoryRow->category_image;
    	        
    			$categoryData['widgets'] = array();
    			$video = $this->DataModel->getMainData('widget_quotes', $categoryRow->category_id);
    			
    			foreach($video as $videoRow){
    					$videoData=array();
    					$videoData['widget_id'] = (int)$videoRow->widget_id;
    					$videoData['category_id'] = (int)$videoRow->category_id;
    					$videoData['widget_image'] = $videoRow->widget_image;
    					$videoData['widget_quotes'] = $videoRow->widget_quotes;
    					array_push($categoryData['widgets'],$videoData);
    			}
    			array_push($response['data'],$categoryData);
    		}
    		
    		$response['message']="success";
    		
	    } else {
	        
    		$response['message']="failure";
    		
	    }
	    
	    echo json_encode($response);
    }
}
