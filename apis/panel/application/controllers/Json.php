<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Json extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "appMainData" function is changed in routes.php as "json/app-main-data"
    public function appMainData(){
        $appCode = $this->input->post('app_code');
        $appVersion = $this->input->post('app_version');
        
        $response = array();
    	$response['apps'] = array();
    	$response['version'] = array();
    	$response['ads'] = array();
    	$response['banner'] = array();
    	$response['subscription'] = array();
    	
        $getApp = $this->JsonModel->getAppData($appCode, ANDROID_APPS_TABLE);
        if($getApp != null){
            $appID = $getApp->app_id;
            $appData=array(
                'app_package' => $getApp->app_package,
                'app_email' => $getApp->app_email,
                'app_store' => $getApp->app_store,
        		'app_privacy' => $getApp->app_privacy,
        		'app_terms' => $getApp->app_terms
    		);
        	$response['apps'] = $appData;
        	
        	$getVersion = $this->JsonModel->getVersionData($appID, $appVersion, ANDROID_VERSION_TABLE);
        	if($getVersion != null){
        	    $versionID = $getVersion->version_id;
                $versionData=array(
                    'app_ads' => $getVersion->app_ads,
                    'app_banner' => $getVersion->app_banner,
                    'splash_ads' => $getVersion->splash_ads,
                    'screen_ads' => $getVersion->screen_ads,
                    'ads_count_one' => $getVersion->ads_count_one,
                    'ads_count_two' => $getVersion->ads_count_two,
                    'ads_count_three' => $getVersion->ads_count_three,
                    'ads_count_four' => $getVersion->ads_count_four,
                    'app_review' => $getVersion->app_review,
                    'review_count' => $getVersion->review_count,
                    'app_update' => $getVersion->app_update,
                    'update_title' => $getVersion->update_title,
                    'update_description' => $getVersion->update_description,
                    'update_button' => $getVersion->update_button,
                    'update_url' => $getVersion->update_url,
                    'app_open' => $getVersion->app_open,
                    'app_subscription' => $getVersion->app_subscription,
                    'is_rewarded' => $getVersion->is_rewarded,
                    'version_status' => $getVersion->version_status
        		);
        		$response['version'] = $versionData;
        	}
    		
    		$getAds = $this->JsonModel->getAdsData($appID, ANDROID_AD_TABLE);
            if($getAds != null){
                $adsData=array(
        		    'banner_ads_one' => $getAds->banner_ads_one,
        		    'banner_ads_two' => $getAds->banner_ads_two,
        		    'banner_ads_three' => $getAds->banner_ads_three,
        		    'banner_ads_four' => $getAds->banner_ads_four,
        		    'banner_ads_five' => $getAds->banner_ads_five,
        		    'native_ads_one' => $getAds->native_ads_one,
        		    'native_ads_two' => $getAds->native_ads_two,
        		    'native_ads_three' => $getAds->native_ads_three,
        		    'native_ads_four' => $getAds->native_ads_four,
        		    'native_ads_five' => $getAds->native_ads_five,
        		    'native_ads_six' => $getAds->native_ads_six,
        		    'native_ads_seven' => $getAds->native_ads_seven,
        		    'native_ads_eight' => $getAds->native_ads_eight,
        		    'native_ads_nine' => $getAds->native_ads_nine,
        		    'native_ads_ten' => $getAds->native_ads_ten,
        		    'interstitial_ads_one' => $getAds->interstitial_ads_one,
        		    'interstitial_ads_two' => $getAds->interstitial_ads_two,
        		    'interstitial_ads_three' => $getAds->interstitial_ads_three,
        		    'interstitial_ads_four' => $getAds->interstitial_ads_four,
        		    'interstitial_ads_five' => $getAds->interstitial_ads_five,
        		    'interstitial_ads_six' => $getAds->interstitial_ads_six,
        		    'interstitial_ads_seven' => $getAds->interstitial_ads_seven,
        		    'interstitial_ads_eight' => $getAds->interstitial_ads_eight,
        		    'interstitial_ads_nine' => $getAds->interstitial_ads_nine,
        		    'interstitial_ads_ten' => $getAds->interstitial_ads_ten,
        		    'open_ads_one' => $getAds->open_ads_one,
        		    'rewards_ads_one' => $getAds->rewards_ads_one
        		);
        		$response['ads'] = $adsData;
            }
            
            $getJson = $this->JsonModel->getJsonData($appID, ANDROID_JSON_TABLE);
    		$bannerIDs = $getJson->json_data;
    		$bannerArray = explode(",",$bannerIDs);
    		foreach ($bannerArray as $row) {
    	        $bannerID = $row;
    	        $getJsonData = $this->JsonModel->getBannerData($bannerID, ANDROID_BANNER_TABLE);
    	        array_push($response['banner'], $getJsonData);
    	    }
    	    
    	    $getSubscription = $this->JsonModel->getAppSubscriptionData($appID, ANDROID_SUBSCRIPTION_TABLE);
    		foreach ($getSubscription as $subscriptionRow) {
    	        $subscriptionData=array();
                $subscriptionData['subscription_id'] = (int)$subscriptionRow->subscription_id;
                $subscriptionData['app_id'] = (int)$subscriptionRow->app_id;
                $subscriptionData['subscription_code'] = $subscriptionRow->subscription_code;
                $subscriptionData['subscription_title_one'] = $subscriptionRow->subscription_title_one;
                $subscriptionData['subscription_title_two'] = $subscriptionRow->subscription_title_two;
                $subscriptionData['subscription_title_three'] = $subscriptionRow->subscription_title_three;
                $subscriptionData['subscription_title_four'] = $subscriptionRow->subscription_title_four;
                $subscriptionData['subscription_primary'] = $subscriptionRow->subscription_primary;
                $subscriptionData['subscription_status'] = $subscriptionRow->subscription_status;
    	        array_push($response['subscription'], $subscriptionData);
    	    }
    	    
            if(!empty($response)){
                $statusData = array('status' => true, 'code' => true);
                $response['response'] = $statusData;
                echo json_encode($response);
            } else {
                $statusData = array('status' => true, 'code' => false);
                $response['response'] = $statusData;
                echo json_encode($response);
            }
        } else {
            $status = "error";
            echo json_encode(array("response"=>$status));
        }
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "mainData" function is changed in routes.php as "json/main-data"
    public function mainData(){
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $dataType = $this->input->post('data_type');
        
        if($dataType == "mods"){ $dataTable = MODS_DATA; $categoryTable = MODS_CATEGORY; } 
        else if($dataType == "addons"){ $dataTable = ADDONS_DATA; $categoryTable = ADDONS_CATEGORY; } 
        else if($dataType == "maps"){ $dataTable = MAPS_DATA; $categoryTable = MAPS_CATEGORY; } 
        else if($dataType == "seeds"){ $dataTable = SEEDS_DATA; $categoryTable = SEEDS_CATEGORY; } 
        else if($dataType == "textures"){ $dataTable = TEXTURES_DATA; $categoryTable = TEXTURES_CATEGORY; } 
        else if($dataType == "shaders"){ $dataTable = SHADERS_DATA; $categoryTable = SHADERS_CATEGORY; } 
        else if($dataType == "skin"){ $dataTable = SKIN_DATA; $categoryTable = SKIN_CATEGORY; } 
        else { $dataTable = MODS_DATA; $categoryTable = MODS_CATEGORY; }
        
        if($apiValidated and $dataType){
            $response = array();
            $response['data'] = array();
            $response['trending'] = array();
            $response['featured'] = array();

            $whereTrending = array('data_status' => 'publish');
            $trendingData = $this->JsonModel->viewData($whereTrending, "data_download", 10, $dataTable);
            if($trendingData){
                foreach($trendingData as $searchRow){
                    $mcpeData = array();
                    $mcpeData['unique_id'] = $searchRow->unique_id;
                    $mcpeData['category_id'] = $searchRow->category_id;
                    $mcpeData['data_name'] = $searchRow->data_name;
                    $mcpeData['data_description'] = $searchRow->data_description;
                    $mcpeData['data_image'] = $searchRow->data_image;
                    $mcpeData['data_bundle'] = $searchRow->data_bundle;
                    $mcpeData['data_support_version'] = $searchRow->data_support_version;
                    $mcpeData['data_price'] = $searchRow->data_price;
                    $mcpeData['data_size'] = $searchRow->data_size;

                    array_push($response['trending'], $mcpeData);
                } 
                $responseData['trending'] = $response['trending'];
            }
            
            $whereCategory = array('category_status' => 'publish');
            $categoryData = $this->JsonModel->viewData($whereCategory, "category_id", null, $categoryTable);
            if($categoryData){
                foreach ($categoryData as $categoryRow){
    			    $category['category_id'] = $categoryRow->category_id;
    	    	    $category['category_name'] = $categoryRow->category_name;
    	    	
        			$allData = $this->JsonModel->viewData('category_id = '.$category['category_id'], "unique_id", 10, $dataTable);
        			$category['packs'] = array();
        			foreach($allData as $dataRow){
    					$mcpeData = array();
                        $mcpeData['unique_id'] = $dataRow->unique_id;
                        $mcpeData['category_id'] = $dataRow->category_id;
                        $mcpeData['data_name'] = $dataRow->data_name;
                        $mcpeData['data_description'] = $dataRow->data_description;
                        $mcpeData['data_image'] = $dataRow->data_image;
                        $mcpeData['data_bundle'] = $dataRow->data_bundle;
                        $mcpeData['data_support_version'] = $dataRow->data_support_version;
                        $mcpeData['data_price'] = $dataRow->data_price;
                        $mcpeData['data_size'] = $dataRow->data_size;
    					
    					array_push($category['packs'], $mcpeData);
        			}
        			if($category['packs'] != null){
        			    array_push($response['data'],$category);
        			}
        		}
        		$responseData['data'] = $response['data'];
            }
            
            $whereFeatured = array('data_status' => 'publish');
            $featuredData = $this->JsonModel->viewData($whereFeatured, "unique_id", 10, $dataTable);
            if($featuredData){
                foreach($featuredData as $searchRow){
                    $mcpeData = array();
                    $mcpeData['unique_id'] = $searchRow->unique_id;
                    $mcpeData['category_id'] = $searchRow->category_id;
                    $mcpeData['data_name'] = $searchRow->data_name;
                    $mcpeData['data_description'] = $searchRow->data_description;
                    $mcpeData['data_image'] = $searchRow->data_image;
                    $mcpeData['data_bundle'] = $searchRow->data_bundle;
                    $mcpeData['data_support_version'] = $searchRow->data_support_version;
                    $mcpeData['data_price'] = $searchRow->data_price;
                    $mcpeData['data_size'] = $searchRow->data_size;

                    array_push($response['featured'], $mcpeData);
                } 
                $responseData['featured'] = $response['featured'];
            }
            
        } else {
            $responseData['message'] = "permission denied";
        }  

        echo json_encode($responseData);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "viewData" function is changed in routes.php as "json/view-data"
    public function viewData(){
        $response = array();
        $response['data'] = array();
        
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $dataType = $this->input->post('data_type');
        $categoryID = $this->input->post('category_id');
        
        if($dataType == "mods"){ $dataTable = MODS_DATA; } 
        else if($dataType == "addons"){ $dataTable = ADDONS_DATA; } 
        else if($dataType == "maps"){ $dataTable = MAPS_DATA; } 
        else if($dataType == "seeds"){ $dataTable = SEEDS_DATA; } 
        else if($dataType == "textures"){ $dataTable = TEXTURES_DATA; } 
        else if($dataType == "shaders"){ $dataTable = SHADERS_DATA; } 
        else if($dataType == "skin"){ $dataTable = SKIN_DATA; } 
        else { $dataTable = MODS_DATA; }
        
        if($apiValidated){
            //get rows count
            $conditions['returnType'] = 'count';
            $totalRec = $this->JsonModel->viewAllData($categoryID, $conditions, $dataTable);
            
            //pagination config
            $config['base_url']    = site_url('json/view-data/');
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
            $allData = $this->JsonModel->viewAllData($categoryID, $conditions, $dataTable);
            
            if(!empty($allData)){
                foreach($allData as $dataRow){
                    $mcpeData = array();
                    $mcpeData['unique_id'] = $dataRow->unique_id;
                    $mcpeData['category_id'] = $dataRow->category_id;
                    $mcpeData['data_name'] = $dataRow->data_name;
                    $mcpeData['data_description'] = $dataRow->data_description;
                    $mcpeData['data_image'] = $dataRow->data_image;
                    $mcpeData['data_bundle'] = $dataRow->data_bundle;
                    $mcpeData['data_support_version'] = $dataRow->data_support_version;
                    $mcpeData['data_price'] = $dataRow->data_price;
                    $mcpeData['data_size'] = $dataRow->data_size;
                    
                    array_push($response['data'], $mcpeData);
                }
                $response = $response['data'];
                
            } else {
                $response['data'] = "empty"; 
            }
        } else {
            $response['message'] = "permission denied";
        }
        echo json_encode($response);  
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "searchData" function is changed in routes.php as "json/search-data"
    public function searchData(){
        date_default_timezone_set("Asia/Kolkata");
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $dataType = $this->input->post('search_category');
        $searchQuery = $this->input->post('search_query');
        
        if($dataType == "mods"){ $dataTable = MODS_DATA; } 
        else if($dataType == "addons"){ $dataTable = ADDONS_DATA; } 
        else if($dataType == "maps"){ $dataTable = MAPS_DATA; } 
        else if($dataType == "seeds"){ $dataTable = SEEDS_DATA; } 
        else if($dataType == "textures"){ $dataTable = TEXTURES_DATA; } 
        else if($dataType == "shaders"){ $dataTable = SHADERS_DATA; } 
        else if($dataType == "skin"){ $dataTable = SKIN_DATA; } 
        else { $dataType = MODS_DATA; }
        
        if($apiValidated and $dataTable and $searchQuery){
            $response = array();
            $response['data'] = array();

            $regex = '/^[a-zA-Z0-9-_]+$/';
            if (preg_match($regex, $searchQuery)) {
                $whereArray = array('data_status' => 'publish');
                $searchData = $this->JsonModel->viewSearch($searchQuery, $whereArray, $dataTable);
                if(!empty($searchData)){
                    foreach($searchData as $searchRow){
                        $mcpeData = array();
                        $mcpeData['unique_id'] = $searchRow->unique_id;
                        $mcpeData['category_id'] = $searchRow->category_id;
                        $mcpeData['data_name'] = $searchRow->data_name;
                        $mcpeData['data_description'] = $searchRow->data_description;
                        $mcpeData['data_image'] = $searchRow->data_image;
                        $mcpeData['data_bundle'] = $searchRow->data_bundle;
                        $mcpeData['data_support_version'] = $searchRow->data_support_version;
                        $mcpeData['data_price'] = $searchRow->data_price;
                        $mcpeData['data_size'] = $searchRow->data_size;
    
                        array_push($response['data'], $mcpeData);
                    } 
                    
                    $responseData['data'] = $response['data'];
                    $responseData['message'] = "success";
                    
                } else {
                    $newData = array(
                        'search_category'=>$this->input->post('search_category'),
                        'search_query'=>$this->input->post('search_query'),
                        'search_time' => date('d-m-Y h:i:s A'),
                        'search_status' => "publish"
                    );
                    
                    $newResult = $this->JsonModel->insertData(SEARCH_TABLE, $newData);
                    $responseData['message'] = "empty";
                } 
            } else {
                $responseData['message'] = "empty";
            }
        } else {
            $responseData['message'] = "permission denied";
        }  

        echo json_encode($responseData);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "newDataDownload" function is changed in routes.php as "json/new-data-download"
    public function newDataDownload(){
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $uniqueID = $this->input->post('unique_id');
        $dataType = $this->input->post('data_type');

        if($dataType == "mods"){ $dataTable = MODS_DATA; } 
        else if($dataType == "addons"){ $dataTable = ADDONS_DATA; } 
        else if($dataType == "maps"){ $dataTable = MAPS_DATA; } 
        else if($dataType == "seeds"){ $dataTable = SEEDS_DATA; } 
        else if($dataType == "textures"){ $dataTable = TEXTURES_DATA; } 
        else if($dataType == "shaders"){ $dataTable = SHADERS_DATA; } 
        else if($dataType == "skin"){ $dataTable = SKIN_DATA; } 
        else { $dataTable = MODS_DATA; }
        
        if($apiValidated){
            $viewData = $this->JsonModel->getData('unique_id = '.$uniqueID, $dataTable);
            if(!empty($viewData)){
                $downloadCount = $viewData->data_download;
                $newCount = $downloadCount + 1;
                
                $editData = array('data_download' => $newCount);
    			$editResult = $this->JsonModel->editData('unique_id = '.$uniqueID, $dataTable, $editData); 
                if($editResult){
                    $response['message'] = "success";
                } else {
                    $response['message'] = "error";
                }
            } else {
                $response['message'] = "empty"; 
            }
        } else {
            $response['message'] = "permission denied"; 
        }  
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "newDataView" function is changed in routes.php as "json/new-data-view"
    public function newDataView(){
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        $uniqueID = $this->input->post('unique_id');
        $dataType = $this->input->post('data_type');

        if($dataType == "mods"){ $dataTable = MODS_DATA; } 
        else if($dataType == "addons"){ $dataTable = ADDONS_DATA; } 
        else if($dataType == "maps"){ $dataTable = MAPS_DATA; } 
        else if($dataType == "seeds"){ $dataTable = SEEDS_DATA; } 
        else if($dataType == "textures"){ $dataTable = TEXTURES_DATA; } 
        else if($dataType == "shaders"){ $dataTable = SHADERS_DATA; } 
        else if($dataType == "skin"){ $dataTable = SKIN_DATA; } 
        else { $dataTable = MODS_DATA; }
        
        if($apiValidated){
            $viewData = $this->JsonModel->getData('unique_id = '.$uniqueID, $dataTable);
            if(!empty($viewData)){
                $downloadCount = $viewData->data_view;
                $newCount = $downloadCount + 1;
                
                $editData = array('data_view' => $newCount);
    			$editResult = $this->JsonModel->editData('unique_id = '.$uniqueID, $dataTable, $editData); 
                if($editResult){
                    $response['message'] = "success";
                } else {
                    $response['message'] = "error";
                }
            } else {
                $response['message'] = "empty"; 
            }
        } else {
            $response['message'] = "permission denied"; 
        }  
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "sendTokenData" function is changed in routes.php as "json/send-token-data"
    public function sendTokenData(){
        $appCode = $this->input->post('app_code');
        $deviceString = $this->input->post('device_string');
        $tokenString = $this->input->post('token_string');
        
        if($appCode == "DEMO-01"){ $table = "ztoken_xcsk"; } 
        else if($appCode == "DEMO-02") { $table = "ztoken_xcsk"; }  
        else { $table = "ztoken_xcsk"; }
        
        $apiValidated = isApiValidation($this->input->post('api_auth'));
        if($apiValidated){
            if($deviceString and $tokenString){
                $deviceData = $this->JsonModel->viewDevice($deviceString, $table);
                if(empty($deviceData)) {
                    date_default_timezone_set("Asia/Kolkata");
        	        $newData = array(
            	        'device_string'=>$this->input->post('device_string'),
            	        'token_string'=>$this->input->post('token_string'),
            	        'token_time'=>date('d/m/Y h:i:s A'),
            	        'token_status'=>"active",
            		);
            	    $result = $this->JsonModel->insertData($table,$newData);
            	    if($result){
            	       $status = "success";
                       echo json_encode(array("response"=>$status));
            	    }
                } else {
                    date_default_timezone_set("Asia/Kolkata");
                    $tokenID = $deviceData->token_id;
        	        $editData = array(
            	        'token_string'=>$this->input->post('token_string'),
            	        'token_time'=>date('d/m/Y h:i:s A'),
            	        'token_status'=>"active",
            		);
            		
            		$result = $this->JsonModel->editData('token_id = '.$tokenID, $table, $editData);
    				if($result){
    					$status = "success";
                        echo json_encode(array("response"=>$status));
    				}
                }
            } else {
    	        $status = "permission denied";
                echo json_encode(array("response"=>$status)); 
    	    }
        } else {
	        $status = "permission denied";
            echo json_encode(array("response"=>$status)); 
	    }
    }
}