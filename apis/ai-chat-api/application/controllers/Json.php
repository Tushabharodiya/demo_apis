<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }

    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "aiChatMainData" function is changed in routes.php as "json/ai-chat-main-data"
    public function aiChatMainData(){
        $response = array();
        $response['category'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        $aiChatSubCategoryData = $this->JsonModel->viewData(5, 'sub_category_status = "publish"', AI_CHAT_SUB_CATEGORY_TABLE);

        if($apiValidated){
            if($aiChatSubCategoryData != null){
                foreach($aiChatSubCategoryData as $aiChatSubCategoryRow){
                    $aiChatSubCategory['sub_category_id'] = (int)$aiChatSubCategoryRow['sub_category_id'];
                    $aiChatSubCategory['sub_category_name'] = $aiChatSubCategoryRow['sub_category_name'];
                    $aiChatSubCategory['sub_category_icon'] = $aiChatSubCategoryRow['sub_category_icon'];
                    $categoryWhereArray = array('sub_category_id' => $aiChatSubCategoryRow['sub_category_id'], 'data_status'=> 'publish');
                    $aiChatDatas = $this->JsonModel->viewData(10, $categoryWhereArray, AI_CHAT_DATA_TABLE);
                    $aiChatSubCategory['data'] = array();
                    foreach($aiChatDatas as $aiChatDataRow){
                        $aiChatData = array();
                        $aiChatData['data_id'] = (int)$aiChatDataRow['data_id'];
                        $aiChatData['data_title'] = $aiChatDataRow['data_title'];
                        array_push($aiChatSubCategory['data'], $aiChatData);
                    }
                    if($aiChatSubCategory['data'] != null){
                        array_push($response['category'],$aiChatSubCategory);
                    }
                }
                if($response['category'] != null){
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
    // Note : "aiChatSubData" function is changed in routes.php as "json/ai-chat-sub-data"
    public function aiChatSubData(){
        $response = array();
        $response['main_category'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));

        $mainCatWhereArray = array('main_category_status' => 'publish');
        $aiChatMainCategory = $this->JsonModel->viewData(null, $mainCatWhereArray, AI_CHAT_MAIN_CATEGORY_TABLE);

        if($apiValidated){
            if($aiChatMainCategory != null){
                foreach($aiChatMainCategory as $aiChatMainCategoryRow){
                    $aiChatMainCategoryData['main_category_id'] = (int)$aiChatMainCategoryRow['main_category_id'];
                    $aiChatMainCategoryData['main_category_name'] = $aiChatMainCategoryRow['main_category_name'];
                    $aiChatMainCategoryData['main_category_icon'] = $aiChatMainCategoryRow['main_category_icon'];
                    
                    $subCatWhereArray = array('main_category_id' => $aiChatMainCategoryRow['main_category_id'], 'sub_category_status' => 'publish');
                    $aiChatSubCategory = $this->JsonModel->viewData(null, $subCatWhereArray, AI_CHAT_SUB_CATEGORY_TABLE);
                    $aiChatMainCategoryData['sub_category'] = array();
                    foreach($aiChatSubCategory as $aiChatSubCategoryRow){
                        $aiChatSubCategoryData = array();
                        $aiChatSubCategoryData['sub_category_id'] = (int)$aiChatSubCategoryRow['sub_category_id'];
                        $aiChatSubCategoryData['sub_category_name'] = $aiChatSubCategoryRow['sub_category_name'];
                        $aiChatSubCategoryData['sub_category_icon'] = $aiChatSubCategoryRow['sub_category_icon'];

                        $dataWhereArray = array('sub_category_id' => $aiChatSubCategoryRow['sub_category_id'], 'data_status' => 'publish');
                        $aiChatDatas = $this->JsonModel->viewData(null, $dataWhereArray, AI_CHAT_DATA_TABLE);
                        $aiChatSubCategoryData['data'] = array();
                        foreach($aiChatDatas as $aiChatDataRow){
                            $aiChatData = array();
                            $aiChatData['data_id'] = (int)$aiChatDataRow['data_id'];
                            $aiChatData['data_title'] = $aiChatDataRow['data_title'];
                            array_push($aiChatSubCategoryData['data'], $aiChatData);
                        }
                        
                        if($aiChatSubCategoryData['data'] != null){
                            array_push($aiChatMainCategoryData['sub_category'], $aiChatSubCategoryData);
                        }
                    }
                    if($aiChatMainCategoryData['sub_category'] != null){
                        array_push($response['main_category'], $aiChatMainCategoryData);
                    }
                }
                if($response['main_category'] != null){
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
    // Note : "aiChatSubCategoryViewData" function is changed in routes.php as "json/ai-chat-sub-category-view-data"
    public function aiChatSubCategoryViewData(){
	    if($this->input->post('sub_category_id')){
    	    $subCategoryID = $this->input->post('sub_category_id');
    	    $aiChatSubCategoryData = $this->JsonModel->getData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE);
    	    
    	    if($aiChatSubCategoryData){
        	    $oldView = $aiChatSubCategoryData['sub_category_view'];
        	    $totalView = $oldView + 1;
    	    }
    	    $editData = array(
    	        'sub_category_view'=>$totalView
    		);
    	
    	    $result = $this->JsonModel->editData('sub_category_id = '.$subCategoryID, AI_CHAT_SUB_CATEGORY_TABLE, $editData);
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