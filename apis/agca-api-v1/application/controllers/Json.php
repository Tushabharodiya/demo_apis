<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }

    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "chargingMainData" function is changed in routes.php as "json/charging-main-data"
    public function chargingMainData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $chargingCategories = $this->JsonModel->viewCategoryData(CHARGING_CATEGORY_TABLE);
 
        if($apiValidated){
            if($chargingCategories != null){
                foreach($chargingCategories as $chargingCategoryRow){
                    $chargingCategory['category_id'] = (int)$chargingCategoryRow->category_id;
                    $chargingCategory['category_name'] = $chargingCategoryRow->category_name;
                    $whereArray = array('category_id' => $chargingCategoryRow->category_id);
                    $charging = $this->JsonModel->viewData(5, $whereArray, CHARGING_DATA_TABLE);
                    $chargingCategory['chargingData'] = array();
                    foreach($charging as $chargingRow){
                        $chargingData = array();
                        $chargingData['charging_id'] = (int)$chargingRow->charging_id;
                        $chargingData['charging_name'] = str_replace(" ","",$chargingRow->charging_name).'-'.$chargingRow->charging_id;
                        $chargingData['charging_thumbnail'] = $chargingRow->charging_thumbnail;
                        $chargingData['charging_bundle'] = $chargingRow->charging_bundle;
                        $chargingData['charging_type'] = $chargingRow->charging_type;
                        $chargingData['thumbnail_type'] = $chargingRow->thumbnail_type;
                        $chargingData['is_premium'] = $chargingRow->is_premium;
                        $chargingData['is_music'] = $chargingRow->is_music;
                        array_push($chargingCategory['chargingData'], $chargingData);
                    }
                    if($chargingCategory['chargingData'] != null){
                        array_push($response['data'],$chargingCategory);
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
    // Note : "chargingSearchData" function is changed in routes.php as "json/charging-search-data"
    public function chargingSearchData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $categoryName = $this->input->post('search_query');
        $chargingCategories = $this->JsonModel->viewSubCategoryData($categoryName, CHARGING_CATEGORY_TABLE);
        if($apiValidated){
            if($chargingCategories != null){
                foreach($chargingCategories as $chargingCategoryRow){
                    $chargingCategory['category_id'] = (int)$chargingCategoryRow->category_id;
                    $chargingCategory['category_name'] = $chargingCategoryRow->category_name;
                    $whereArray = array('category_id' => $chargingCategoryRow->category_id);
                    $charging = $this->JsonModel->viewData(5, $whereArray, CHARGING_DATA_TABLE);
                    $chargingCategory['chargingData'] = array();
                    foreach($charging as $chargingRow){
                        $chargingData = array();
                        $chargingData['charging_id'] = (int)$chargingRow->charging_id;
                        $chargingData['charging_name'] = str_replace(" ","",$chargingRow->charging_name).'-'.$chargingRow->charging_id;
                        $chargingData['charging_thumbnail'] = $chargingRow->charging_thumbnail;
                        $chargingData['charging_bundle'] = $chargingRow->charging_bundle;
                        $chargingData['charging_type'] = $chargingRow->charging_type;
                        $chargingData['thumbnail_type'] = $chargingRow->thumbnail_type;
                        $chargingData['is_premium'] = $chargingRow->is_premium;
                        $chargingData['is_music'] = $chargingRow->is_music;
                        array_push($chargingCategory['chargingData'], $chargingData);
                    }
                    if($chargingCategory['chargingData'] != null){
                        array_push($response['data'],$chargingCategory);
                    }
                }
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $data = array(
                    'search_query'=>$this->input->post('search_query'),
                    'search_date' => timeZone(),
                    'search_status' => 'publish'
                );
                $this->JsonModel->insertData(CHARGING_SEARCH_TABLE, $data);
                $response['data'] = "search not found";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "chargingViewData" function is changed in routes.php as "json/charging-view-data"
    public function chargingViewData(){
        $response = array();
        $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $categoryID = $this->input->post('category_id');
        $whereArray = array('category_id' => $categoryID);
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewChargingData(CHARGING_DATA_TABLE, $whereArray, $conditions);
            
            //pagination config
            $config['base_url']    = site_url('json/charging-view-data/'.$categoryID);
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
            $charging = $this->JsonModel->viewChargingData(CHARGING_DATA_TABLE, $whereArray, $conditions);
            
            if($charging != null){
                foreach($charging as $Row){
                    $chargingData = array();
                    $chargingData['charging_id'] = (int)$Row['charging_id'];
                    $chargingData['charging_name'] = str_replace(" ","",$Row['charging_name']).'-'.$Row['charging_id'];
                    $chargingData['charging_thumbnail'] = $Row['charging_thumbnail'];
                    $chargingData['charging_bundle'] = $Row['charging_bundle'];
                    $chargingData['charging_type'] = $Row['charging_type'];
                    $chargingData['thumbnail_type'] = $Row['thumbnail_type'];
                    $chargingData['is_premium'] = $Row['is_premium'];
                    $chargingData['is_music'] = $Row['is_music'];
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
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "chargingViewedData" function is changed in routes.php as "json/charging-viewed-data"
    public function chargingViewedData(){
	    if($this->input->post('charging_id')){
    	    $chargingID = $this->input->post('charging_id');
    	    $chargingData = $this->JsonModel->rowData('charging_id = '.$chargingID, CHARGING_DATA_TABLE);
    	    
    	    if($chargingData){
        	    $oldView = $chargingData->charging_view;
        	    $totalView = $oldView + 1;
    	    }
    	    $editData = array(
    	        'charging_view'=>$totalView
    		);
    	
    	    $result = $this->JsonModel->editData('charging_id = '.$chargingID, CHARGING_DATA_TABLE, $editData);
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
    // Note : "chargingDownloadData" function is changed in routes.php as "json/charging-download-data"
    public function chargingDownloadData(){
	    if($this->input->post('charging_id')){
    	    $chargingID = $this->input->post('charging_id');
    	    $chargingData = $this->JsonModel->rowData('charging_id = '.$chargingID, CHARGING_DATA_TABLE);
    	    
    	    if($chargingData){
        	    $oldDownload = $chargingData->charging_download;
        	    $totalDownload = $oldDownload + 1;
    	    }
    	    $editData = array(
    	        'charging_download'=>$totalDownload
    		);
    	
    	    $result = $this->JsonModel->editData('charging_id = '.$chargingID, CHARGING_DATA_TABLE, $editData);
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
    // Note : "chargingAppliedData" function is changed in routes.php as "json/charging-applied-data"
    public function chargingAppliedData(){
	    if($this->input->post('charging_id')){
    	    $chargingID = $this->input->post('charging_id');
    	    $chargingData = $this->JsonModel->rowData('charging_id = '.$chargingID, CHARGING_DATA_TABLE);
    	    
    	    if($chargingData){
    	        if(empty($chargingData->charging_applied)){
    	            $oldApplied = 0;
    	        } else {
    	            $oldApplied = $chargingData->charging_applied;
    	        }
        	    $totalApplied = $oldApplied + 1;
    	    }
    	    $editData = array(
    	        'charging_applied'=>$totalApplied
    		);
    	
    	    $result = $this->JsonModel->editData('charging_id = '.$chargingID, CHARGING_DATA_TABLE, $editData);
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
        $chargingCategories = $this->JsonModel->getCategoryData(CHARGING_CATEGORY_TABLE);
 
        if($apiValidated){
            if($chargingCategories != null){
                foreach($chargingCategories as $chargingCategoryRow){
                    $chargingCategory['category_id'] = (int)$chargingCategoryRow->category_id;
                    $chargingCategory['category_name'] = $chargingCategoryRow->category_name;
                    $whereArray = array('category_id' => $chargingCategoryRow->category_id);
                    $charging = $this->JsonModel->getData(5, $whereArray, CHARGING_DATA_TABLE);
                    $chargingCategory['chargingData'] = array();
                    foreach($charging as $chargingRow){
                        $chargingData = array();
                        $chargingData['charging_id'] = (int)$chargingRow->charging_id;
                        $chargingData['charging_name'] = str_replace(" ","",$chargingRow->charging_name).'-'.$chargingRow->charging_id;
                        $chargingData['charging_thumbnail'] = $chargingRow->charging_thumbnail;
                        $chargingData['charging_bundle'] = $chargingRow->charging_bundle;
                        $chargingData['charging_type'] = $chargingRow->charging_type;
                        $chargingData['thumbnail_type'] = $chargingRow->thumbnail_type;
                        $chargingData['is_premium'] = $chargingRow->is_premium;
                        $chargingData['is_music'] = $chargingRow->is_music;
                        array_push($chargingCategory['chargingData'], $chargingData);
                    }
                    if($chargingCategory['chargingData'] != null){
                        array_push($response['data'],$chargingCategory);
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
            $totalRec = $this->JsonModel->getChargingData(CHARGING_DATA_TABLE, $whereArray, $conditions);
            
            //pagination config
            $config['base_url']    = site_url('json/charging-view-data/'.$categoryID);
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
            $charging = $this->JsonModel->getChargingData(CHARGING_DATA_TABLE, $whereArray, $conditions);
            
            if($charging != null){
                foreach($charging as $Row){
                    $chargingData = array();
                    $chargingData['charging_id'] = (int)$Row['charging_id'];
                    $chargingData['charging_name'] = str_replace(" ","",$Row['charging_name']).'-'.$Row['charging_id'];
                    $chargingData['charging_thumbnail'] = $Row['charging_thumbnail'];
                    $chargingData['charging_bundle'] = $Row['charging_bundle'];
                    $chargingData['charging_type'] = $Row['charging_type'];
                    $chargingData['thumbnail_type'] = $Row['thumbnail_type'];
                    $chargingData['is_premium'] = $Row['is_premium'];
                    $chargingData['is_music'] = $Row['is_music'];
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