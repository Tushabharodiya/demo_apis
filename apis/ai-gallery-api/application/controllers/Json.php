<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }

    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "aiGalleryMainCategoryData" function is changed in routes.php as "json/ai-gallery-main-category-data"
    public function aiGalleryMainCategoryData(){
        $response = array();
        $response['category'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewAiGalleryCategory($conditions, AI_GALLERY_CATEGORY_TABLE);
            
            //pagination config
            $config['uri_segment'] = 3;
            $config['total_rows']  = $totalRec;
            $config['per_page']    = 10;
            
            //initialize pagination library
            $this->pagination->initialize($config);
            
            //define offset
            $page = $this->uri->segment(3);
            $offset = !$page?0:$page;
            
            //get rows
            $conditions['returnType'] = '';
            $conditions['start'] = $offset;
            $conditions['limit'] = 10;
                
            $aiGalleryCategories = $this->JsonModel->viewAiGalleryCategory($conditions, AI_GALLERY_CATEGORY_TABLE);

            if($aiGalleryCategories != null){
                foreach($aiGalleryCategories as $aiGalleryCategoryRow){
                    $aiGalleryCategory['category_id'] = (int)$aiGalleryCategoryRow['category_id'];
                    $aiGalleryCategory['category_name'] = $aiGalleryCategoryRow['category_name'];
                    $aiGalleryCategory['category_icon'] = $aiGalleryCategoryRow['category_icon'];
                    $aiGalleryCategory['category_status'] = $aiGalleryCategoryRow['category_status'];
                    $aiGalleryDataWhereArray = array('category_id' => $aiGalleryCategoryRow['category_id'], 'image_status'=> 'publish');
                    $aiGalleryDatas = $this->JsonModel->viewData(5, 'image_id '.'DESC', $aiGalleryDataWhereArray, AI_GALLERY_IMAGE_TABLE);
                    $aiGalleryCategory['data'] = array();
                    foreach($aiGalleryDatas as $aiGalleryDataRow){
                        $aiGalleryData = array();
                        $aiGalleryData['image_id'] = (int)$aiGalleryDataRow['image_id'];
                        $aiGalleryData['image_prompt'] = $aiGalleryDataRow['image_prompt'];
                        $aiGalleryData['image_url'] = $aiGalleryDataRow['image_url'];
                        $aiGalleryData['image_thumbnail'] = $aiGalleryDataRow['image_thumbnail'];
                        $aiGalleryData['image_style'] = $aiGalleryDataRow['image_style'];
                        $aiGalleryData['image_size'] = $aiGalleryDataRow['image_size'];
                        $aiGalleryData['image_scale'] = $aiGalleryDataRow['image_scale'];
                        $aiGalleryData['image_steps'] = $aiGalleryDataRow['image_steps'];
                        $aiGalleryData['image_date'] = $aiGalleryDataRow['image_date'];
                        $aiGalleryData['image_type'] = $aiGalleryDataRow['image_type'];
                        $aiGalleryData['image_show'] = $aiGalleryDataRow['image_show'];
                        $aiGalleryData['image_status'] = $aiGalleryDataRow['image_status'];
                        array_push($aiGalleryCategory['data'], $aiGalleryData);
                    }
                    if($aiGalleryCategory['data'] != null){
                        array_push($response['category'],$aiGalleryCategory);
                    }
                }
                if($response['category'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['category'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "aiGalleryViewCategoryData" function is changed in routes.php as "ai-gallery-view-category-data"
    public function aiGalleryViewCategoryData(){
        $response = array();
        $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        $categoryID = $this->input->post('category_id');

        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewAiGalleryData($conditions, $categoryID, AI_GALLERY_IMAGE_TABLE);
            
            //pagination config
            $config['uri_segment'] = 3;
            $config['total_rows']  = $totalRec;
            $config['per_page']    = 10;
            
            //initialize pagination library
            $this->pagination->initialize($config);
            
            //define offset
            $page = $this->uri->segment(3);
            $offset = !$page?0:$page;
            
            //get rows
            $conditions['returnType'] = '';
            $conditions['start'] = $offset;
            $conditions['limit'] = 10;
            
            $aiGalleryDatas = $this->JsonModel->viewAiGalleryData($conditions, $categoryID, AI_GALLERY_IMAGE_TABLE);

            if($aiGalleryDatas != null){
                foreach($aiGalleryDatas as $aiGalleryDataRow){
                    $aiGalleryData = array();
                    $aiGalleryData['image_id'] = (int)$aiGalleryDataRow['image_id'];
                    $aiGalleryData['image_prompt'] = $aiGalleryDataRow['image_prompt'];
                    $aiGalleryData['image_url'] = $aiGalleryDataRow['image_url'];
                    $aiGalleryData['image_thumbnail'] = $aiGalleryDataRow['image_thumbnail'];
                    $aiGalleryData['image_style'] = $aiGalleryDataRow['image_style'];
                    $aiGalleryData['image_size'] = $aiGalleryDataRow['image_size'];
                    $aiGalleryData['image_scale'] = $aiGalleryDataRow['image_scale'];
                    $aiGalleryData['image_steps'] = $aiGalleryDataRow['image_steps'];
                    $aiGalleryData['image_date'] = $aiGalleryDataRow['image_date'];
                    $aiGalleryData['image_type'] = $aiGalleryDataRow['image_type'];
                    $aiGalleryData['image_show'] = $aiGalleryDataRow['image_show'];
                    $aiGalleryData['image_status'] = $aiGalleryDataRow['image_status'];
                    array_push($response['data'], $aiGalleryData);
                }
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['data'] = "No data available in table"; 
            }
        } else {
            $response['message'] = "permission denied";
        }
        echo json_encode($response);  
    }
}