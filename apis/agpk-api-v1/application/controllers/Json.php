<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }

    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "keyboardMainData" function is changed in routes.php as "json/keyboard-main-data"
    public function keyboardMainData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $keyboardCategories = $this->JsonModel->getKeyboardCategoryData(5, KEYBOARD_CATEGORY_TABLE);
 
        if($apiValidated){
            if($keyboardCategories != null){
                $keyboardCategoryData['data']=array();
                foreach($keyboardCategories as $keyboardCategoryRow){
                    $keyboardCategory['category_id'] = (int)$keyboardCategoryRow->category_id;
                    $keyboardCategory['category_name'] = $keyboardCategoryRow->category_name;
                    $whereArray = array('keyboard_status' => 'publish', 'category_id' => $keyboardCategoryRow->category_id);
                    $keyboard = $this->JsonModel->getData(5, $whereArray, KEYBOARD_DATA_TABLE);
                    $keyboardCategory['categoryData'] = array();
                    foreach($keyboard as $keyboardRow){
                        $keyboardData = array();
                        $keyboardData['keyboard_id'] = (int)$keyboardRow->keyboard_id;
                        $keyboardData['keyboard_name'] = $keyboardRow->keyboard_name;
                        $keyboardData['keyboard_thumbnail'] = $keyboardRow->keyboard_thumbnail;
                        $keyboardData['keyboard_bundle'] = $keyboardRow->keyboard_bundle;
                        $keyboardData['keyboard_view'] = $keyboardRow->keyboard_view;
                        $keyboardData['keyboard_download'] = $keyboardRow->keyboard_download;
                        $keyboardData['keyboard_premium'] = $keyboardRow->keyboard_premium;
                        $keyboardData['keyboard_status'] = $keyboardRow->keyboard_status;
                        array_push($keyboardCategory['categoryData'],$keyboardData);
                    }
                    if($keyboardCategory['categoryData'] != null){
                        array_push($response['data'],$keyboardCategory);
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
    // Note : "keyboardThemeData" function is changed in routes.php as "json/keyboard-theme-data"
    public function keyboardThemeData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $keyboardCategories = $this->JsonModel->getKeyboardCategoryData(5, KEYBOARD_CATEGORY_TABLE);
 
        if($apiValidated){
            if($keyboardCategories != null){
                $keyboardCategoryData['data']=array();
                foreach($keyboardCategories as $keyboardCategoryRow){
                    $keyboardCategory['category_id'] = (int)$keyboardCategoryRow->category_id;
                    $keyboardCategory['category_name'] = $keyboardCategoryRow->category_name;
                    $whereArray = array('keyboard_status' => 'publish', 'category_id' => $keyboardCategoryRow->category_id);
                    $keyboard = $this->JsonModel->getData(5, $whereArray, KEYBOARD_DATA_TABLE);
                    $keyboardCategory['categoryData'] = array();
                    foreach($keyboard as $keyboardRow){
                        $keyboardData = array();
                        $keyboardData['keyboard_id'] = (int)$keyboardRow->keyboard_id;
                        $keyboardData['keyboard_name'] = $keyboardRow->keyboard_name;
                        $keyboardData['keyboard_thumbnail'] = $keyboardRow->keyboard_thumbnail;
                        $keyboardData['keyboard_bundle'] = $keyboardRow->keyboard_bundle;
                        $keyboardData['keyboard_view'] = $keyboardRow->keyboard_view;
                        $keyboardData['keyboard_download'] = $keyboardRow->keyboard_download;
                        $keyboardData['keyboard_premium'] = $keyboardRow->keyboard_premium;
                        $keyboardData['keyboard_status'] = $keyboardRow->keyboard_status;
                        array_push($keyboardCategory['categoryData'],$keyboardData);
                    }
                    if($keyboardCategory['categoryData'] != null){
                        array_push($response['data'],$keyboardCategory);
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
    // Note : "keyboardCategoryData" function is changed in routes.php as "json/keyboard-category-data"
    public function keyboardCategoryData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $whereArray = array('category_status' => 'publish');
        $keyboardCategories = $this->JsonModel->getData(null, $whereArray, KEYBOARD_CATEGORY_TABLE);
 
        if($apiValidated){
            if($keyboardCategories != null){
                foreach($keyboardCategories as $keyboardCategoryRow){
                    $keyboardCategory=array();
                    $keyboardCategory['category_id'] = (int)$keyboardCategoryRow->category_id;
                    $keyboardCategory['category_name'] = $keyboardCategoryRow->category_name;
                    array_push($response['data'],$keyboardCategory);
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
    // Note : "keyboardViewData" function is changed in routes.php as "json/keyboard-view-data"
    public function keyboardViewData(){
        $response = array();
        $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $categoryID = $this->input->post('category_id');
        $whereArray = array('keyboard_status' => 'publish', 'category_id' => $categoryID);
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewKeyboardData($whereArray, $conditions, KEYBOARD_DATA_TABLE);
            
            //pagination config
            $config['base_url']    = site_url('json/keyboard-view-data/'.$categoryID);
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
            
            $keyboard = $this->JsonModel->viewKeyboardData($whereArray, $conditions, KEYBOARD_DATA_TABLE);
            
            if($keyboard != null){
                foreach($keyboard as $Row){
                    $keyboardData = array();
                    $keyboardData['keyboard_id'] = (int)$Row['keyboard_id'];
                    $keyboardData['keyboard_name'] = $Row['keyboard_name'];
                    $keyboardData['keyboard_thumbnail'] = $Row['keyboard_thumbnail'];
                    $keyboardData['keyboard_bundle'] = $Row['keyboard_bundle'];
                    $keyboardData['keyboard_view'] = $Row['keyboard_view'];
                    $keyboardData['keyboard_download'] = $Row['keyboard_download'];
                    $keyboardData['created_date'] = $Row['created_date'];
                    $keyboardData['keyboard_premium'] = $Row['keyboard_premium'];
                    $keyboardData['keyboard_status'] = $Row['keyboard_status'];
                    
                    array_push($response['data'], $keyboardData);
                }
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            }else{
                $response['data'] = "No data found"; 
            }
        } else {
            $response['message'] = "permission denied";
        }
        echo json_encode($response);  
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "keyboardSearchData" function is changed in routes.php as "json/keyboard-search-data"
    public function keyboardSearchData(){
        $response = array();
        $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $segmentID = $this->uri->segment(3);
        $search = $this->input->post('keyboard_name');
        $whereArray = array('keyboard_status' => 'publish');
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->searchKeyboardData($search, $whereArray, $conditions, KEYBOARD_DATA_TABLE);
            
            //pagination config
            $config['base_url']    = site_url('json/keyboard-search-data/'.$segmentID);
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
            
            $keyboard = $this->JsonModel->searchKeyboardData($search, $whereArray, $conditions, KEYBOARD_DATA_TABLE);
            
            if($keyboard != null){
                foreach($keyboard as $Row){
                    $keyboardData = array();
                    $keyboardData['keyboard_id'] = (int)$Row['keyboard_id'];
                    $keyboardData['keyboard_name'] = $Row['keyboard_name'];
                    $keyboardData['keyboard_thumbnail'] = $Row['keyboard_thumbnail'];
                    $keyboardData['keyboard_bundle'] = $Row['keyboard_bundle'];
                    $keyboardData['keyboard_view'] = $Row['keyboard_view'];
                    $keyboardData['keyboard_download'] = $Row['keyboard_download'];
                    $keyboardData['keyboard_premium'] = $Row['keyboard_premium'];
                    $keyboardData['keyboard_status'] = $Row['keyboard_status'];
                    
                    array_push($response['data'], $keyboardData);
                }
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            }else{
                $response['data'] = "No data found"; 
            }
        } else {
            $response['message'] = "permission denied";
        }
        echo json_encode($response);  
    }
}