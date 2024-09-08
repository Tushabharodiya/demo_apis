<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxMainData" function is changed in routes.php as "json/rblx-main-data"
    public function rblxMainData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        if($apiValidated){
            $skinCategory['category_id'] = "100" ;
            $skinCategory['category_name'] = "Most Loved" ;
            $skinLiked = $this->JsonModel->viewData('skin_likes '.'DESC', 10, 'skin_status = "Publish"', RBLX_SKIN_TABLE);
            $skinCategory['skinData'] = array();
            foreach($skinLiked as $skinLikedRow){
                $skinLikedData = array();
                $skinLikedData['skin_id'] = (int)$skinLikedRow['skin_id'];
                $skinLikedData['category_id'] = $skinLikedRow['category_id'];
                $skinLikedData['skin_name'] = $skinLikedRow['skin_name'];
                $skinLikedData['skin_thumbnail'] = $skinLikedRow['skin_thumbnail'];
                $skinLikedData['skin_bundle'] = $skinLikedRow['skin_bundle'];
                $skinLikedData['skin_downloads'] = numberFormate($skinLikedRow['skin_downloads']);
                $skinLikedData['skin_likes'] = numberFormate($skinLikedRow['skin_likes']);
                $skinLikedData['skin_views'] = numberFormate($skinLikedRow['skin_views']);
                $skinLikedData['skin_type'] = $skinLikedRow['skin_type'];

                array_push($skinCategory['skinData'], $skinLikedData);
            }
            if($skinCategory['skinData'] != null){
                array_push($response['data'],$skinCategory);
            }
            
            $skinCategory['category_id'] = "101" ;
            $skinCategory['category_name'] = "Trending" ;
            $skinTrending = $this->JsonModel->viewData('skin_downloads '.'DESC', 10, 'skin_status = "Publish"', RBLX_SKIN_TABLE);
            $skinCategory['skinData'] = array();
            foreach($skinTrending as $skinTrendingRow){
                $skinTrendingData = array();
                $skinTrendingData['skin_id'] = (int)$skinTrendingRow['skin_id'];
                $skinTrendingData['category_id'] = $skinTrendingRow['category_id'];
                $skinTrendingData['skin_name'] = $skinTrendingRow['skin_name'];
                $skinTrendingData['skin_thumbnail'] = $skinTrendingRow['skin_thumbnail'];
                $skinTrendingData['skin_bundle'] = $skinTrendingRow['skin_bundle'];
                $skinTrendingData['skin_downloads'] = numberFormate($skinTrendingRow['skin_downloads']);
                $skinTrendingData['skin_likes'] = numberFormate($skinTrendingRow['skin_likes']);
                $skinTrendingData['skin_views'] = numberFormate($skinTrendingRow['skin_views']);
                $skinTrendingData['skin_type'] = $skinTrendingRow['skin_type'];

                array_push($skinCategory['skinData'], $skinTrendingData);
            }
            if($skinCategory['skinData'] != null){
                array_push($response['data'],$skinCategory);
            }
            
            $skinCategory['category_id'] = "3" ;
            $skinCategory['category_name'] = "Shirts" ;
            $skinShirtArray = array_merge(array('4,3'), array('5,3'));
            $skinShirt = $this->JsonModel->viewSkinData('skin_id '.'ASC', 10, $skinShirtArray, RBLX_SKIN_TABLE);
            $skinCategory['skinData'] = array();
            foreach($skinShirt as $skinShirtRow){
                $skinShirtData = array();
                $skinShirtData['skin_id'] = (int)$skinShirtRow['skin_id'];
                $skinShirtData['category_id'] = $skinShirtRow['category_id'];
                $skinShirtData['skin_name'] = $skinShirtRow['skin_name'];
                $skinShirtData['skin_thumbnail'] = $skinShirtRow['skin_thumbnail'];
                $skinShirtData['skin_bundle'] = $skinShirtRow['skin_bundle'];
                $skinShirtData['skin_downloads'] = numberFormate($skinShirtRow['skin_downloads']);
                $skinShirtData['skin_likes'] = numberFormate($skinShirtRow['skin_likes']);
                $skinShirtData['skin_views'] = numberFormate($skinShirtRow['skin_views']);
                $skinShirtData['skin_type'] = $skinShirtRow['skin_type'];

                array_push($skinCategory['skinData'], $skinShirtData);
            }
            if($skinCategory['skinData'] != null){
                array_push($response['data'],$skinCategory);
            }
            
            $skinCategory['category_id'] = "2" ;
            $skinCategory['category_name'] = "Pants" ;
            $skinPantArray = array_merge(array('4,2'), array('5,2'));
            $skinPant = $this->JsonModel->viewSkinData('skin_id '.'ASC', 10, $skinPantArray, RBLX_SKIN_TABLE);
            $skinCategory['skinData'] = array();
            foreach($skinPant as $skinPantRow){
                $skinPantData = array();
                $skinPantData['skin_id'] = (int)$skinPantRow['skin_id'];
                $skinPantData['category_id'] = $skinPantRow['category_id'];
                $skinPantData['skin_name'] = $skinPantRow['skin_name'];
                $skinPantData['skin_thumbnail'] = $skinPantRow['skin_thumbnail'];
                $skinPantData['skin_bundle'] = $skinPantRow['skin_bundle'];
                $skinPantData['skin_downloads'] = numberFormate($skinPantRow['skin_downloads']);
                $skinPantData['skin_likes'] = numberFormate($skinPantRow['skin_likes']);
                $skinPantData['skin_views'] = numberFormate($skinPantRow['skin_views']);
                $skinPantData['skin_type'] = $skinPantRow['skin_type'];

                array_push($skinCategory['skinData'], $skinPantData);
            }
            if($skinCategory['skinData'] != null){
                array_push($response['data'],$skinCategory);
            }
            
            $skinCategory['category_id'] = "1" ;
            $skinCategory['category_name'] = "Shoes" ;
            $skinShoes = $this->JsonModel->viewData('skin_id '.'ASC', 10, 'skin_status = "Publish" And category_id = "1"', RBLX_SKIN_TABLE);
            $skinCategory['skinData'] = array();
            foreach($skinShoes as $skinShoesRow){
               $skinShoesData = array();
                $skinShoesData['skin_id'] = (int)$skinShoesRow['skin_id'];
                $skinShoesData['category_id'] = $skinShoesRow['category_id'];
                $skinShoesData['skin_name'] = $skinShoesRow['skin_name'];
                $skinShoesData['skin_thumbnail'] = $skinShoesRow['skin_thumbnail'];
                $skinShoesData['skin_bundle'] = $skinShoesRow['skin_bundle'];
                $skinShoesData['skin_downloads'] = numberFormate($skinShoesRow['skin_downloads']);
                $skinShoesData['skin_likes'] = numberFormate($skinShoesRow['skin_likes']);
                $skinShoesData['skin_views'] = numberFormate($skinShoesRow['skin_views']);
                $skinShoesData['skin_type'] = $skinShoesRow['skin_type'];

                array_push($skinCategory['skinData'], $skinShoesData);
            }
            if($skinCategory['skinData'] != null){
                array_push($response['data'],$skinCategory);
            }
            
            if($response['data'] != null){
                $response['message'] = "success";
            } else {
               $response['message'] = "permission denied"; 
            }
            
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxMostLovedData" function is changed in routes.php as "json/rblx-most-loved-data"
    public function rblxMostLovedData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->rblxSkinData($conditions, 'skin_likes '.'DESC', null, RBLX_SKIN_TABLE);
            
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
                
            $skinMostLoved = $this->JsonModel->rblxSkinData($conditions, 'skin_likes '.'DESC', null, RBLX_SKIN_TABLE);
            if($skinMostLoved != null){
                foreach($skinMostLoved as $skinMostLovedRow){
                    $skinMostLovedData = array();
                    $skinMostLovedData['skin_id'] = (int)$skinMostLovedRow['skin_id'];
                    $skinMostLovedData['category_id'] = $skinMostLovedRow['category_id'];
                    $skinMostLovedData['skin_name'] = $skinMostLovedRow['skin_name'];
                    $skinMostLovedData['skin_thumbnail'] = $skinMostLovedRow['skin_thumbnail'];
                    $skinMostLovedData['skin_bundle'] = $skinMostLovedRow['skin_bundle'];
                    $skinMostLovedData['skin_downloads'] = numberFormate($skinMostLovedRow['skin_downloads']);
                    $skinMostLovedData['skin_likes'] = numberFormate($skinMostLovedRow['skin_likes']);
                    $skinMostLovedData['skin_views'] = numberFormate($skinMostLovedRow['skin_views']);
                    $skinMostLovedData['skin_type'] = $skinMostLovedRow['skin_type'];

                    array_push($response['data'], $skinMostLovedData);
                } 
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxTrendingData" function is changed in routes.php as "json/rblx-trending-data"
    public function rblxTrendingData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->rblxSkinData($conditions, 'skin_downloads '.'DESC', null, RBLX_SKIN_TABLE);
            
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
                
            $skinTrending = $this->JsonModel->rblxSkinData($conditions, 'skin_downloads '.'DESC', null, RBLX_SKIN_TABLE);
            if($skinTrending != null){
                foreach($skinTrending as $skinTrendingRow){
                    $skinTrendingData = array();
                    $skinTrendingData['skin_id'] = (int)$skinTrendingRow['skin_id'];
                    $skinTrendingData['category_id'] = $skinTrendingRow['category_id'];
                    $skinTrendingData['skin_name'] = $skinTrendingRow['skin_name'];
                    $skinTrendingData['skin_thumbnail'] = $skinTrendingRow['skin_thumbnail'];
                    $skinTrendingData['skin_bundle'] = $skinTrendingRow['skin_bundle'];
                    $skinTrendingData['skin_downloads'] = numberFormate($skinTrendingRow['skin_downloads']);
                    $skinTrendingData['skin_likes'] = numberFormate($skinTrendingRow['skin_likes']);
                    $skinTrendingData['skin_views'] = numberFormate($skinTrendingRow['skin_views']);
                    $skinTrendingData['skin_type'] = $skinTrendingRow['skin_type'];

                    array_push($response['data'], $skinTrendingData);
                } 
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxShoesData" function is changed in routes.php as "json/rblx-shoes-data"
    public function rblxShoesData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->rblxSkinData($conditions, 'RAND()', 'category_id = "1"', RBLX_SKIN_TABLE);
            
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
                
            $skinShoes = $this->JsonModel->rblxSkinData($conditions, 'RAND()', 'category_id = "1"', RBLX_SKIN_TABLE);
            if($skinShoes != null){
                foreach($skinShoes as $skinShoesRow){
                    $skinShoesData = array();
                    $skinShoesData['skin_id'] = (int)$skinShoesRow['skin_id'];
                    $skinShoesData['category_id'] = $skinShoesRow['category_id'];
                    $skinShoesData['skin_name'] = $skinShoesRow['skin_name'];
                    $skinShoesData['skin_thumbnail'] = $skinShoesRow['skin_thumbnail'];
                    $skinShoesData['skin_bundle'] = $skinShoesRow['skin_bundle'];
                    $skinShoesData['skin_downloads'] = numberFormate($skinShoesRow['skin_downloads']);
                    $skinShoesData['skin_likes'] = numberFormate($skinShoesRow['skin_likes']);
                    $skinShoesData['skin_views'] = numberFormate($skinShoesRow['skin_views']);
                    $skinShoesData['skin_type'] = $skinShoesRow['skin_type'];

                    array_push($response['data'], $skinShoesData);
                } 
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxShirtData" function is changed in routes.php as "json/rblx-shirt-data"
    public function rblxShirtData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        $skinShirtArray = array_merge(array('4,3'), array('5,3'));
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinShirtArray, RBLX_SKIN_TABLE);
            
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
                
            $skinShirt = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinShirtArray, RBLX_SKIN_TABLE);
            if($skinShirt != null){
                foreach($skinShirt as $skinShirtRow){
                    $skinShirtData = array();
                    $skinShirtData['skin_id'] = (int)$skinShirtRow['skin_id'];
                    $skinShirtData['category_id'] = $skinShirtRow['category_id'];
                    $skinShirtData['skin_name'] = $skinShirtRow['skin_name'];
                    $skinShirtData['skin_thumbnail'] = $skinShirtRow['skin_thumbnail'];
                    $skinShirtData['skin_bundle'] = $skinShirtRow['skin_bundle'];
                    $skinShirtData['skin_downloads'] = numberFormate($skinShirtRow['skin_downloads']);
                    $skinShirtData['skin_likes'] = numberFormate($skinShirtRow['skin_likes']);
                    $skinShirtData['skin_views'] = numberFormate($skinShirtRow['skin_views']);
                    $skinShirtData['skin_type'] = $skinShirtRow['skin_type'];

                    array_push($response['data'], $skinShirtData);
                } 
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxPantData" function is changed in routes.php as "json/rblx-pant-data"
    public function rblxPantData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        $skinPantArray = array_merge(array('4,2'), array('5,2'));
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinPantArray, RBLX_SKIN_TABLE);
            
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
                
            $skinPant = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinPantArray, RBLX_SKIN_TABLE);
            if($skinPant != null){
                foreach($skinPant as $skinPantRow){
                    $skinPantData = array();
                    $skinPantData['skin_id'] = (int)$skinPantRow['skin_id'];
                    $skinPantData['category_id'] = $skinPantRow['category_id'];
                    $skinPantData['skin_name'] = $skinPantRow['skin_name'];
                    $skinPantData['skin_thumbnail'] = $skinPantRow['skin_thumbnail'];
                    $skinPantData['skin_bundle'] = $skinPantRow['skin_bundle'];
                    $skinPantData['skin_downloads'] = numberFormate($skinPantRow['skin_downloads']);
                    $skinPantData['skin_likes'] = numberFormate($skinPantRow['skin_likes']);
                    $skinPantData['skin_views'] = numberFormate($skinPantRow['skin_views']);
                    $skinPantData['skin_type'] = $skinPantRow['skin_type'];

                    array_push($response['data'], $skinPantData);
                } 
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxGirlShirtData" function is changed in routes.php as "json/rblx-girl-shirt-data"
    public function rblxGirlShirtData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        $skinGirlShirtArray = array('4,3');
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinGirlShirtArray, RBLX_SKIN_TABLE);
            
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
                
            $skinGirlShirt = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinGirlShirtArray, RBLX_SKIN_TABLE);
            if($skinGirlShirt != null){
                foreach($skinGirlShirt as $skinGirlShirtRow){
                    $skinGirlShirtData = array();
                    $skinGirlShirtData['skin_id'] = (int)$skinGirlShirtRow['skin_id'];
                    $skinGirlShirtData['category_id'] = $skinGirlShirtRow['category_id'];
                    $skinGirlShirtData['skin_name'] = $skinGirlShirtRow['skin_name'];
                    $skinGirlShirtData['skin_thumbnail'] = $skinGirlShirtRow['skin_thumbnail'];
                    $skinGirlShirtData['skin_bundle'] = $skinGirlShirtRow['skin_bundle'];
                    $skinGirlShirtData['skin_downloads'] = numberFormate($skinGirlShirtRow['skin_downloads']);
                    $skinGirlShirtData['skin_likes'] = numberFormate($skinGirlShirtRow['skin_likes']);
                    $skinGirlShirtData['skin_views'] = numberFormate($skinGirlShirtRow['skin_views']);
                    $skinGirlShirtData['skin_type'] = $skinGirlShirtRow['skin_type'];

                    array_push($response['data'], $skinGirlShirtData);
                } 
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxGirlPantData" function is changed in routes.php as "json/rblx-girl-pant-data"
    public function rblxGirlPantData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        $skinGirlPantArray = array('4,2');
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinGirlPantArray, RBLX_SKIN_TABLE);
            
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
                
            $skinGirlPant = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinGirlPantArray, RBLX_SKIN_TABLE);
            if($skinGirlPant != null){
                foreach($skinGirlPant as $skinGirlPantRow){
                    $skinGirlPantData = array();
                    $skinGirlPantData['skin_id'] = (int)$skinGirlPantRow['skin_id'];
                    $skinGirlPantData['category_id'] = $skinGirlPantRow['category_id'];
                    $skinGirlPantData['skin_name'] = $skinGirlPantRow['skin_name'];
                    $skinGirlPantData['skin_thumbnail'] = $skinGirlPantRow['skin_thumbnail'];
                    $skinGirlPantData['skin_bundle'] = $skinGirlPantRow['skin_bundle'];
                    $skinGirlPantData['skin_downloads'] = numberFormate($skinGirlPantRow['skin_downloads']);
                    $skinGirlPantData['skin_likes'] = numberFormate($skinGirlPantRow['skin_likes']);
                    $skinGirlPantData['skin_views'] = numberFormate($skinGirlPantRow['skin_views']);
                    $skinGirlPantData['skin_type'] = $skinGirlPantRow['skin_type'];

                    array_push($response['data'], $skinGirlPantData);
                } 
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxBoyShirtData" function is changed in routes.php as "json/rblx-boy-shirt-data"
    public function rblxBoyShirtData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        $skinBoyShirtArray = array('5,3');
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinBoyShirtArray, RBLX_SKIN_TABLE);
            
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
                
            $skinBoyShirt = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinBoyShirtArray, RBLX_SKIN_TABLE);
            if($skinBoyShirt != null){
                foreach($skinBoyShirt as $skinBoyShirtRow){
                    $skinBoyShirtData = array();
                    $skinBoyShirtData['skin_id'] = (int)$skinBoyShirtRow['skin_id'];
                    $skinBoyShirtData['category_id'] = $skinBoyShirtRow['category_id'];
                    $skinBoyShirtData['skin_name'] = $skinBoyShirtRow['skin_name'];
                    $skinBoyShirtData['skin_thumbnail'] = $skinBoyShirtRow['skin_thumbnail'];
                    $skinBoyShirtData['skin_bundle'] = $skinBoyShirtRow['skin_bundle'];
                    $skinBoyShirtData['skin_downloads'] = numberFormate($skinBoyShirtRow['skin_downloads']);
                    $skinBoyShirtData['skin_likes'] = numberFormate($skinBoyShirtRow['skin_likes']);
                    $skinBoyShirtData['skin_views'] = numberFormate($skinBoyShirtRow['skin_views']);
                    $skinBoyShirtData['skin_type'] = $skinBoyShirtRow['skin_type'];

                    array_push($response['data'], $skinBoyShirtData);
                } 
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxBoyPantData" function is changed in routes.php as "json/rblx-boy-pant-data"
    public function rblxBoyPantData(){
        $response = array();
        $response['data'] = array();

        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        
        $skinBoyPantArray = array('5,2');
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinBoyPantArray, RBLX_SKIN_TABLE);
            
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
                
            $skinBoyPant = $this->JsonModel->viewRblxSkinData($conditions, 'RAND()', $skinBoyPantArray, RBLX_SKIN_TABLE);
            if($skinBoyPant != null){
                foreach($skinBoyPant as $skinBoyPantRow){
                    $skinBoyPantData = array();
                    $skinBoyPantData['skin_id'] = (int)$skinBoyPantRow['skin_id'];
                    $skinBoyPantData['category_id'] = $skinBoyPantRow['category_id'];
                    $skinBoyPantData['skin_name'] = $skinBoyPantRow['skin_name'];
                    $skinBoyPantData['skin_thumbnail'] = $skinBoyPantRow['skin_thumbnail'];
                    $skinBoyPantData['skin_bundle'] = $skinBoyPantRow['skin_bundle'];
                    $skinBoyPantData['skin_downloads'] = numberFormate($skinBoyPantRow['skin_downloads']);
                    $skinBoyPantData['skin_likes'] = numberFormate($skinBoyPantRow['skin_likes']);
                    $skinBoyPantData['skin_views'] = numberFormate($skinBoyPantRow['skin_views']);
                    $skinBoyPantData['skin_type'] = $skinBoyPantRow['skin_type'];

                    array_push($response['data'], $skinBoyPantData);
                } 
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data available in table";
            } 
        } else {
            $response['message'] = "permission denied";
        }         
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "rblxDownloadData" function is changed in routes.php as "json/rblx-download-data"
    public function rblxDownloadData(){
	    if($this->input->post('skin_id')){
    	    $skinID = $this->input->post('skin_id');
    	    $skinData = $this->JsonModel->getData('skin_id = '.$skinID, RBLX_SKIN_TABLE);
    	    
    	    if($skinData){
        	    $oldView = $skinData['skin_downloads'];
        	    $totalView = $oldView + 1;
    	    }
    	    $editData = array(
    	        'skin_downloads'=>$totalView
    		);
    	
    	    $result = $this->JsonModel->editData('skin_id = '.$skinID, RBLX_SKIN_TABLE, $editData);
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
    // Note : "rblxLikedData" function is changed in routes.php as "json/rblx-liked-data"
    public function rblxLikedData(){
	    if($this->input->post('skin_id')){
    	    $skinID = $this->input->post('skin_id');
    	    $skinData = $this->JsonModel->getData('skin_id = '.$skinID, RBLX_SKIN_TABLE);
    	    
    	    if($skinData){
        	    $oldView = $skinData['skin_likes'];
        	    $totalView = $oldView + 1;
    	    }
    	    $editData = array(
    	        'skin_likes'=>$totalView
    		);
    	
    	    $result = $this->JsonModel->editData('skin_id = '.$skinID, RBLX_SKIN_TABLE, $editData);
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
    // Note : "rblxViewedData" function is changed in routes.php as "json/rblx-viewed-data"
    public function rblxViewedData(){
	    if($this->input->post('skin_id')){
    	    $skinID = $this->input->post('skin_id');
    	    $skinData = $this->JsonModel->getData('skin_id = '.$skinID, RBLX_SKIN_TABLE);
    	    
    	    if($skinData){
        	    $oldView = $skinData['skin_views'];
        	    $totalView = $oldView + 1;
    	    }
    	    $editData = array(
    	        'skin_views'=>$totalView
    		);
    	
    	    $result = $this->JsonModel->editData('skin_id = '.$skinID, RBLX_SKIN_TABLE, $editData);
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
    // Note : "rblxSearchData" function is changed in routes.php as "json/rblx-search-data"
    public function rblxSearchData(){
        $response = array();
        $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $skinName = $this->input->post('skin_name');

        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->searchSkinData($conditions, $skinName, RBLX_SKIN_TABLE);
            
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
            
            $skin = $this->JsonModel->searchSkinData($conditions, $skinName, RBLX_SKIN_TABLE);
            
            if($skin != null){
                foreach($skin as $skinRow){
                    $skinData = array();
                    $skinData['skin_id'] = (int)$skinRow['skin_id'];
                    $skinData['skin_name'] = $skinRow['skin_name'];
                    $skinData['skin_thumbnail'] = $skinRow['skin_thumbnail'];
                    $skinData['skin_bundle'] = $skinRow['skin_bundle'];
                    $skinData['skin_downloads'] = $skinRow['skin_downloads'];
                    $skinData['skin_likes'] = $skinRow['skin_likes'];
                    $skinData['skin_views'] = $skinRow['skin_views'];
                    $skinData['skin_type'] = $skinRow['skin_type'];
                    
                    array_push($response['data'], $skinData);
                }
                if($response['data'] != null){
                    $response['message'] = "success";
                } else {
                   $response['message'] = "permission denied"; 
                }
            } else {
                $response['message'] = "No data found"; 
            }
        } else {
            $response['message'] = "permission denied";
        }
        echo json_encode($response);  
    }
}