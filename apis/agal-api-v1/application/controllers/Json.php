<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }

    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "applockMainData" function is changed in routes.php as "json/applock-main-data"
    public function applockMainData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $applockCategories = $this->JsonModel->viewCategoryData(APPLOCK_CATEGORY_TABLE);
 
        if($apiValidated){
            if($applockCategories != null){
                foreach($applockCategories as $applockCategoryRow){
                    $applockCategory['category_id'] = (int)$applockCategoryRow->category_id;
                    $applockCategory['category_name'] = $applockCategoryRow->category_name;
                    $whereArray = array('category_id' => $applockCategoryRow->category_id);
                    $applock = $this->JsonModel->viewData(5, $whereArray, APPLOCK_DATA_TABLE);
                    $applockCategory['applockData'] = array();
                    foreach($applock as $applockRow){
                        $applockData = array();
                        $applockData['applock_id'] = (int)$applockRow->applock_id;
                        $applockData['applock_name'] = str_replace(" ","",$applockRow->applock_name).'-'.$applockRow->applock_id;
                        $applockData['applock_thumbnail'] = $applockRow->applock_thumbnail;
                        $applockData['applock_bundle'] = $applockRow->applock_bundle;
                        $applockData['applock_type'] = $applockRow->applock_type;
                        $applockData['is_premium'] = $applockRow->is_premium;
                        array_push($applockCategory['applockData'], $applockData);
                    }
                    if($applockCategory['applockData'] != null){
                        array_push($response['data'],$applockCategory);
                    }
                }
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "permission denied";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "applockViewData" function is changed in routes.php as "json/applock-view-data"
    public function applockViewData(){
        $response = array();
        $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $categoryID = $this->input->post('category_id');
        $applockType = $this->input->post('applock_type');
        $whereArray = array('category_id' => $categoryID, 'applock_type' => $applockType);
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewApplockData(APPLOCK_DATA_TABLE, $whereArray, $conditions);
            
            //pagination config
            $config['base_url']    = site_url('json/applock-view-data/'.$categoryID);
            $config['uri_segment'] = 3;
            $config['total_rows']  = $totalRec;
            $config['per_page']    = 10;
            
            //styling
            $config['num_tag_open'] = '<li class="page-item page-link">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active page-item"><a href="javascript:void(0);" class="page-link" >';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_link'] = '&raquo';
            $config['prev_link'] = '&laquo';
            $config['next_tag_open'] = '<li class="pg-next page-item page-link">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="pg-prev page-item page-link">';
            $config['prev_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item page-link">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item page-link">';
            $config['last_tag_close'] = '</li>';
            
            //initialize pagination library
            $this->pagination->initialize($config);
            
            //define offset
            $page = $this->uri->segment(3);
            $offset = !$page?0:$page;
            
            //get rows
            $conditions['returnType'] = '';
            $conditions['start'] = $offset;
            $conditions['limit'] = 10;
            $applock = $this->JsonModel->viewApplockData(APPLOCK_DATA_TABLE, $whereArray, $conditions);
            
            if($applock != null){
                foreach($applock as $Row){
                    $applockData = array();
                    $applockData['applock_id'] = (int)$Row['applock_id'];
                    $applockData['applock_name'] = str_replace(" ","",$Row['applock_name']).'-'.$Row['applock_id'];
                    $applockData['applock_thumbnail'] = $Row['applock_thumbnail'];
                    $applockData['applock_bundle'] = $Row['applock_bundle'];
                    $applockData['applock_type'] = $Row['applock_type'];
                    $applockData['is_premium'] = $Row['is_premium'];
                    array_push($response['data'], $applockData);
                }
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['data'] = "No data found"; 
            }
        } else {
            $response['message'] = "permission denied";
        }
        echo json_encode($response);  
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "applockViewedData" function is changed in routes.php as "json/applock-viewed-data"
    public function applockViewedData(){
	    if($this->input->post('applock_id')){
    	    $applockID = $this->input->post('applock_id');
    	    $applockData = $this->JsonModel->rowData('applock_id = '.$applockID, APPLOCK_DATA_TABLE);
    	    
    	    if($applockData){
        	    $oldView = $applockData->applock_view;
        	    $totalView = $oldView + 1;
    	    }
    	    $editData = array(
    	        'applock_view'=>$totalView
    		);
    	
    	    $result = $this->JsonModel->editData('applock_id = '.$applockID, APPLOCK_DATA_TABLE, $editData);
    	    if($result){
    	       $status = "success";
               echo json_encode(array("response"=>$status));
    	    }
	    } else {
	        $status = "error";
            echo json_encode(array("response"=>$status));
	    }
	}
	
	// Note : Please change this function name in "routes.php" before update it's name
    // Note : "applockDownloadData" function is changed in routes.php as "json/applock-download-data"
    public function applockDownloadData(){
	    if($this->input->post('applock_id')){
    	    $applockID = $this->input->post('applock_id');
    	    $applockData = $this->JsonModel->rowData('applock_id = '.$applockID, APPLOCK_DATA_TABLE);
    	    
    	    if($applockData){
        	    $oldDownload = $applockData->applock_download;
        	    $totalDownload = $oldDownload + 1;
    	    }
    	    $editData = array(
    	        'applock_download'=>$totalDownload
    		);
    	
    	    $result = $this->JsonModel->editData('applock_id = '.$applockID, APPLOCK_DATA_TABLE, $editData);
    	    if($result){
    	       $status = "success";
               echo json_encode(array("response"=>$status));
    	    }
	    } else {
	        $status = "error";
            echo json_encode(array("response"=>$status));
	    }
	}
	
	// Note : Please change this function name in "routes.php" before update it's name
    // Note : "applockAppliedData" function is changed in routes.php as "json/applock-applied-data"
    public function applockAppliedData(){
	    if($this->input->post('applock_id')){
    	    $applockID = $this->input->post('applock_id');
    	    $applockData = $this->JsonModel->rowData('applock_id = '.$applockID, APPLOCK_DATA_TABLE);
    	    
    	    if($applockData){
    	        if(empty($applockData->applock_applied)){
    	            $oldApplied = 0;
    	        } else {
    	            $oldApplied = $applockData->applock_applied;
    	        }
        	    $totalApplied = $oldApplied + 1;
    	    }
    	    $editData = array(
    	        'applock_applied'=>$totalApplied
    		);
    	
    	    $result = $this->JsonModel->editData('applock_id = '.$applockID, APPLOCK_DATA_TABLE, $editData);
    	    if($result){
    	       $status = "success";
               echo json_encode(array("response"=>$status));
    	    }
	    } else {
	        $status = "error";
            echo json_encode(array("response"=>$status));
	    }
	}
    
    //========================= Unpublish Data Functions ======================
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "developmentMainData" function is changed in routes.php as "json/development-main-data"
    public function developmentMainData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $applockCategories = $this->JsonModel->getCategoryData(APPLOCK_CATEGORY_TABLE);
 
        if($apiValidated){
            if($applockCategories != null){
                foreach($applockCategories as $applockCategoryRow){
                    $applockCategory['category_id'] = (int)$applockCategoryRow->category_id;
                    $applockCategory['category_name'] = $applockCategoryRow->category_name;
                    $whereArray = array('category_id' => $applockCategoryRow->category_id);
                    $applock = $this->JsonModel->getData(5, $whereArray, APPLOCK_DATA_TABLE);
                    $applockCategory['applockData'] = array();
                    foreach($applock as $applockRow){
                        $applockData = array();
                        $applockData['applock_id'] = (int)$applockRow->applock_id;
                        $applockData['applock_name'] = str_replace(" ","",$applockRow->applock_name).'-'.$applockRow->applock_id;
                        $applockData['applock_thumbnail'] = $applockRow->applock_thumbnail;
                        $applockData['applock_bundle'] = $applockRow->applock_bundle;
                        $applockData['applock_type'] = $applockRow->applock_type;
                        $applockData['is_premium'] = $applockRow->is_premium;
                        array_push($applockCategory['applockData'], $applockData);
                    }
                    if($applockCategory['applockData'] != null){
                        array_push($response['data'],$applockCategory);
                    }
                }
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "permission denied";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "developmentViewData" function is changed in routes.php as "json/development-view-data"
    public function developmentViewData(){
        $response = array();
        $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $categoryID = $this->input->post('category_id');
        $whereArray = array('category_id' => $categoryID);
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->getApplockData(APPLOCK_DATA_TABLE, $whereArray, $conditions);
            
            //pagination config
            $config['base_url']    = site_url('json/applock-view-data/'.$categoryID);
            $config['uri_segment'] = 3;
            $config['total_rows']  = $totalRec;
            $config['per_page']    = 10;
            
            //styling
            $config['num_tag_open'] = '<li class="page-item page-link">';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="active page-item"><a href="javascript:void(0);" class="page-link" >';
            $config['cur_tag_close'] = '</a></li>';
            $config['next_link'] = '&raquo';
            $config['prev_link'] = '&laquo';
            $config['next_tag_open'] = '<li class="pg-next page-item page-link">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="pg-prev page-item page-link">';
            $config['prev_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li class="page-item page-link">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="page-item page-link">';
            $config['last_tag_close'] = '</li>';
            
            //initialize pagination library
            $this->pagination->initialize($config);
            
            //define offset
            $page = $this->uri->segment(3);
            $offset = !$page?0:$page;
            
            //get rows
            $conditions['returnType'] = '';
            $conditions['start'] = $offset;
            $conditions['limit'] = 10;
            $applock = $this->JsonModel->getApplockData(APPLOCK_DATA_TABLE, $whereArray, $conditions);
            
            if($applock != null){
                foreach($applock as $Row){
                    $applockData = array();
                    $applockData['applock_id'] = (int)$Row['applock_id'];
                    $applockData['applock_name'] = str_replace(" ","",$Row['applock_name']).'-'.$Row['applock_id'];
                    $applockData['applock_thumbnail'] = $Row['applock_thumbnail'];
                    $applockData['applock_bundle'] = $Row['applock_bundle'];
                    $applockData['applock_type'] = $Row['applock_type'];
                    $applockData['is_premium'] = $Row['is_premium'];
                    array_push($response['data'], $chargingData);
                }
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['data'] = "No data found"; 
            }
        } else {
            $response['message'] = "permission denied";
        }
        echo json_encode($response);  
    }
}