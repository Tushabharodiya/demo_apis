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
	
	public function data(){
	    
	    $appURL = $this->input->post("app_url");
	    
	    if($appURL == "12345"){
    	    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){   
                $url = "https://";   
            } else {  
                $url = "http://";   
            }    
            
            // Append the host(domain name, ip) to the URL.   
            $url.= $_SERVER['HTTP_HOST'];   
            // Append the requested resource location to the URL   
            $url.= $_SERVER['REQUEST_URI'];    
              
            echo json_encode($url);
	    } else {
	        echo json_encode("data not found");
	    }
	    
	    /*//echo "123";
	    die;
	    $quotes = $this->DataModel->getCategoryData('wg_popular_quotes');
	    if($quotes != null){
	        echo json_encode(array("pquotes"=>$quotes));
	    } else {
    		$response['message']="failure";
    		echo json_encode($response);
	    }*/
    }
}
