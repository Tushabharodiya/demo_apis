<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct(){
		parent::__construct();
		$this->load->model('JsonModel');
	}

	public function index(){
		$this->load->view('welcome');
	}
	
	public function users(){
	    $lang = "en";
	    $response['message']="Success";
	    $response['responseCode'] = 1;
	    $response['responseText'] = array();
	    
	   
	    $userData = $this->JsonModel->viewUserData('data_user');
	    
	    if($userData != null){
    		foreach($userData as $userRow){
			$userData=array();
			$userData['user_id'] = (int)$userRow->user_id;
			$userData['business_cat_id'] = (int)$userRow->business_cat_id;
			$userData['user_name'] = $userRow->user_name;
			$userData['user_status'] = $userRow->user_status;
			$userData['user_profile'] = $userRow->user_profile;
			
			$cat_id = $userData['business_cat_id'];	
			$userBusinessData = $this->JsonModel->viewBusinessDatabyID($cat_id,'data_business');
			
			$userData['business'] = $userBusinessData;
		  //  $response['message']="Success";
		  //  $response['responseCode']= 1 ;
	        array_push($response['responseText'],$userData);
		    }
		    
	    } else {
    		$response['message']="Failure";
    		$response['code']= 0;
	    }
	    
	    echo json_encode($response);
    }
	
	
}
