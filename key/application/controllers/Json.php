<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct(){
		parent::__construct();
		$this->load->model('JsonModel');
	}

	public function index()	{
		$this->load->view('welcome');
	}
	
	public function data(){
	    $response['data'] = array();
        $getData = $this->JsonModel->viewData('keyboard_data');

        if(!empty($getData)){
            $keyboardData=array(
                'keyboard_id' => $getData->keyboard_id,
                'category_id' => $getData->category_id,
                'keyboard_code' => $getData->keyboard_code,
        		'keyboard_name' => $getData->keyboard_name,
        		'keyboard_thumbnail' => $getData->keyboard_thumbnail,
        		'keyboard_bundle' => $getData->keyboard_bundle,
        		'keyboard_view' => $getData->keyboard_view,
        		'keyboard_download' => $getData->keyboard_download,
        		'keyboard_premium' => $getData->keyboard_premium,
        		'keyboard_status' => $getData->keyboard_status
    		);
        } else {
            $keyboardData=array(
                'keyboard_id' => "Not found",
    		);
        } 
        
        $response['data'] = $keyboardData;
        echo json_encode($response['data']);
	}
}
