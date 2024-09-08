<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class Json extends CI_Controller {
    
    function __construct(){
		parent::__construct();
		$this->load->model('JsonModel');
		
		$this->settingData();
	}

	public function index(){
		$this->load->view('welcome');
	}
	
	// S3Bucket Config Start //
    public function getconfig() {
        $s3Client = new S3Client([
            'version' => 'latest',
            'region'  => S3_REGION,
            'credentials' => [
                'key'    => S3_KEY,
                'secret' => S3_SECRET
            ]            
        ]);
        return $s3Client;
    }
    public function newBucketObject($objectName, $objectTemp, $objectPath){
	    date_default_timezone_set("Asia/Kolkata");
	    $s3Client = $this->getconfig();
        $result = $s3Client->putObject([
            'Bucket' => BUCKET_NAME,
            'Key'    => $objectPath.$objectName,
            'Body'   => $objectTemp,
            'ACL'    => 'public-read', 
        ]);
		return $result->get('ObjectURL');
	}
	// S3Bucket Config End //
	
	
	// Final Api Functions
    // ====================
	// Note : Please change this function name in "routes.php" before update it's name
    // Note : "userLoginOTP" function is changed in routes.php as "user-login-otp"
	public function userLoginOTP_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $response['data'] = array();
        $apiAuth = $this->input->post('api_auth');
        $userMobile = $this->input->post('user_mobile');
        $userOTP = $this->input->post('user_otp');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userMobile, $userMobile, $userMobile, $userOTP, $userOTP, $userOTP);
        
        if($apiValidated and $dataValidated){
            // Account details
        	$apiKey = urlencode('NWE3NDcwNzM0MzY1MzM1MzY3NDQ2YzQyNmU2NzVhMzg=');
        	
        	// Message details
        	$randomNumber = $userOTP;
        	$numbers = $userMobile;
        	$sender = urlencode('BRNDAD');
        	$message = rawurlencode('Your login OTP for BrandAd365 is ' .$randomNumber. '. It is valid for 15 minutes. Please do not share OTP with anyone. %nRegards, %nBrandAd365 Team.');
         
        	// Prepare data for POST request
        	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
         
        	// Send the POST request with cURL
        	$ch = curl_init('https://api.textlocal.in/send/');
        	curl_setopt($ch, CURLOPT_POST, true);
        	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        	$result = curl_exec($ch);
        	curl_close($ch);
        	
            //echo $response;
            $responseData['message'] = "success";
        	
        } else {
            $responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    	
    }
	
	// Note : Please change this function name in "routes.php" before update it's name
    // Note : "userAppData" function is changed in routes.php as "user-app-data"
	public function userAppData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $appCode = $this->input->post('app_code');
        $appVersion = $this->input->post('app_version');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($appCode, $appCode, $appCode, $appVersion, $appVersion, $appVersion);
    
        if($apiValidated and $dataValidated){
            $responseData = array();
    	    $responseData['apps'] = array();
    	    $responseData['version'] = array();
    	    $responseData['banner'] = array();
    	    $responseData['subscription'] = array();
    	    $responseData['language'] = array();
    	    
            $getApp = $this->JsonModel->viewApp($appCode, ANDROID_APPS);
            if($getApp != null){
                $appID = $getApp->app_id;
                $appData = array(
                    'app_email' => $getApp->app_email,
            		'app_privacy' => $getApp->app_privacy,
            		'app_terms' => $getApp->app_terms,
            		'app_faqs' => $getApp->app_faqs,
        		);
        		$responseData['apps'] = $appData;

        		$getVersion = $this->JsonModel->viewVersion($appID, $appVersion, ANDROID_VERSION);
                if($getVersion != null){
                    $versionID = $getVersion->version_id;
                    $versionData = array(
                		'app_banner' => $getVersion->app_banner,
                		'app_review' => $getVersion->app_review,
                		'app_payment' => $getVersion->app_payment,
                		'app_notice' => $getVersion->app_notice,
                		'notice_title' => $getVersion->notice_title,
                		'notice_description' => $getVersion->notice_description,
                		'notice_button' => $getVersion->notice_button,
                		'notice_url' => $getVersion->notice_url,
                		'review_count' => $getVersion->review_count
            		);
            		$responseData['version'] = $versionData;
                }
                
                $productStatus = "true";
        		$getSubscription = $this->JsonModel->viewData(null, 'product_status = '.$productStatus, SUBSCRIPTION_PACKAGE);
        		foreach ($getSubscription as $subRow) {
        		    $subArray = array(
                		'product_id' => $subRow->product_id,
                		'product_type' => $subRow->product_type,
                		'product_mrp' => $subRow->product_mrp,
                		'product_price' => $subRow->product_price,
                		'product_discount' => $subRow->product_discount,
                		'product_sku' => $subRow->product_sku,
                		'product_feature_one' => $subRow->product_feature_one,
                		'product_feature_two' => $subRow->product_feature_two,
                		'product_feature_three' => $subRow->product_feature_three,
                		'product_feature_four' => $subRow->product_feature_four
            		);
        	        array_push($responseData['subscription'],$subArray);
        	    }
        	    
        	    $getLanguage = $this->JsonModel->viewData(null, null, ANDROID_LANGUAGE);
        		foreach ($getLanguage as $lanRow) {
        		    $lanArray = array(
                		'language_id' => $lanRow->language_id,
                		'language_code' => $lanRow->language_code,
                		'language_name' => $lanRow->language_name
            		);
        	        array_push($responseData['language'],$lanArray);
        	    }
                
                $getBanners = $this->JsonModel->viewJson($appID, ANDROID_JSON);
        		$bannerIDs = $getBanners->json_data;
        		$bannerArray = explode(",",$bannerIDs);
        		foreach ($bannerArray as $row) {
        	        $banner_id = $row;
        	        $getBanners = $this->JsonModel->viewBanner($banner_id, ANDROID_BANNER);
        	        array_push($responseData['banner'],$getBanners);
        	    }
                
                $statusData = array('status' => true, 'code' => true);
                $responseData['response'] = $statusData;

            } else {
                $responseData['message'] = "permission denied";
            }
        } else {
            $responseData['message'] = "permission denied";
        }
        
        echo json_encode($responseData);
	}

    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "viewUserData" function is changed in routes.php as "view-user-data"
    public function viewUserData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
        $response['data'] = array();
        $responseData['user']=array();
        $responseData['primary'] = array();
        $responseData['business'] = array();
        $responseData['discount'] = array();
        
        $userData = array();
        $primaryData = array();
        $businessData = array();
        $discountData = array();
        
        $userMobile = $this->input->post('user_mobile');
        $deviceString = $this->input->post('device_string');
        $tokenString = $this->input->post('token_string');
        $userDevice = $this->input->post('user_device');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userMobile, $deviceString, $userDevice, $userMobile, $userMobile, $userMobile);
        
        if($apiValidated and $dataValidated){
            $userResponse = $this->JsonModel->getData('user_mobile = '.$userMobile, null, BA_USERS);
            if($userResponse){
                $userStatus = $userResponse->user_status;
                $userKey = $userResponse->user_key;
                $businessKey = $userResponse->user_primary_business;
                if($userStatus == "active"){
                    $editData = array(
                        'user_token_id'=>$tokenString,
            		);
            		$editResult = $this->JsonModel->editData('user_key = '.$userKey, BA_USERS, $editData);
            		
                    $userData['user_key'] = $userResponse->user_key;
        			$userData['user_mobile'] = $userResponse->user_mobile;
        			$userData['user_device_id'] = $userResponse->user_device_id;
        			$userData['user_language'] = $userResponse->user_language;
        			$userData['user_business_limit'] = $userResponse->user_business_limit;
        			$userData['message'] = $userResponse->user_status;
        			
        			$primaryResponse = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
            	    $primaryData = $this->primaryBusinessData($primaryResponse);
            	    
            	    $businessResponse = $this->JsonModel->viewData('user_key = '.$userKey, null, BA_BUSINESS);
            	    $businessData = $this->regularBusinessData($businessResponse, $businessKey);
            	    
            	    $discountResponse = $this->JsonModel->getData('user_key = '.$userKey, null, BA_DISCOUNT);
            	    $discountData = $this->userDiscountData($discountResponse);
            	    
                } else {
                    $userData['message'] = "blocked";
                }
                
                $responseData['user'] = $userData;
                $responseData['primary'] = $primaryData;
                $responseData['business'] = $businessData;
                $responseData['discount'] = $discountData;
                
            } else {
                $userKey = $this->uniqueKey();
                $newData = array(
                    'user_key'=>$userKey,
                    'user_mobile'=>$userMobile,
        	        'user_token_id'=>$tokenString,
        	        'user_device_id'=>$deviceString,
        	        'user_device_os'=>$userDevice,
        	        'user_create_time'=>date('d/m/Y h:i:s A'),
        	        'user_language'=>"EN",
        	        'user_visit_time'=>"-",
        	        'user_status'=>"active",
        		);
        		
        		$newResult = $this->JsonModel->insertData(BA_USERS, $newData);
        		if($newResult){
        	        $dataResponse = $this->JsonModel->getData('user_mobile = '.$userMobile, null, BA_USERS);
                    $userData['user_key'] = $dataResponse->user_key;
        			$userData['user_mobile'] = $dataResponse->user_mobile;
        			$userData['user_device_id'] = $dataResponse->user_device_id;
        			$userData['user_language'] = $dataResponse->user_language;
        			$userData['user_business_limit'] = $dataResponse->user_business_limit;
        			$userData['message'] = $dataResponse->user_status;
        	    } else {
        	        $userData['message'] = "error";
        	    }
        	    
        	    $primaryData['message'] = "empty";
    			$businessData['message'] = "empty";
    			$discountData['message'] = "empty";
    			
    			$responseData['user'] = $userData;
    			$responseData['primary'] = $primaryData;
    			array_push($responseData['business'],$businessData);
    			$responseData['discount'] = $discountData;
            }
        } else {
    		$responseData['message'] = $this->errorCode(500);
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "editUserProfile" function is changed in routes.php as "edit-user-profile"
    public function editUserProfile_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $response['data'] = array();
        $responseData['user']=array();
        $userData = array();
        
        $userKey = $this->input->post('user_key');
        $userName = $this->input->post('user_name');
        $userEmail = $this->input->post('user_email');
        $userBirthdate = $this->input->post('user_birthdate');
        $userGender = $this->input->post('user_gender');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $userName, $userGender, $userKey, $userKey, $userKey);
        
        if($apiValidated and $dataValidated){
            $userResponse = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($userResponse){
                if($userResponse->user_status == "active"){
                    $editData = array(
                        'user_name'=>$userName,
        	            'user_email'=>$userEmail,
        	            'user_birthdate'=>$userBirthdate,
            	        'user_gender'=>$userGender,
            		);
            		$editResult = $this->JsonModel->editData('user_key = '.$userKey, BA_USERS, $editData);
            		if($editResult){
            		    $editResponse = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            		    $userData['user_name'] = $editResponse->user_name;
            			$userData['user_email'] = $editResponse->user_email;
            			$userData['user_birthdate'] = $editResponse->user_birthdate;
            			$userData['user_gender'] = $editResponse->user_gender;
            			$userData['message'] = $userResponse->user_status;
            		} else {
            		    $responseData['message'] = $this->errorCode(500);
            		}
                } else {
                   $userData['message'] = "blocked"; 
                }
                $responseData['user'] = $userData;
            } else {
                $responseData['message'] = $this->errorCode(500);
            }
        } else {
    		$responseData['message'] = $this->errorCode(500);
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "editUserLanguage" function is changed in routes.php as "edit-user-language"
    public function editUserLanguage_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
	    $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $userKey = $this->input->post('user_key');
        $userLanguage = $this->input->post('user_language');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $userLanguage, $userLanguage, $userLanguage, $userLanguage, $userLanguage);
        
        if($apiValidated and $dataValidated){
            $dataResponse = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($dataResponse){
                
                $editData = array('user_language'=>$this->input->post('user_language'));
        	    $result = $this->JsonModel->editData('user_key = '.$userKey, BA_USERS, $editData);
        	    
        	    if($result){
        	        $userResponse = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
                    $userData['user_key'] = $userResponse->user_key;
        			$userData['user_language'] = $userResponse->user_language;
        			$userData['message'] = $userResponse->user_status;
        	    } else {
        	        $responseData['message'] = "error";
        	    }
        	    
        		$responseData['user'] = $userData;
        		
            } else {
                $responseData['message'] = "permission denied";
            }
            
        } else {
    		$responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "viewBusinessCategory" function is changed in routes.php as "view-business-category"
    public function viewBusinessCategory_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $response['data'] = array();
        $responseData = array();
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $categoryID = 2;
        
        if($apiValidated){
            $responseData = $this->JsonModel->viewData('root_category_id = '.$categoryID, null, MAIN_CATEGORY_TABLE);
            if($responseData){
                $response['data'] = $responseData;
            } else {
                $response['message'] = "empty";
            }
        } else {
    		$response['message'] = "permission denied";
        }
        
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "newBusinessData" function is changed in routes.php as "new-business-data"
    public function newBusinessData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $response['data'] = array();
        $responseData['primary'] = array();
        $responseData['business'] = array();
        $primaryData = array();
        $businessData = array();
        
        $userKey = $this->input->post('user_key');
        $businessCategory = $this->input->post('business_category');
        $businessName = $this->input->post('business_name');
        $businessMobile = $this->input->post('business_mobile');
        $businessEmail = $this->input->post('business_email');
        $businessWebsite = $this->input->post('business_website');
        $businessAddress = $this->input->post('business_address');
        $businessLogo = $this->input->post('business_logo');
        $businessContent = $this->input->post('business_content');
        
        if($businessEmail == null){
            $businessEmail = "";
        }
        if($businessWebsite == null){
            $businessWebsite = "";
        }
        if($businessAddress == null){
            $businessAddress = "";
        }

        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $businessCategory, $businessName, $businessMobile, $businessLogo, $businessContent);
        
        if($apiValidated and $dataValidated){
            $userData = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($userData){
                $businessLimit = $userData->user_business_limit;
                $primaryBusinessKey = $userData->user_primary_business;
                if($businessLimit < 3){
                    $businessKey = $this->uniqueKey();
                    $newBusinessLimit = $businessLimit + 1;
                    
                    $objectName = "IMG-".date('dmYhis').".png";
            	    $objectTemp = base64_decode($businessLogo);
            	    $objectPath = LOGO_PATH;
                    $userLogo = $this->newBucketObject($objectName, $objectTemp, $objectPath);
                    
                    $newData = array(
                        'user_key'=>$userKey,
                        'business_key'=>$businessKey,
            	        'business_category'=>$businessCategory,
            	        
            	        'business_name'=>$businessName,
            	        'business_mobile'=>$businessMobile,
            	        'business_email'=>$businessEmail,
            	        'business_website'=>$businessWebsite,
            	        'business_address'=>$businessAddress,
            	        'business_logo'=>$userLogo,
            	        'business_content'=>$businessContent,
            	        
            	        'business_type'=>"free",
            	        'business_plan'=>"Free",
            	        'business_language'=>"en",
            	        'business_city'=>"Surat",
            	        'business_state'=>"Gujrat",
            	        'business_country'=>"IN",
            	        'business_edit_limit'=>"15",
            	        
            	        'business_create_time'=>date('d/m/Y h:i:s A'),
            	        'business_premium_time'=>"",
            	        'business_status'=>"active",
            		);
            		$checkBusinessData = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
            		if($checkBusinessData){
            		    $primaryData['message'] = $this->errorCode(404);
            		} else {
            		    $newResult = $this->JsonModel->insertData(BA_BUSINESS, $newData);
            		}
            		
            		if($newResult){
            		    $newLimitData = array(
                            'business_key'=>$businessKey,
                	        'festival_image_limit'=>$this->freeFestivalImageLimit,
                	        'festival_video_limit'=>$this->freeFestivalVideoLimit,
                	        'regular_image_limit'=>$this->freeRegularImageLimit,
                	        'regular_video_limit'=>$this->freeRegularVideoLimit,
                	        'business_image_limit'=>$this->freeBusinessImageLimit,
                	        'business_video_limit'=>$this->freeBusinessVideoLimit,
                	        'story_image_limit'=>$this->freeStoryImageLimit,
                	        'story_video_limit'=>$this->freeStoryVideoLimit,
                	        
                	        'used_festival_image_limit'=> $this->freeFestivalImageLimit,
                	        'used_festival_video_limit'=> $this->freeFestivalVideoLimit,
                	        'used_regular_image_limit'=> $this->freeRegularImageLimit,
                	        'used_regular_video_limit'=> $this->freeRegularVideoLimit,
                	        'used_business_image_limit'=> $this->freeBusinessImageLimit,
                	        'used_business_video_limit'=> $this->freeBusinessVideoLimit,
                	        'used_story_image_limit'=> $this->freeStoryImageLimit,
                	        'used_story_video_limit'=> $this->freeStoryVideoLimit,

                	        'limit_status'=>"publish",
                		);
                		$newLimitResult = $this->JsonModel->insertData(THEME_DOWNLOAD_LIMIT_TABLE, $newLimitData);
                		
                		$checkPrimaryBusinessData = $this->JsonModel->getData('business_key = '.$primaryBusinessKey, null, BA_BUSINESS);
            		    if($businessLimit == 0 or $checkPrimaryBusinessData->business_status == "blocked"){
            		        $primaryBusiness = $businessKey;
            		        $editData = array(
            	                'user_primary_business'=>$businessKey,
            	                'user_business_limit'=>$newBusinessLimit,
                    		);
                    	    $editResult = $this->JsonModel->editData('user_key = '.$userKey, BA_USERS, $editData);
            		    } else {
            		        $primaryBusiness = $userData->user_primary_business;
            		        $editData = array(
        	                    'user_business_limit'=>$newBusinessLimit,
                    		);
                    	    $editResult = $this->JsonModel->editData('user_key = '.$userKey, BA_USERS, $editData);
            		    }

            		    if($editResult){
                	        $primaryResponse = $this->JsonModel->getData('business_key = '.$primaryBusiness, null, BA_BUSINESS);
                	        $userData = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
                    	    $primaryData = $this->primaryBusinessData($primaryResponse);
                    	    
                    	    $businessResponse = $this->JsonModel->viewData('user_key = '.$userKey, null, BA_BUSINESS);
                    	    $businessData = $this->regularBusinessData($businessResponse, $primaryBusiness);
                
                	    } else {
                	        $primaryData['message'] = $this->errorCode(404);
                	    }

            	    } else {
            	        $primaryData['message'] = $this->errorCode(404);
            	    }
                } else {
                   $primaryData['message'] = $this->errorCode(105); 
                }
            } else {
                $primaryData['message'] = $this->errorCode(500);
            }
        } else {
            $primaryData['message'] = $this->errorCode(500);
        }
        $responseData['user'] = $userData;
        $responseData['primary'] = $primaryData;
        $responseData['business'] = $businessData;
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "editBusinessData" function is changed in routes.php as "edit-business-data"
    public function editBusinessData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $response['data'] = array();
        $responseData['primary'] = array();
        $responseData['business'] = array();
        $primaryData = array();
        $businessData = array();
        
        $userKey = $this->input->post('user_key');
        $businessKey = $this->input->post('business_key');
        $businessName = $this->input->post('business_name');
        $businessMobile = $this->input->post('business_mobile');
        $businessEmail = $this->input->post('business_email');
        $businessWebsite = $this->input->post('business_website');
        $businessAddress = $this->input->post('business_address');
        $businessLogo = $this->input->post('business_logo');
        $businessContent = $this->input->post('business_content');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($businessKey, $businessName, $businessMobile, $userKey, $userKey, $userKey);
        
        if($apiValidated and $dataValidated){
            $userData = $this->JsonModel->getData('user_key = '.$userKey, 'user_primary_business = '.$businessKey, BA_USERS);
            if($userData){
                $businessData = $this->JsonModel->getData('user_key = '.$userKey, 'business_key = '.$businessKey, BA_BUSINESS);
                if($businessData){
                    $businessID = $businessData->business_id;
                    $businessImage = $businessData->business_logo;
                    $businessEditLimit = $businessData->business_edit_limit;
                    
                    if($businessEditLimit > 0 ){
                        $newBusinessEditLimit = $businessData->business_edit_limit - 1;
                        if($businessName == null){ $businessName = $businessData->business_name; }
                        if($businessMobile == null){ $businessMobile = $businessData->business_mobile; }
                        if($businessContent == null){ $businessContent = $businessData->business_content; }
                        
                        if($businessLogo == null){
                            $userBusinessLogo = $businessData->business_logo;
                        } else if(str_contains($businessLogo, 'aws-brand-bucket')){
                            $userBusinessLogo = $businessData->business_logo;
                        } else {
                            if(!empty($businessImage)){
                                $newImageKey = basename($businessImage);
                                $s3Client = $this->getconfig();
                        		$deleteResult = $s3Client->deleteObject([
                                    'Bucket' => BUCKET_NAME,
                                    'Key'    => LOGO_PATH.$newImageKey,
                                ]);
                            }
                            $objectName = "IMG-".date('dmYhis').".png";
                    	    $objectTemp = base64_decode($businessLogo);
                    	    $objectPath = LOGO_PATH;
                            $userBusinessLogo = $this->newBucketObject($objectName, $objectTemp, $objectPath);
                        }
                        
                        $editData = array(
            	            'business_name'=>$businessName,
            	            'business_mobile'=>$businessMobile,
                	        'business_email'=>$businessEmail,
                	        'business_website'=>$businessWebsite,
                	        'business_address'=>$businessAddress, 
                	        'business_logo'=>$userBusinessLogo,
                	        'business_content'=>$businessContent,
                	        'business_edit_limit'=>$newBusinessEditLimit,
                		);
             
                	    $editResult = $this->JsonModel->editData('business_id = '.$businessID, BA_BUSINESS, $editData);
                	    if($editResult){
                            $primaryResponse = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
                    	    $primaryData = $this->primaryBusinessData($primaryResponse);
                    	    
                    	    $businessResponse = $this->JsonModel->viewData('user_key = '.$userKey, null, BA_BUSINESS);
                    	    $businessData = $this->regularBusinessData($businessResponse, $businessKey);
                    	    
                	    } else {
                	        $primaryData['message'] = "error";
                	    }
                    } else {
                        $primaryData['message'] = $this->errorCode(104);
                    }
    
                } else {
                    $primaryData['message'] = "permission denied!";
                }
            } else {
                $primaryData['message'] = "permission denied!!";
            }
            
        } else {
            $primaryData['message'] = "permission denied!!!";
        }
        
        $responseData['primary'] = $primaryData;
        $responseData['business'] = $businessData;
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "selectPrimaryBusiness" function is changed in routes.php as "select-primary-business"
    public function selectPrimaryBusiness_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $response['data'] = array();
        $responseData['primary'] = array();
        $responseData['business'] = array();
        $primaryData = array();
        $businessData = array();
        
        $userKey = $this->input->post('user_key');
        $businessKey = $this->input->post('business_key');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $businessKey, $businessKey, $businessKey, $businessKey, $businessKey);

        if($apiValidated and $dataValidated){
            $businessData = $this->JsonModel->getData('user_key = '.$userKey, 'business_key = '.$businessKey, BA_BUSINESS);
            if($businessData){
                if($businessData->business_status == "active"){
                    $editData = array(
    	                'user_primary_business'=>$businessKey,
            		);
            	    $editResult = $this->JsonModel->editData('user_key = '.$userKey, BA_USERS, $editData);
            	    if($editResult){
                	    $primaryResponse = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
                	    $primaryData = $this->primaryBusinessData($primaryResponse);
                	    
                	    $businessResponse = $this->JsonModel->viewData('user_key = '.$userKey, null, BA_BUSINESS);
                	    $businessData = $this->regularBusinessData($businessResponse, $businessKey);
                        
                        $responseData['primary'] = $primaryData;
                        $responseData['business'] = $businessData;
            	    }
                } else {
                    $responseData['message'] = "blocked";
                }
            } else {
                $responseData['message'] = "empty";
            }
        } else {
    		$responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "changeBusinessCategory" function is changed in routes.php as "change-business-category"
    public function changeBusinessCategory_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $response['data'] = array();
        $responseData['primary'] = array();
        $responseData['business'] = array();
        $primaryData = array();
        
        $userKey = $this->input->post('user_key');
        $businessKey = $this->input->post('business_key');
        $businessCategory = $this->input->post('business_category');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $businessKey, $businessCategory, $businessKey, $businessKey, $businessKey);

        if($apiValidated and $dataValidated){
            $businessData = $this->JsonModel->getData('user_key = '.$userKey, 'business_key = '.$businessKey, BA_BUSINESS);
            if($businessData){
                if($businessData->business_status == "active"){
                    $editData = array(
    	                'business_category'=>$businessCategory,
            		);
            	    $editResult = $this->JsonModel->editData('business_key = '.$businessKey, BA_BUSINESS, $editData);
            	    if($editResult){
                	    $primaryResponse = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
                	    $primaryData = $this->primaryBusinessData($primaryResponse);
                	    
                	    $businessResponse = $this->JsonModel->viewData('user_key = '.$userKey, null, BA_BUSINESS);
                	    $businessData = $this->regularBusinessData($businessResponse, $businessKey);
                        
                        $responseData['primary'] = $primaryData;
                        $responseData['business'] = $businessData;
            	    }
                } else {
                    $responseData['message'] = "blocked";
                }
            } else {
                $responseData['message'] = "empty";
            }
        } else {
    		$responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "applyCouponCode" function is changed in routes.php as "apply-coupon-code"
    public function applyCouponCode_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
        $response['data'] = array();
        $responseData['discount'] = array();

        $userKey = $this->input->post('user_key');
        $couponCode = $this->input->post('coupon_code');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $couponCode, $couponCode, $couponCode, $couponCode, $couponCode);

        if($apiValidated and $dataValidated){
            $userData = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($userData){
                if($userData->user_status == "active"){
                    $couponData = $this->JsonModel->getCoupon($couponCode, COUPON_TABLE);
                    if($couponData){
                        $newData = array(
                            'user_key'=>$userKey,
                            'discount_type'=>$couponData->coupon_type,
            	            'discount_mrp'=>$couponData->coupon_mrp,
            	            'discount_price'=>$couponData->coupon_price,
                	        'discount_percentage'=>$couponData->coupon_discount,
                	        'discount_sku'=>$couponData->coupon_sku,
                	        'discount_image'=>$couponData->coupon_image,
                	        'discount_source'=>$couponData->coupon_code,
                	        'discount_date'=>date('d/m/Y h:i:s A'),
                	        'discount_status'=>"active",
                		);
                        $newResult = $this->JsonModel->insertData(BA_DISCOUNT, $newData);
                        if($newResult){
                            $discountResponse = $this->JsonModel->getData('user_key = '.$userKey, null, BA_DISCOUNT);
                    	    $discountData = $this->userDiscountData($discountResponse);
                    	    
                    	    if($discountData){
                    	        $responseData['discount'] = $discountData;
                    	    }
                            $responseData['message'] = "success";
                        } else {
                            $responseData['message'] = "error";
                        }
                    } else {
                        $responseData['message'] = "error";
                    }
                } else {
                    $responseData['message'] = "blocked";
                }
            } else {
                $responseData['message'] = "empty";
            }
        } else {
    		$responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "purchaseResultData" function is changed in routes.php as "purchase-result-data"
    public function purchaseResultData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
        $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $userKey = $this->input->post('user_key');
        $businessKey = $this->input->post('business_key');
        $purchasePlan = $this->input->post('purchase_plan');
        $purchaseSKU = $this->input->post('purchase_sku');
        $purchaseStatus = $this->input->post('purchase_status');
        
        if(!empty($purchasePlan)){
            $dataResponse = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
            if($dataResponse){
                $uniqueCode = $this->uniqueKey();
                $newData = array(
        	        'user_key'=>$userKey,
        	        'business_key'=>$businessKey,
        	        'purchase_key'=>$uniqueCode,
        	        'purchase_plan'=>$purchasePlan,
        	        'purchase_sku'=>$purchaseSKU,
        	        'purchase_time'=>date('d/m/Y h:i:s A'),
        	        'purchase_status'=>$purchaseStatus,
        	        
        		);
        		$result = $this->JsonModel->insertData(PURCHASE_STATUS_TABLE, $newData);
        		
        		if($purchaseStatus == "succeed"){
        		    $newBusinessData = array(
            	        'business_plan'=>$purchasePlan,
            	        'business_type'=>'premium',
            	        'business_premium_time'=>date('d/m/Y h:i:s A')
            		);
            		
            		$result = $this->JsonModel->editData('business_key = '.$businessKey, BA_BUSINESS, $newBusinessData);
            		if($result){
            	        $responseData['message'] = $this->subscribedBusiness_WPRLAQJF_89564595_QOELDASG_86546514($businessKey, $purchasePlan);
            	    } else {
            	        $responseData['message'] = "denied";
            	    }
        		} else {
        		    if($result){
            	        $responseData['message'] = "cancelled";
            	    } else {
            	        $responseData['message'] = "denied";
            	    }
        		}

            } else {
                $responseData['message'] = "error";
            }
        } else {
            $responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    public function subscribedBusiness_WPRLAQJF_89564595_QOELDASG_86546514($businessKey, $purchasePlan){
        date_default_timezone_set("Asia/Kolkata");
        $response['data'] = array();
        if(!empty($businessKey)){
            $businessData = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
            if($businessData){
        	    if($purchasePlan == "Yearly"){
                    $festivalImageLimit = $this->yearlyFestivalImageLimit;
            		$festivalVideoLimit = $this->yearlyFestivalVideoLimit;
            		$regularImageLimit = $this->yearlyRegularImageLimit;
            		$regularVideoLimit = $this->yearlyRegularVideoLimit;
            		$businessImageLimit = $this->yearlyBusinessImageLimit;
            		$businessVideoLimit = $this->yearlyBusinessVideoLimit;
            		$storyImageLimit = $this->yearlyStoryImageLimit;
            		$storyVideoLimit = $this->yearlyStoryVideoLimit;
            		
                } else if($purchasePlan == "Monthly"){
                    $festivalImageLimit = $this->monthlyFestivalImageLimit;
            		$festivalVideoLimit = $this->monthlyFestivalVideoLimit;
            		$regularImageLimit = $this->monthlyRegularImageLimit;
            		$regularVideoLimit = $this->monthlyRegularVideoLimit;
            		$businessImageLimit = $this->monthlyBusinessImageLimit;
            		$businessVideoLimit = $this->monthlyBusinessVideoLimit;
            		$storyImageLimit = $this->monthlyStoryImageLimit;
            		$storyVideoLimit = $this->monthlyStoryVideoLimit;
            		
                } else if($purchasePlan == "Free"){
                    $festivalImageLimit = $this->freeFestivalImageLimit;
            		$festivalVideoLimit = $this->freeFestivalVideoLimit;
            		$regularImageLimit = $this->freeRegularImageLimit;
            		$regularVideoLimit = $this->freeRegularVideoLimit;
            		$businessImageLimit = $this->freeBusinessImageLimit;
            		$businessVideoLimit = $this->freeBusinessVideoLimit;
            		$storyImageLimit = $this->freeStoryImageLimit;
            		$storyVideoLimit = $this->freeStoryVideoLimit;
                }

        	    $editLimitData = array(
    	            'festival_image_limit'=>$festivalImageLimit,
        	        'festival_video_limit'=>$festivalVideoLimit,
        	        'regular_image_limit'=>$regularImageLimit,
        	        'regular_video_limit'=>$regularVideoLimit,
        	        'business_image_limit'=>$businessImageLimit,
        	        'business_video_limit'=>$businessVideoLimit,
        	        'story_image_limit'=>$storyImageLimit,
        	        'story_video_limit'=>$storyVideoLimit,
        	        'used_festival_image_limit'=>$festivalImageLimit,
        	        'used_festival_video_limit'=>$festivalVideoLimit,
        	        'used_regular_image_limit'=>$regularImageLimit,
        	        'used_regular_video_limit'=>$regularVideoLimit,
        	        'used_business_image_limit'=>$businessImageLimit,
        	        'used_business_video_limit'=>$businessVideoLimit,
        	        'used_story_image_limit'=>$storyImageLimit,
        	        'used_story_video_limit'=>$storyVideoLimit,
        		);
        		
        	    $editLimitResult = $this->JsonModel->editData('business_key = '.$businessKey, THEME_DOWNLOAD_LIMIT_TABLE, $editLimitData);
        	    
        	    if($editLimitResult){
        	        return "success";
        	    } else {
        	        return "denied";
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
    // Note : "regularThemeData" function is changed in routes.php as "regular-theme-data"
    public function regularThemeData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
        $todayDate = date('Ymd');
        $nextDate = date('Ymd', strtotime(' +1 day'));
        
        $apiAuth = $this->input->post('api_auth');
        $themeStatus = $this->input->post('theme_status');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($themeStatus, $themeStatus, $themeStatus, $themeStatus, $themeStatus, $themeStatus);
        
    	$response = array();
	    $response['data'] = array();
	    
	    $rootCategory = 1;
	    $mainCategory = $this->JsonModel->viewData('root_category_id = '.$rootCategory, null, MAIN_CATEGORY_TABLE);

	    if($apiValidated and $dataValidated){
	        if($mainCategory != null){
            	$mainCategoryData=array();
    	        foreach ($mainCategory as $mainCategoryRow){
    		    	$mainCategoryPosition = $mainCategoryRow->main_category_position;
    		    	if($mainCategoryPosition == 0){
    		    	    $subCategory = $this->JsonModel->getFestivalData($mainCategoryRow->main_category_id, $todayDate, $nextDate, SUB_CATEGORY_TABLE);
    		    	    $themeType = "festival";
    		    	} else {
    		    	    $subCategory = $this->JsonModel->getSubCategoryData($mainCategoryRow->main_category_id, null, SUB_CATEGORY_TABLE);
    		    	    $themeType = "regular";
    		    	}
    
        			$mainCategoryData['category']=array();
        			foreach ($subCategory as $subCategoryRow){
        			    $category['sub_category_id'] = (int)$subCategoryRow->sub_category_id;
        			    $category['main_category_id'] = (int)$subCategoryRow->main_category_id;
        			    if($mainCategoryPosition == 0){
        		    	    $category['sub_category_name'] = $subCategoryRow->sub_category_date.' / '.$subCategoryRow->sub_category_name;
        		    	} else {
        		    	    $category['sub_category_name'] = $subCategoryRow->sub_category_name;
        		    	}
    		    	    $category['sub_category_icon'] = $subCategoryRow->sub_category_icon;
    		    	
    		    	    $whereArray = array('theme_status' => $themeStatus, 'sub_category_id' => $subCategoryRow->sub_category_id);    
            			$theme = $this->JsonModel->getThemeData(THEME_POST_TABLE, 100, $whereArray);
            			$category['themes'] = array();
            			
            			foreach($theme as $themeRow){
        					$themeData=array();
        					$themeData['theme_id'] = (int)$themeRow->theme_id;
        					$themeData['sub_category_id'] = (int)$themeRow->sub_category_id;
        					$themeData['theme_name'] = $themeRow->theme_name;
        					$themeData['theme_thumbnail'] = $themeRow->theme_thumbnail;
        					$themeData['theme_extra_text'] = $themeRow->theme_extra_text ;
        					$themeData['theme_extra_image'] = $themeRow->theme_extra_image;
        					$themeData['theme_bundle'] = $themeRow->theme_bundle;
        					$themeData['is_extra_text'] = $themeRow->is_extra_text;
        					$themeData['is_extra_image'] = $themeRow->is_extra_image;
        					$themeData['theme_dimension'] = $themeRow->theme_dimension;
        					$themeData['theme_footer'] = $themeRow->theme_footer;
        					$themeData['is_animated'] = $themeRow->is_animated;
        					$themeData['is_music'] = $themeRow->is_music;
        					$themeData['is_new'] = $themeRow->is_new;
        					$themeData['is_premium'] = $themeRow->is_premium;
        					
        					if($themeType == "festival" && $themeData['is_animated'] == "true"){
        					    $themeData['theme_type'] = "festival-video";
        					}else if ($themeType == "festival" && $themeData['is_animated'] == "false"){
        					    $themeData['theme_type'] = "festival-image";
        					}else if($themeType == "regular" && $themeData['is_animated'] == "true"){
        					    $themeData['theme_type'] = "regular-video";
        					}else if($themeType == "regular" && $themeData['is_animated'] == "false"){
        					    $themeData['theme_type'] = "regular-image";
        					}
        					
        					array_push($category['themes'],$themeData);
            			}
            			if($category['themes'] != null){
            			    array_push($response['data'],$category);
            			}
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
    // Note : "customThemeData" function is changed in routes.php as "custom-theme-data"
    public function customThemeData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
        $todayDate = date('Ymd');
        $nextDate = date('Ymd', strtotime(' +1 day'));
        
        $apiAuth = $this->input->post('api_auth');
        $themeStatus = $this->input->post('theme_status');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($themeStatus, $themeStatus, $themeStatus, $themeStatus, $themeStatus, $themeStatus);
        
    	$response = array();
	    $response['data'] = array();
	    
	    $rootCategory = 3;
	    $mainCategory = $this->JsonModel->viewData('root_category_id = '.$rootCategory, null, MAIN_CATEGORY_TABLE);

	    if($apiValidated and $dataValidated){
	        if($mainCategory != null){
            	$mainCategoryData=array();
    	        foreach ($mainCategory as $mainCategoryRow){
    		    	$mainCategoryPosition = $mainCategoryRow->main_category_position;
    		    	if($mainCategoryPosition == 0){
    		    	    $subCategory = $this->JsonModel->getFestivalData($mainCategoryRow->main_category_id, $todayDate, $nextDate, SUB_CATEGORY_TABLE);
    		    	} else {
    		    	    $subCategory = $this->JsonModel->getSubCategoryData($mainCategoryRow->main_category_id, null, SUB_CATEGORY_TABLE);
    		    	}
    
        			$mainCategoryData['category']=array();
        			foreach ($subCategory as $subCategoryRow){
        			    $category['sub_category_id'] = (int)$subCategoryRow->sub_category_id;
        			    $category['main_category_id'] = (int)$subCategoryRow->main_category_id;
    		    	    $category['sub_category_name'] = $subCategoryRow->sub_category_name;
    		    	    $category['sub_category_icon'] = $subCategoryRow->sub_category_icon;
    		    	
    		    	    $whereArray = array('theme_status' => $themeStatus, 'sub_category_id' => $subCategoryRow->sub_category_id);    
            			$theme = $this->JsonModel->getThemeData(THEME_POST_TABLE, 100, $whereArray);
            			$category['themes'] = array();
            			
            			foreach($theme as $themeRow){
        					$themeData=array();
        					$themeData['theme_id'] = (int)$themeRow->theme_id;
        					$themeData['sub_category_id'] = (int)$themeRow->sub_category_id;
        					$themeData['theme_name'] = $themeRow->theme_name;
        					$themeData['theme_thumbnail'] = $themeRow->theme_thumbnail;
        					$themeData['theme_extra_text'] = $themeRow->theme_extra_text ;
        					$themeData['theme_extra_image'] = $themeRow->theme_extra_image;
        					$themeData['theme_bundle'] = $themeRow->theme_bundle;
        					$themeData['is_extra_text'] = $themeRow->is_extra_text;
        					$themeData['is_extra_image'] = $themeRow->is_extra_image;
        					$themeData['theme_dimension'] = $themeRow->theme_dimension;
        					$themeData['theme_footer'] = $themeRow->theme_footer;
        					$themeData['is_animated'] = $themeRow->is_animated;
        					$themeData['is_music'] = $themeRow->is_music;
        					$themeData['is_new'] = $themeRow->is_new;
        					$themeData['is_premium'] = $themeRow->is_premium;
        					
        					if($themeData['is_animated'] == "true"){
        					    $themeData['theme_type'] = "regular-video";
        					}else{
        					    $themeData['theme_type'] = "regular-image";
        					}
        					
        					array_push($category['themes'],$themeData);
            			}
            			
            			if($category['themes'] != null){
            			    array_push($response['data'],$category);
            			}
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
    // Note : "businessThemeData" function is changed in routes.php as "business-theme-data"
    public function businessThemeData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
        $todayDate = date('Ymd');
        $nextDate = date('Ymd', strtotime(' +1 day'));
        
        $apiAuth = $this->input->post('api_auth');
        $businessKey = $this->input->post('business_key');
        $themeStatus = $this->input->post('theme_status');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($themeStatus, $businessKey, $themeStatus, $themeStatus, $themeStatus, $themeStatus);
        
    	$response = array();
	    $response['data'] = array();

	    if($apiValidated and $dataValidated){
	        $businessResponse = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
	        $businessCategory = $businessResponse->business_category;
	        
	        if($businessCategory == 6){
	            $subCategory = $this->JsonModel->getBusinessThemeData(5, SUB_CATEGORY_TABLE);
	        } else {
	            $subCategory = $this->JsonModel->getBusinessThemeData($businessCategory, SUB_CATEGORY_TABLE);
	        }
	        
	        if(!empty($subCategory)){
    	        foreach ($subCategory as $subCategoryRow){
    			    $category['sub_category_id'] = (int)$subCategoryRow->sub_category_id;
    			    $category['main_category_id'] = (int)$subCategoryRow->main_category_id;
		    	    $category['sub_category_name'] = $subCategoryRow->sub_category_name;
		    	    $category['sub_category_icon'] = $subCategoryRow->sub_category_icon;

		    	    $whereArray = array('theme_status' => $themeStatus, 'sub_category_id' => $subCategoryRow->sub_category_id);    
        			$theme = $this->JsonModel->getThemeData(THEME_POST_TABLE, 100, $whereArray);
        			$category['themes'] = array();
        			
        			foreach($theme as $themeRow){
    					$themeData = array();
    					$themeData['theme_id'] = (int)$themeRow->theme_id;
    					$themeData['sub_category_id'] = (int)$themeRow->sub_category_id;
    					$themeData['theme_name'] = $themeRow->theme_name;
    					$themeData['theme_thumbnail'] = $themeRow->theme_thumbnail;
    					$themeData['theme_extra_text'] = $themeRow->theme_extra_text ;
    					$themeData['theme_extra_image'] = $themeRow->theme_extra_image;
    					$themeData['theme_bundle'] = $themeRow->theme_bundle;
    					$themeData['is_extra_text'] = $themeRow->is_extra_text;
    					$themeData['is_extra_image'] = $themeRow->is_extra_image;
    					$themeData['theme_dimension'] = $themeRow->theme_dimension;
    					$themeData['theme_footer'] = $themeRow->theme_footer;
    					$themeData['is_animated'] = $themeRow->is_animated;
    					$themeData['is_music'] = $themeRow->is_music;
    					$themeData['is_new'] = $themeRow->is_new;
    					$themeData['is_premium'] = $themeRow->is_premium;
    					
    					if($themeData['is_animated'] == "true"){
    					    $themeData['theme_type'] = "business-video";
    					} else {
    					    $themeData['theme_type'] = "business-image";
    					}
    					array_push($category['themes'],$themeData);
        			}
        			
        			if($category['themes'] != null){
        			    array_push($response['data'],$category);
        			} else {
        			    $response['message'] = "permission deniedaaaa";
        			}
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
    // Note : "storyThemeData" function is changed in routes.php as "story-theme-data"
    public function storyThemeData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
        $todayDate = date('Ymd');
        $nextDate = date('Ymd', strtotime(' +1 day'));
        
        $apiAuth = $this->input->post('api_auth');
        $businessKey = $this->input->post('business_key');
        $themeStatus = $this->input->post('theme_status');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($themeStatus, $businessKey, $themeStatus, $themeStatus, $themeStatus, $themeStatus);
        
    	$response = array();
	    $response['stories'] = array();

        $businessResponse = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
	    $businessCategory = $businessResponse->business_category;
    		    	
	    if($businessCategory == 6){
            $subCategory = $this->JsonModel->getBusinessStoryData(5, SUB_CATEGORY_TABLE);
        } else {
            $festivalCategory = $this->JsonModel->getFestivalStoryData(1, $todayDate, $nextDate, SUB_CATEGORY_TABLE);
            $businessCategory = $this->JsonModel->getBusinessStoryData($businessCategory, SUB_CATEGORY_TABLE);
            if(!empty($festivalCategory) and !empty($businessCategory)){
                $subCategory = array_merge($festivalCategory, $businessCategory);
            } else {
                $subCategory = $businessCategory;
            }
        }
        
	    if($apiValidated and $dataValidated){
	        if(!empty($subCategory)){
	            foreach ($subCategory as $subCategoryRow){
        	        $whereArray = array('theme_status' => $themeStatus, 'sub_category_id' => $subCategoryRow->sub_category_id);    
        			$theme = $this->JsonModel->getThemeData(THEME_STORY_TABLE, 100, $whereArray);
        			$category['stories'] = array();
        			
        			foreach($theme as $themeRow){
    					$themeData = array();
    					$themeData['theme_id'] = (int)$themeRow->theme_id;
    					$themeData['sub_category_id'] = (int)$themeRow->sub_category_id;
    					$themeData['theme_name'] = $themeRow->theme_name;
    					$themeData['theme_thumbnail'] = $themeRow->theme_thumbnail;
    					$themeData['theme_extra_text'] = $themeRow->theme_extra_text ;
    					$themeData['theme_extra_image'] = $themeRow->theme_extra_image;
    					$themeData['theme_bundle'] = $themeRow->theme_bundle;
    					$themeData['is_extra_text'] = $themeRow->is_extra_text;
    					$themeData['is_extra_image'] = $themeRow->is_extra_image;
    					$themeData['theme_dimension'] = $themeRow->theme_dimension;
    					$themeData['theme_footer'] = $themeRow->theme_footer;
    					$themeData['is_animated'] = $themeRow->is_animated;
    					$themeData['is_music'] = $themeRow->is_music;
    					$themeData['is_new'] = $themeRow->is_new;
    					$themeData['is_premium'] = $themeRow->is_premium;
    					
    					if($themeData['is_animated'] == "true"){
    					    $themeData['theme_type'] = "story-video";
    					} else {
    					    $themeData['theme_type'] = "story-image";
    					}
    					array_push($response['stories'],$themeData);
        			}
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
    // Note : "themeDownloadData" function is changed in routes.php as "theme-download-data"
    public function themeDownloadData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $response = array();
	    $response['data'] = array();
	    
        $apiAuth = $this->input->post('api_auth');
        $userKey = $this->input->post('user_key');
        $businessKey = $this->input->post('business_key');
        $themeID = $this->input->post('theme_id');
        $themeType = $this->input->post('theme_type');
        
        date_default_timezone_set("Asia/Kolkata");
        $todayDate = date('d-M-Y');
        $explodeDate = (explode("-",$todayDate));
        $newDate = $explodeDate['0'];
        $newMonth = $explodeDate['1'];
        $newYear = $explodeDate['2'];
        $userDate = "date_".''.$newDate;
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $themeID, $userKey, $userKey, $userKey, $userKey);
        
        if($apiValidated and $dataValidated){
            $userResponse = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($userResponse){
                
                $userKeyData = $this->JsonModel->getData('user_key = '.$userKey, null, THEME_DOWNLOAD_INSIGHT_TABLE);
                if($userKeyData){
                    $userYearData = $this->JsonModel->viewDownloadYear('user_key = '.$userKey, $newYear, THEME_DOWNLOAD_INSIGHT_TABLE);
                    if($userYearData){
                        $userMonthData = $this->JsonModel->viewDownloadMonth('user_key = '.$userKey, $newYear, $newMonth, THEME_DOWNLOAD_INSIGHT_TABLE);
                        if($userMonthData){
                            $jsonArray = array($userDate=>$userMonthData->$userDate);
                            if($jsonArray){
                                array_push($jsonArray,$themeID);
                    	    
                                $jsonString = implode(',', $jsonArray);
                    			$editData = array(
                            		$userDate=>$jsonString,
                    			);
                    			$editResult = $this->JsonModel->editData('user_key = '.$userKey, THEME_DOWNLOAD_INSIGHT_TABLE, $editData); 
                            } else {
                    			$editData = array(
                            		$userDate=>$themeID,
                    			);
                    			$editResult = $this->JsonModel->editData('user_key = '.$userKey, THEME_DOWNLOAD_INSIGHT_TABLE, $editData); 
                            }
                    	    
                        } else {
                            $newData = array(
                                'user_key'=>$userKey,
                                'user_year'=>$newYear,
                                'user_month'=>$newMonth,
                                $userDate=>$themeID
                    		);
                    		$newResult = $this->JsonModel->insertData(THEME_DOWNLOAD_INSIGHT_TABLE, $newData);
                        }
                    } else {
                        $newData = array(
                            'user_key'=>$userKey,
                            'user_year'=>$newYear,
                            'user_month'=>$newMonth,
                            $userDate=>$themeID
                		);
                		$newResult = $this->JsonModel->insertData(THEME_DOWNLOAD_INSIGHT_TABLE, $newData);
                    }       
                } else {
                    $newData = array(
                        'user_key'=>$userKey,
                        'user_year'=>$newYear,
                        'user_month'=>$newMonth,
                        $userDate=>$themeID
            		);
            		$newResult = $this->JsonModel->insertData(THEME_DOWNLOAD_INSIGHT_TABLE, $newData);
                }
                
                //$this->generateDiscount_DY86AR14_CL46SY71_AO45DL63_XY17SL53($userKey);
                $response['data'] = $this->setThemeDownload_WPRLAQJF_89564595_QOELDASG_86546514($apiAuth, $businessKey, $themeType);
                
            } else {
                $response['message'] = "error";
            } 
        } else {
            $response['message'] = "permission denied";
        }

	    echo json_encode($response);
    }
    public function setThemeDownload_WPRLAQJF_89564595_QOELDASG_86546514($apiAuth, $businessKey, $themeType){
        $apiAuth = $this->input->post('api_auth');
        $businessKey = $this->input->post('business_key');
        $themeType = $this->input->post('theme_type');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($businessKey, $themeType, $businessKey, $businessKey, $businessKey, $businessKey);
        
        if($apiValidated and $dataValidated){
            $businessResponse = $this->JsonModel->getData('business_key = '.$businessKey, null, BA_BUSINESS);
            if($businessResponse){
                $businessResponse = $this->JsonModel->getData('business_key = '.$businessKey, null, THEME_DOWNLOAD_LIMIT_TABLE);
                if($businessResponse != null){
                    if($themeType == 'festival-image'){
                        $festivalImageLimit = $businessResponse->used_festival_image_limit;
                        $newFestivalImageLimit = $festivalImageLimit - 1 ;
                        $editData = array('used_festival_image_limit' => $newFestivalImageLimit);
                        $editResult = $this->JsonModel->editData('business_key = '.$businessKey, THEME_DOWNLOAD_LIMIT_TABLE, $editData);
                    }
                    else if($themeType == 'festival-video'){
                        $festivalVideoLimit = $businessResponse->used_festival_video_limit;
                        $newFestivalVideoLimit = $festivalVideoLimit - 1 ;
                        $editData = array('used_festival_video_limit' => $newFestivalVideoLimit);
                        $editResult = $this->JsonModel->editData('business_key = '.$businessKey, THEME_DOWNLOAD_LIMIT_TABLE, $editData);
                    }
                    else if($themeType == 'regular-image'){
                        $regularImageLimit = $businessResponse->used_regular_image_limit;
                        $newRegularImageLimit = $regularImageLimit - 1 ;
                        $editData = array('used_regular_image_limit' => $newRegularImageLimit);
                        $editResult = $this->JsonModel->editData('business_key = '.$businessKey, THEME_DOWNLOAD_LIMIT_TABLE, $editData);
                    }
                    else if($themeType == 'regular-video'){
                        $regularVideoLimit = $businessResponse->used_regular_video_limit;
                        $newRegularVideoLimit = $regularVideoLimit - 1 ;
                        $editData = array('used_regular_video_limit' => $newRegularVideoLimit);
                        $editResult = $this->JsonModel->editData('business_key = '.$businessKey, THEME_DOWNLOAD_LIMIT_TABLE, $editData);
                    }
                    else if($themeType == 'business-image'){
                        $businessImageLimit = $businessResponse->used_business_image_limit;
                        $newBusinessImageLimit = $businessImageLimit - 1 ;
                        $editData = array('used_business_image_limit' => $newBusinessImageLimit);
                        $editResult = $this->JsonModel->editData('business_key = '.$businessKey, THEME_DOWNLOAD_LIMIT_TABLE, $editData);
                    }
                    else if($themeType == 'business-video'){
                        $businessVideoLimit = $businessResponse->used_business_video_limit;
                        $newBusinessVideoLimit = $businessVideoLimit - 1 ;
                        $editData = array('used_business_video_limit' => $newBusinessVideoLimit);
                        $editResult = $this->JsonModel->editData('business_key = '.$businessKey, THEME_DOWNLOAD_LIMIT_TABLE, $editData);
                    }
                    else if($themeType == 'story-image'){
                        $storyImageLimit = $businessResponse->used_story_image_limit;
                        $newStoryImageLimit = $storyImageLimit - 1 ;
                        $editData = array('used_story_image_limit' => $newStoryImageLimit);
                        $editResult = $this->JsonModel->editData('business_key = '.$businessKey, THEME_DOWNLOAD_LIMIT_TABLE, $editData);   
                    }
                    else if($themeType == 'story-video'){
                        $storyVideoLimit = $businessResponse->used_story_video_limit;
                        $newStoryVideoLimit = $storyVideoLimit - 1 ;
                        $editData = array('used_story_video_limit' => $newStoryVideoLimit);
                        $editResult = $this->JsonModel->editData('business_key = '.$businessKey, THEME_DOWNLOAD_LIMIT_TABLE, $editData);
                    }
                    $newThemeLimitData = $this->JsonModel->getData('business_key = '.$businessKey, null, THEME_DOWNLOAD_LIMIT_TABLE);
                    return $newThemeLimitData;
                }
            } else {
                $response['message'] = "error";
            } 
        } else {
            $response['message'] = "permission denied";
        }
    }
    public function generateDiscount_DY86AR14_CL46SY71_AO45DL63_XY17SL53($userKey){
        date_default_timezone_set("Asia/Kolkata");
        $couponCode = "WELC50";
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $couponCode, $couponCode, $couponCode, $couponCode, $couponCode);

        if($apiValidated and $dataValidated){
            $userData = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($userData){
                if($userData->user_status == "active"){
                    $couponData = $this->JsonModel->getCoupon($couponCode, COUPON_TABLE);
                    if($couponData){
                        $discountData = $this->JsonModel->getData('user_key = '.$userKey, null, BA_DISCOUNT);
                        if($discountData){
                            $editData = array(
                    	        'user_key'=>$userKey,
                    	        'discount_type'=>$couponData->coupon_type,
                    	        'discount_mrp'=>$couponData->coupon_mrp,
                    	        'discount_price'=>$couponData->coupon_price,
                    	        'discount_percentage'=>$couponData->coupon_discount,
                    	        'discount_sku'=>$couponData->coupon_sku,
                    	        'discount_image'=>$couponData->coupon_image,
                    	        'discount_source'=>$couponData->coupon_code,
                    	        'discount_date'=>date('d/m/Y h:i:s A'),
                    	        'discount_status'=>"active",
                    		);
                    		$editResult = $this->JsonModel->editData('user_key = '.$userKey, BA_DISCOUNT, $editData);
                        } else {
                            $newData = array(
                                'user_key'=>$userKey,
                                'discount_type'=>$couponData->coupon_type,
                	            'discount_mrp'=>$couponData->coupon_mrp,
                	            'discount_price'=>$couponData->coupon_price,
                    	        'discount_percentage'=>$couponData->coupon_discount,
                    	        'discount_sku'=>$couponData->coupon_sku,
                    	        'discount_image'=>$couponData->coupon_image,
                    	        'discount_source'=>$couponData->coupon_code,
                    	        'discount_date'=>date('d/m/Y h:i:s A'),
                    	        'discount_status'=>"active",
                    		);
                            $newResult = $this->JsonModel->insertData(BA_DISCOUNT, $newData);
                        }
                    } 
                } 
            } 
        } 
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "newContactData" function is changed in routes.php as "new-contact-data"
    public function newContactData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
	    $response['data'] = array();
        
        $apiAuth = $this->input->post('api_auth');
        $userKey = $this->input->post('user_key');
        $contactName = $this->input->post('contact_name');
        $contactEmail = $this->input->post('contact_email');
        $contactMessage = $this->input->post('contact_message');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $contactName, $contactEmail, $contactMessage, $userKey, $userKey);
        
        if($apiValidated and $dataValidated){
            $dataResponse = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($dataResponse){
                if($contactName != null and $contactEmail != null and $contactMessage != null){
                    $newData = array(
                        'user_key'=>$userKey,
            	        'contact_name'=>$this->input->post('contact_name'),
            	        'contact_email'=>$this->input->post('contact_email'),
            	        'contact_message'=>$this->input->post('contact_message'),
            	        'contact_time'=>date('d/m/Y h:i:s A')
            	    );
            	    $result = $this->JsonModel->insertData('ba_contact',$newData);
            	    if($result){
            	        $responseData['message'] = "success";
            	    } else {
            	        $responseData['message'] = "error";
            	    }
                } else {
                    $responseData['message'] = "permission denied";
                }
        		
            } else {
                $responseData['message'] = "permission denied";
            }
            
        } else {
    		$responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "newQuotationData" function is changed in routes.php as "new-quotation-data"
    public function newQuotationData_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
	    $response['data'] = array();
        
        $userKey = $this->input->post('user_key');
        $quotationType = $this->input->post('quotation_type');
        $quotationName = $this->input->post('quotation_name');
        $quotationMobile = $this->input->post('quotation_mobile');
        $quotationEmail = $this->input->post('quotation_email');
        $quotationBudget = $this->input->post('quotation_budget');
        $quotationCity = $this->input->post('quotation_city');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey,  $quotationType, $quotationName, $quotationMobile, $quotationBudget, $quotationName);
        
        if($apiValidated and $dataValidated){
            $dataResponse = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($dataResponse){
                $newData = array(
                    'user_key'=>$userKey,
                    'quotation_type'=>$this->input->post('quotation_type'),
        	        'quotation_name'=>$this->input->post('quotation_name'),
        	        'quotation_mobile'=>$this->input->post('quotation_mobile'),
        	        'quotation_email'=>$this->input->post('quotation_email'),
        	        'quotation_budget'=>$this->input->post('quotation_budget'),
        	        'quotation_city'=>$this->input->post('quotation_city'),
        	        'quotation_date'=>date('d/m/Y h:i:s A'),
        	        'quotation_status'=>"publish",
        	    );
        	    $result = $this->JsonModel->insertData(QUATATION_TABLE, $newData);
        	    if($result){
        	        $responseData['message'] = "success";
        	    } else {
        	        $responseData['message'] = "error";
        	    }
        		
            } else {
                $responseData['message'] = "permission denied";
            }
            
        } else {
    		$responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
     // Note : Please change this function name in "routes.php" before update it's name
    // Note : "supportOptionData" function is changed in routes.php as "view-support-option"
    public function viewSupportOption_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        $apiAuth = $this->input->post('api_auth');
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        
    	$response = array();
	    $response['data'] = array();

	    if($apiValidated){
	        $getSubject = $this->JsonModel->viewData(null, null, SUPPORT_SUBJECT_TABLE);
	        if($getSubject != null){
    	        foreach ($getSubject as $subRow){
    			    $subject['subject_id'] = (int)$subRow->subject_id;
    			    $subject['subject_name'] = $subRow->subject_name;
		    	    $subject['subject_icon'] = $subRow->subject_icon;
		    	
		    	    $issues = $this->JsonModel->viewData('subject_id = '.$subRow->subject_id, null, SUPPORT_ISSUES_TABLE);
        			$subject['issues'] = array();
        			
        			foreach($issues as $issuesRow){
    					$issuesData = array();
    					$issuesData['issues_id'] = (int)$issuesRow->issues_id;
    					$issuesData['subject_id'] = (int)$issuesRow->subject_id;
    					$issuesData['issues_name'] = $issuesRow->issues_name;
    					array_push($subject['issues'],$issuesData);
        			}
        			array_push($response['data'],$subject);
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
    // Note : "newSupportTicket" function is changed in routes.php as "new-support-ticket"
    public function newSupportTicket_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
        $response['data'] = array();

        $userKey = $this->input->post('user_key');
        $ticketIssues = $this->input->post('ticket_issues');
        $ticketDescription = $this->input->post('ticket_description');
        $ticketImage = $this->input->post('ticket_image');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $ticketIssues, $ticketIssues, $ticketIssues, $ticketIssues, $ticketIssues);

        if($apiValidated and $dataValidated){
            $userData = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($userData){
                $ticketData = $this->JsonModel->getData('user_key = '.$userKey, null, SUPPORT_TICKET_TABLE);
                if(empty($ticketData)) {
                    $newTicketData = array(
                        'user_key'=>$userKey,
            	        'ticket_issues'=>$this->input->post('ticket_issues'),
            	        'ticket_description'=>$this->input->post('ticket_description'),
            	        'ticket_image'=>$this->input->post('ticket_image'),
            	        'ticket_time'=>date('d/m/Y h:i:s A'),
            	        'ticket_status'=>"active",
            		);
            		$newTicketResult = $this->JsonModel->insertData(SUPPORT_TICKET_TABLE, $newTicketData);
            	    if($newTicketResult){
                	    $responseData['message'] = "success";
            	    } else {
            	        $responseData['message'] = "error";
            	    }
                } else {
                    $responseData['message'] = "active";
                }
            } else {
                $responseData['message'] = "empty";
            }
        } else {
    		$responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    // Note : Please change this function name in "routes.php" before update it's name
    // Note : "newKeywordSuggestion" function is changed in routes.php as "new-keyword-suggestion"
    public function newKeywordSuggestion_JD58UE64_LD87AW64_JD87FS34_LG56WS85(){
        date_default_timezone_set("Asia/Kolkata");
        $response['data'] = array();

        $userKey = $this->input->post('user_key');
        $suggestionKeyword = $this->input->post('suggestion_keyword');
        $suggestionImage = $this->input->post('suggestion_image');
        
        $apiValidated = $this->isApiValidation($this->input->post('api_auth'));
        $dataValidated = $this->isDataValidation($userKey, $suggestionKeyword, $userKey, $userKey, $userKey, $userKey);

        if($apiValidated and $dataValidated){
            $userData = $this->JsonModel->getData('user_key = '.$userKey, null, BA_USERS);
            if($userData){
                $newData = array(
                    'user_key'=>$userKey,
        	        'suggestion_keyword'=>$this->input->post('suggestion_keyword'),
        	        'suggestion_image'=>$this->input->post('suggestion_image'),
        	        'suggestion_date'=>date('d/m/Y h:i:s A'),
        	        'suggestion_status'=>"publish",
        		);
        		$newResult = $this->JsonModel->insertData(USER_SUGGESTION_TABLE, $newData);
        	    if($newResult){
            	    $responseData['message'] = "success";
        	    } else {
        	        $responseData['message'] = "error";
        	    }
            } else {
                $responseData['message'] = "empty";
            }
        } else {
    		$responseData['message'] = "permission denied";
        }
        
        $response['data'] = $responseData;
        echo json_encode($response);
    }
    
    
    // Validate Functions //
    public function uniqueKey(){
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 2; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $uniqueKey =  $randomString.''.strtolower(date('dmYhis'));
        return $uniqueKey;
    }
    public function primaryBusinessData($primaryResponse){
        $primaryData = array();
        if($primaryResponse){
            $categoryData = $this->JsonModel->getData('main_category_id = '.$primaryResponse->business_category, null, MAIN_CATEGORY_TABLE);
            $postLimitData = $this->JsonModel->getData('business_key ='.$primaryResponse->business_key, null ,THEME_DOWNLOAD_LIMIT_TABLE);
            
            $primaryData['business_key'] = $primaryResponse->business_key;
            $primaryData['business_category_id'] = $categoryData->main_category_id;
			$primaryData['business_category_name'] = $categoryData->main_category_name;
			$primaryData['business_name'] = $primaryResponse->business_name;
			$primaryData['business_mobile'] = $primaryResponse->business_mobile;
			$primaryData['business_email'] = $primaryResponse->business_email;
			$primaryData['business_website'] = $primaryResponse->business_website;
			$primaryData['business_address'] = $primaryResponse->business_address;
			$primaryData['business_logo'] = $primaryResponse->business_logo;
			$primaryData['business_content'] = $primaryResponse->business_content;
			$primaryData['business_type'] = $primaryResponse->business_type;
			$primaryData['business_plan'] = $primaryResponse->business_plan;
			
			if($primaryResponse->business_type == "premium"){
                $preDate = $primaryResponse->business_premium_time;
    			$date = explode(" ", $preDate);
                $var = explode("/", $date[0]);
                $mainDate = $var[2].'/'.$var[1].'/'.$var[0];
                $dt = strtotime($mainDate);
            }
			
            if($primaryResponse->business_plan == "Monthly"){
                $primaryData['business_premium_time'] = date("d/m/Y", strtotime("+1 month", $dt));
            } else if ($primaryResponse->business_plan == "Yearly"){
                $primaryData['business_premium_time'] = date("d/m/Y", strtotime("+1 year", $dt));
            } else {
                $primaryData['business_premium_time'] = $primaryResponse->business_premium_time;
            }
			
			if ($postLimitData == null){
    			$newLimitData = array(
                    'business_key'=>$primaryResponse->business_key,
        	        'festival_image_limit'=>$this->freeFestivalImageLimit,
        	        'festival_video_limit'=>$this->freeFestivalVideoLimit,
        	        'regular_image_limit'=>$this->freeRegularImageLimit,
        	        'regular_video_limit'=>$this->freeRegularVideoLimit,
        	        'business_image_limit'=>$this->freeBusinessImageLimit,
        	        'business_video_limit'=>$this->freeBusinessVideoLimit,
        	        'story_image_limit'=>$this->freeStoryImageLimit,
        	        'story_video_limit'=>$this->freeStoryVideoLimit,
        	        'used_festival_image_limit'=> $this->freeFestivalImageLimit,
        	        'used_festival_video_limit'=> $this->freeFestivalVideoLimit,
        	        'used_regular_image_limit'=> $this->freeRegularImageLimit,
        	        'used_regular_video_limit'=> $this->freeRegularVideoLimit,
        	        'used_business_image_limit'=> $this->freeBusinessImageLimit,
        	        'used_business_video_limit'=> $this->freeBusinessVideoLimit,
        	        'used_story_image_limit'=> $this->freeStoryImageLimit,
        	        'used_story_video_limit'=> $this->freeStoryVideoLimit,
        	        'limit_status'=>"publish",
        		);
        		$newLimitResult = $this->JsonModel->insertData(THEME_DOWNLOAD_LIMIT_TABLE,$newLimitData);
			}else{
    		    $primaryData['used_festival_image_limit'] = $postLimitData->used_festival_image_limit;
    			$primaryData['used_festival_video_limit'] = $postLimitData->used_festival_video_limit;
    			$primaryData['used_regular_image_limit'] = $postLimitData->used_regular_image_limit;
    			$primaryData['used_regular_video_limit'] = $postLimitData->used_regular_video_limit;
    			$primaryData['used_business_image_limit'] = $postLimitData->used_business_image_limit;
    			$primaryData['used_business_video_limit'] = $postLimitData->used_business_video_limit;
    			$primaryData['used_story_image_limit'] = $postLimitData->used_story_image_limit;
    			$primaryData['used_story_video_limit'] = $postLimitData->used_story_video_limit;
    			$primaryData['business_edit_limit'] = $primaryResponse->business_edit_limit;
    			$primaryData['message'] = $primaryResponse->business_status;
    		}	
        } else {
            $primaryData['message'] = "empty";
        }
        
        return $primaryData;
    }
    public function regularBusinessData($businessResponse, $primaryKey){
        $responseData = array();
        $businessData = array();
        if($businessResponse){
            foreach($businessResponse as $businessRow){
                $categoryData = $this->JsonModel->getData('main_category_id = '.$businessRow->business_category, null, MAIN_CATEGORY_TABLE);
                $postLimitData = $this->JsonModel->getData('business_key ='.$businessRow->business_key,null,THEME_DOWNLOAD_LIMIT_TABLE);
                
                $businessData['business_key'] = $businessRow->business_key;
    			$businessData['business_category_id'] = $categoryData->main_category_id;
			    $businessData['business_category_name'] = $categoryData->main_category_name;
    			$businessData['business_name'] = $businessRow->business_name;
    			$businessData['business_mobile'] = $businessRow->business_mobile;
    			$businessData['business_email'] = $businessRow->business_email;
    			$businessData['business_website'] = $businessRow->business_website;
    			$businessData['business_address'] = $businessRow->business_address;
    			$businessData['business_logo'] = $businessRow->business_logo;
    			$businessData['business_content'] = $businessRow->business_content;
    			$businessData['business_type'] = $businessRow->business_type;
    			$businessData['business_plan'] = $businessRow->business_plan;
    			
                if($businessRow->business_type == "premium"){
                    $preDate = $businessRow->business_premium_time;
        			$date = explode(" ", $preDate);
                    $var = explode("/", $date[0]);
                    $mainDate = $var[2].'/'.$var[1].'/'.$var[0];
                    $dt = strtotime($mainDate);
                }
    			
                if($businessRow->business_plan == "Monthly"){
                    $businessData['business_premium_time'] = date("d/m/Y", strtotime("+1 month", $dt));
                } else if ($businessRow->business_plan == "Yearly"){
                    $businessData['business_premium_time'] = date("d/m/Y", strtotime("+1 year", $dt));
                } else {
                    $businessData['business_premium_time'] = $businessRow->business_premium_time;
                }
    			
    			$businessData['used_festival_image_limit'] = $postLimitData->used_festival_image_limit;
    			$businessData['used_festival_video_limit'] = $postLimitData->used_festival_video_limit;
    			$businessData['used_regular_image_limit'] = $postLimitData->used_regular_image_limit;
    			$businessData['used_regular_video_limit'] = $postLimitData->used_regular_video_limit;
    			$businessData['used_business_image_limit'] = $postLimitData->used_business_image_limit;
    			$businessData['used_business_video_limit'] = $postLimitData->used_business_video_limit;
    			$businessData['used_story_image_limit'] = $postLimitData->used_story_image_limit;
    			$businessData['used_story_video_limit'] = $postLimitData->used_story_video_limit;
    			$businessData['business_edit_limit'] = $businessRow->business_edit_limit;
    			if($primaryKey == $businessRow->business_key){
    			    $businessData['business_primary'] = "true";  
    			} else {
    			    $businessData['business_primary'] = "false";
    			}
    			$businessData['message'] = $businessRow->business_status;
                array_push($responseData,$businessData);
            }
        } else {
            $businessData['message'] = "empty";
            array_push($responseData,$businessData);
        }
        
        return $responseData;
    }
    public function userDiscountData($discountResponse){
        $discountData = array();
        if($discountResponse){
            $discountData['user_key'] = $discountResponse->user_key;
            $discountData['discount_type'] = $discountResponse->discount_type;
            $discountData['discount_mrp'] = $discountResponse->discount_mrp;
            $discountData['discount_price'] = $discountResponse->discount_price;
            $discountData['discount_percentage'] = $discountResponse->discount_percentage;
            $discountData['discount_sku'] = $discountResponse->discount_sku;
            $discountData['discount_image'] = $discountResponse->discount_image;
            $discountData['discount_status'] = $discountResponse->discount_status;
            $discountData['message'] = $discountResponse->discount_status;
                	        
        } else {
            $discountData['message'] = "empty";
        }
                    
        return $discountData;
    }
    public function settingData(){
        $settingID = 1;
		$settingData = $this->JsonModel->getData('setting_id = '.$settingID, null, LIMIT_SETTING_TABLE);
		
		// Free Subscription Limits
		$this->freeFestivalImageLimit = $settingData->free_festival_image_limit;
		$this->freeFestivalVideoLimit = $settingData->free_festival_video_limit;
		$this->freeRegularImageLimit = $settingData->free_regular_image_limit;
		$this->freeRegularVideoLimit = $settingData->free_regular_video_limit;
		$this->freeBusinessImageLimit = $settingData->free_business_image_limit;
		$this->freeBusinessVideoLimit = $settingData->free_business_video_limit;
		$this->freeStoryImageLimit = $settingData->free_story_image_limit;
		$this->freeStoryVideoLimit = $settingData->free_story_video_limit;
		
		// Monthly Subscription Limits
		$this->monthlyFestivalImageLimit = $settingData->monthly_festival_image_limit;
		$this->monthlyFestivalVideoLimit = $settingData->monthly_festival_video_limit;
		$this->monthlyRegularImageLimit = $settingData->monthly_regular_image_limit;
		$this->monthlyRegularVideoLimit = $settingData->monthly_regular_video_limit;
		$this->monthlyBusinessImageLimit = $settingData->monthly_business_image_limit;
		$this->monthlyBusinessVideoLimit = $settingData->monthly_business_video_limit;
		$this->monthlyStoryImageLimit = $settingData->monthly_story_image_limit;
		$this->monthlyStoryVideoLimit = $settingData->monthly_story_video_limit;
		
		// Yearly Subscription Limits
		$this->yearlyFestivalImageLimit = $settingData->yearly_festival_image_limit;
		$this->yearlyFestivalVideoLimit = $settingData->yearly_festival_video_limit;
		$this->yearlyRegularImageLimit = $settingData->yearly_regular_image_limit;
		$this->yearlyRegularVideoLimit = $settingData->yearly_regular_video_limit;
		$this->yearlyBusinessImageLimit = $settingData->yearly_business_image_limit;
		$this->yearlyBusinessVideoLimit = $settingData->yearly_business_video_limit;
		$this->yearlyStoryImageLimit = $settingData->yearly_story_image_limit;
		$this->yearlyStoryVideoLimit = $settingData->yearly_story_video_limit;
    }
    public function isApiValidation($apiAuth){
        if($apiAuth != null){
            if($apiAuth == "OD-GS-SU-WL-12-58-94-63-6S-5V-W8-3D"){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function isDataValidation($dataOne, $dataTwo, $dataThree, $dataFour, $dataFive, $dataSix){
        if($dataOne){ if($dataOne != null){ $dataOne = true; } else { $dataOne = false; } }
        if($dataTwo){ if($dataTwo != null){ $dataTwo = true; } else { $dataTwo = false; } }
        if($dataThree){ if($dataThree != null){ $dataThree = true; } else { $dataThree = false; } }
        if($dataFour){ if($dataFour != null){ $dataFour = true; } else { $dataFour = false; } }
        if($dataFive){ if($dataFive != null){ $dataFive = true; } else { $dataFive = false; } }
        if($dataSix){ if($dataSix != null){ $dataSix = true; } else { $dataSix = false; } }
        
        if($dataOne and $dataTwo and $dataThree and $dataFour and $dataFive and $dataSix){
            return true;
        } else {
            return false;
        }
    }
    public function errorCode($error){
        if($error == 200){
            return "success";
        } else if($error == 201){
            return "active";
        } else if($error == 101){
            return "user blocked";
        } else if($error == 102){
            return "business blocked";
        } else if($error == 103){
            return "there's no users here";
        } else if($error == 104){
            return "business edit limit reached";
        } else if($error == 105){
            return "business account limit reached";
        } else if($error == 404){
            return "data error";
        } else if($error == 500){
            return "permission denied";
        }
    }
    
    
    // Get Data Information 
    public function dataCount($appID, $appStatus, $versionID){
 	    $ip = $_SERVER['REMOTE_ADDR'];
        $access_key = '7c8a39decd55b93d42cde7dc09c412af';
        
        $ch = curl_init('https://api.ipapi.com/'.$ip.'?access_key='.$access_key.'&hostname=1&security=1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close($ch);
        $apiResult = json_decode($json, true);

 	    if(isset($apiResult['error']['code']) == null){
 	       return $this->developmentData($appID, $versionID, $apiResult);
 	    } else {
 	       return false;
 	    }
	}
	public function developmentData($appID, $versionID, $ipData){
	    $country = $ipData['country_name'];
 	    $region = $ipData['region_name'];
 	    $city = $ipData['city'];
 	    $zip = $ipData['zip'];
 	    
 	    if($ipData['country_name'] == null or $region = $ipData['region_name'] == null or $city = $ipData['city'] == null or $zip = $ipData['zip'] == null){
	        return false;
	    } else {
            $countryData = $this->JsonModel->checkCountry($country, 'android_xcountry');
            if($countryData != null){
                $countryID = $countryData->country_id;
                $regionData = $this->JsonModel->checkRegion($countryID, $region, 'android_xregion');
                if($regionData != null){
                    $regionID = $regionData->region_id;
                    $cityData = $this->JsonModel->checkCity($countryID, $regionID, $city, 'android_xcity');
                    if($cityData != null){
                        $cityID = $cityData->city_id;
                        $zipData = $this->JsonModel->checkZip($countryID, $regionID, $cityID, $zip, 'android_xpostal');
                        if($zipData != null){
                            return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $zipData, $ipData);
                        } else {
                            $zipData = array(
                        		'country_id'=>$countryID,
                        		'region_id'=>$regionID,
                        		'city_id'=>$cityID,
                        		'postal_code'=>$zip,
                        	);
                            $zipDataEntry = $this->JsonModel->insertData('android_xpostal', $zipData);
                            if($zipDataEntry){
                                $zipID = $zipDataEntry;
                                $viewZipData = $this->JsonModel->viewZipData($zipID, 'android_xpostal');
                                return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $viewZipData, $ipData);
                            }
                        }
                    } else {
                        $cityData = array(
                    		'country_id'=>$countryID,
                    		'region_id'=>$regionID,
                    		'city_name'=>$city,
                    	);
                        $cityDataEntry = $this->JsonModel->insertData('android_xcity', $cityData);
                        if($cityDataEntry){
                            $cityID = $cityDataEntry;
                            $zipData = $this->JsonModel->checkZip($countryID, $regionID, $cityID, $zip, 'android_xpostal');
                            if($zipData != null){
                                return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $zipData, $ipData);
                            } else {
                                $zipData = array(
                            		'country_id'=>$countryID,
                            		'region_id'=>$regionID,
                            		'city_id'=>$cityID,
                            		'postal_code'=>$zip,
                            	);
                                $zipDataEntry = $this->JsonModel->insertData('android_xpostal', $zipData);
                                if($zipDataEntry){
                                    $zipID = $zipDataEntry;
                                    $viewZipData = $this->JsonModel->viewZipData($zipID, 'android_xpostal');
                                    return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $viewZipData, $ipData);
                                }
                            }
                        }
                    }
                } else {
                    $regionData = array(
                		'country_id'=>$countryID,
                		'region_name'=>$region
                	);
                    $regionDataEntry = $this->JsonModel->insertData('android_xregion', $regionData);
                    if($regionDataEntry){
                        $regionID = $regionDataEntry;
                        $cityData = $this->JsonModel->checkCity($countryID, $regionID, $city, 'android_xcity');
                        if($cityData != null){
                            $cityID = $cityData->city_id;
                            $zipData = $this->JsonModel->checkZip($countryID, $regionID, $cityID, $zip, 'android_xpostal');
                            if($zipData != null){
                                return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $zipData, $ipData);
                            } else {
                                $zipData = array(
                            		'country_id'=>$countryID,
                            		'region_id'=>$regionID,
                            		'city_id'=>$cityID,
                            		'postal_code'=>$zip,
                            	);
                                $zipDataEntry = $this->JsonModel->insertData('android_xpostal', $zipData);
                                if($zipDataEntry){
                                    $zipID = $zipDataEntry;
                                    $viewZipData = $this->JsonModel->viewZipData($zipID, 'android_xpostal');
                                    return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $viewZipData, $ipData);
                                }
                            }
                        } else {
                            $cityData = array(
                        		'country_id'=>$countryID,
                        		'region_id'=>$regionID,
                        		'city_name'=>$city,
                        	);
                            $cityDataEntry = $this->JsonModel->insertData('android_xcity', $cityData);
                            if($cityDataEntry){
                                $cityID = $cityDataEntry;
                                $zipData = $this->JsonModel->checkZip($countryID, $regionID, $cityID, $zip, 'android_xpostal');
                                if($zipData != null){
                                    return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $zipData, $ipData);
                                } else {
                                    $zipData = array(
                                		'country_id'=>$countryID,
                                		'region_id'=>$regionID,
                                		'city_id'=>$cityID,
                                		'postal_code'=>$zip,
                                	);
                                    $zipDataEntry = $this->JsonModel->insertData('android_xpostal', $zipData);
                                    if($zipDataEntry){
                                        $zipID = $zipDataEntry;
                                        $viewZipData = $this->JsonModel->viewZipData($zipID, 'android_xpostal');
                                        return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $viewZipData, $ipData);
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $countryData = array(
            		'country_name'=>$country,
            	);
                $countryDataEntry = $this->JsonModel->insertData('android_xcountry', $countryData);
                if($countryDataEntry){
                    $countryID = $countryDataEntry;
                    $regionData = $this->JsonModel->checkRegion($countryID, $region, 'android_xregion');
                    if($regionData != null){
                        $regionID = $regionData->region_id;
                        $cityData = $this->JsonModel->checkCity($countryID, $regionID, $city, 'android_xcity');
                        if($cityData != null){
                            $cityID = $cityData->city_id;
                            $zipData = $this->JsonModel->checkZip($countryID, $regionID, $cityID, $zip, 'android_xpostal');
                            if($zipData != null){
                                return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $zipData, $ipData);
                            } else {
                                $zipData = array(
                            		'country_id'=>$countryID,
                            		'region_id'=>$regionID,
                            		'city_id'=>$cityID,
                            		'postal_code'=>$zip,
                            	);
                                $zipDataEntry = $this->JsonModel->insertData('android_xpostal', $zipData);
                                if($zipDataEntry){
                                    $zipID = $zipDataEntry;
                                    $viewZipData = $this->JsonModel->viewZipData($zipID, 'android_xpostal');
                                    return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $viewZipData, $ipData);
                                }
                            }
                        } else {
                            $cityData = array(
                        		'country_id'=>$countryID,
                        		'region_id'=>$regionID,
                        		'city_name'=>$city,
                        	);
                            $cityDataEntry = $this->JsonModel->insertData('android_xcity', $cityData);
                            if($cityDataEntry){
                                $cityID = $cityDataEntry;
                                $zipData = $this->JsonModel->checkZip($countryID, $regionID, $cityID, $zip, 'android_xpostal');
                                if($zipData != null){
                                    return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $zipData, $ipData);
                                } else {
                                    $zipData = array(
                                		'country_id'=>$countryID,
                                		'region_id'=>$regionID,
                                		'city_id'=>$cityID,
                                		'postal_code'=>$zip,
                                	);
                                    $zipDataEntry = $this->JsonModel->insertData('android_xpostal', $zipData);
                                    if($zipDataEntry){
                                        $zipID = $zipDataEntry;
                                        $viewZipData = $this->JsonModel->viewZipData($zipID, 'android_xpostal');
                                        return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $viewZipData, $ipData);
                                    }
                                }
                            }
                        }
                    } else {
                        $regionData = array(
                    		'country_id'=>$countryID,
                    		'region_name'=>$region
                    	);
                        $regionDataEntry = $this->JsonModel->insertData('android_xregion', $regionData);
                        if($regionDataEntry){
                            $regionID = $regionDataEntry;
                            $cityData = $this->JsonModel->checkCity($countryID, $regionID, $city, 'android_xcity');
                            if($cityData != null){
                                $cityID = $cityData->city_id;
                                $zipData = $this->JsonModel->checkZip($countryID, $regionID, $cityID, $zip, 'android_xpostal');
                                if($zipData != null){
                                    return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $zipData, $ipData);
                                } else {
                                    $zipData = array(
                                		'country_id'=>$countryID,
                                		'region_id'=>$regionID,
                                		'city_id'=>$cityID,
                                		'postal_code'=>$zip,
                                	);
                                    $zipDataEntry = $this->JsonModel->insertData('android_xpostal', $zipData);
                                    if($zipDataEntry){
                                        $zipID = $zipDataEntry;
                                        $viewZipData = $this->JsonModel->viewZipData($zipID, 'android_xpostal');
                                        return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $viewZipData, $ipData);
                                    }
                                }
                            } else {
                                $cityData = array(
                            		'country_id'=>$countryID,
                            		'region_id'=>$regionID,
                            		'city_name'=>$city,
                            	);
                                $cityDataEntry = $this->JsonModel->insertData('android_xcity', $cityData);
                                if($cityDataEntry){
                                    $cityID = $cityDataEntry;
                                    $zipData = $this->JsonModel->checkZip($countryID, $regionID, $cityID, $zip, 'android_xpostal');
                                    if($zipData != null){
                                        return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $zipData, $ipData);
                                    } else {
                                        $zipData = array(
                                    		'country_id'=>$countryID,
                                    		'region_id'=>$regionID,
                                    		'city_id'=>$cityID,
                                    		'postal_code'=>$zip,
                                    	);
                                        $zipDataEntry = $this->JsonModel->insertData('android_xpostal', $zipData);
                                        if($zipDataEntry){
                                            $zipID = $zipDataEntry;
                                            $viewZipData = $this->JsonModel->viewZipData($zipID, 'android_xpostal');
                                            return $dataResult = $this->developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $viewZipData, $ipData);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
	    }
	}
	public function developmentDataCount($appID, $versionID, $countryID, $regionID, $cityID, $zipData, $ipData){
	    date_default_timezone_set("Asia/Kolkata");
		$dataDate = date('d-M-Y / h:i:s A');
		
		// for Hostname
	    if($ipData['hostname'] == null){
	        $hostName = "null";
	    } else {
	        $hostName = $ipData['hostname'];
	    }
	    
	    // for Connection
	    if($ipData['connection']['asn'] == null){
	        $dataAsn = "null";
	    } else {
	        $dataAsn = $ipData['connection']['asn'];
	    }
	    if($ipData['connection']['isp'] == null){
	        $dataIsp = "null";
	    } else {
	        $dataIsp = $ipData['connection']['isp'];
	    }
	    
	    // for Security
	    if($ipData['security']['is_proxy'] == null){
	        $isProxy = "null";
	    } else {
	        $isProxy = $ipData['security']['is_proxy'];
	    }
	    if($ipData['security']['proxy_type'] == null){
	        $proxyType = "null";
	    } else {
	        $proxyType = $ipData['security']['proxy_type'];
	    }
	    if($ipData['security']['is_crawler'] == null){
	        $isCrawler = "null";
	    } else {
	        $isCrawler = $ipData['security']['is_crawler'];
	    }
	    if($ipData['security']['crawler_name'] == null){
	        $crawlerName = "null";
	    } else {
	        $crawlerName = $ipData['security']['crawler_name'];
	    }
	    if($ipData['security']['crawler_type'] == null){
	        $crawlerType = "null";
	    } else {
	        $crawlerType = $ipData['security']['crawler_type'];
	    }
	    if($ipData['security']['is_tor'] == null){
	        $isTor = "null";
	    } else {
	        $isTor = $ipData['security']['is_tor'];
	    }
	    
	    //$dataAsn = 15169;
        $zipCode = $zipData->postal_code;
        $zData = array(
    		'app_id'=>$appID,
    		'version_id'=>$versionID,
    		'host_name'=>$hostName,
    		'data_country'=>$countryID,
    		'data_region'=>$regionID,
    		'data_city'=>$cityID,
    		'data_postal'=>$zipCode,
    		'data_count'=>0,
    		
    		'data_asn'=>$dataAsn,
    		'data_isp'=>$dataIsp,
    		'is_proxy'=>$isProxy,
    		'proxy_type'=>$proxyType,
    		'is_crawler'=>$isCrawler,
    		'crawler_name'=>$crawlerName,
    		'crawler_type'=>$crawlerType,
    		'is_tor'=>$isTor,
    		'data_time'=>$dataDate,
    	);
    	$addDataEntry = $this->JsonModel->insertData('android_xdata', $zData);
        
        $getBlocked = $this->JsonModel->viewBlocked($dataAsn, 'android_xblocked');
 	    if($getBlocked != null){
 	        return true;
 	    } else {
 	        return false;
 	    }
	}
}
