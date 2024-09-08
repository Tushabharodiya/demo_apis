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
	
	public function apps(){
        $appCode = $this->input->post('app_code');
        $appVersion = $this->input->post('app_version');
        
        // echo $appCode;
        // die;
    
        if(!empty($appCode) and !empty($appVersion)){
            $response = array();
    	    $response['apps'] = array();
    	    $response['version'] = array();
    	    $response['ads'] = array();
    	    $response['banner'] = array();
    	    
            $getApp = $this->DataModel->viewApp($appCode, 'android_apps');
            $appID = $getApp->app_id;
            $appData=array(
                'app_package' => $getApp->app_package,
        		'app_privacy' => $getApp->app_privacy,
        		'app_terms' => $getApp->app_terms,
        		'app_social' => 'https://www.syphnosys.com/'
    		);
    		$response['apps'] = $appData;
    
            $getVersion = $this->DataModel->viewVersion($appID, $appVersion, 'android_version');
    		$versionData=array(
                'app_ads' => $getVersion->app_ads,
                'splash_ads' => $getVersion->app_ads,
                'screen_ads' => $getVersion->app_ads,
        		'app_banner' => $getVersion->app_banner,
        		'app_review' => $getVersion->app_review,
        		'app_update' => $getVersion->app_update,
        		'app_blog_status' => $getVersion->app_blog_status,
        		'app_blog_url' => $getVersion->app_blog_url,
        		'ads_count' => 2,
        		'rate_count' => 2,
        		'update_title' => "Update App",
        		'update_description' => "Please Update Our App",
        		'update_button' => "Update",
        		'update_url' => "https://www.google.com/",
    		);
    		$response['version'] = $versionData;
    		
            $getAds = $this->DataModel->viewAds($appID, 'android_ads');
    		$adsData=array(
    		    'ads_priority' => "Google",
    		    
    		    'is_native' => "true",
    		    'is_interstitial' => "true",
    		    'is_rewarded' => "true",
    		    'is_open' => "true",

        		'google_native_one' => $getAds->google_native,
        		'google_native_two' => $getAds->google_native,
        		'google_interstitial_one' => $getAds->google_interstitial,
        		'google_interstitial_two' => $getAds->google_interstitial,
        		'google_rewarded_one' => $getAds->google_rewarded,
        		'google_rewarded_two' => $getAds->google_rewarded,
        		'google_open' => $getAds->google_open,

        		'facebook_native_one' => $getAds->facebook_native,
        		'facebook_native_two' => $getAds->facebook_native,
        		'facebook_interstitial_one' => $getAds->facebook_interstitial,
        		'facebook_interstitial_two' => $getAds->facebook_interstitial,
        		'facebook_rewarded_one' => $getAds->facebook_rewarded,
        		'facebook_rewarded_two' => $getAds->facebook_rewarded
    		);
    		$response['ads'] = $adsData;
    		
    		$getJson = $this->DataModel->viewJson($appID, 'android_json');
    		$bannerIDs = $getJson->json_data;
    		$bannerArray = explode(",",$bannerIDs);
    		foreach ($bannerArray as $row) {
    	        $banner_id = $row;
    	        $getJson = $this->DataModel->viewBanner($banner_id, 'android_banner');
    	        array_push($response['banner'],$getJson);
    	    }
    
            if(!empty($getApp)){
                $statusData = array('status' => true);
                $response['response'] = $statusData;
            } else {
                $statusData=array('status' => false);
                $response['response'] = $statusData;
            }
            
            echo json_encode($response);    
            
        } else {
            $status = "error";
            echo json_encode(array("response"=>$status));
        }
	}
	
	public function blogs(){
	    $blogData = $this->DataModel->getBlogData('ios_blog');
        echo json_encode($blogData);
	}
	
	public function quotes(){
	    $blogData = $this->DataModel->getQuoteData('ios_quotes');
        echo json_encode($blogData);
	}
	
	public function subscription(){
	    $SubscriptionData = $this->DataModel->getSubscriptionData('apple_subscription','ASC');
	    $carousel = array();
	    $response['carousel'] = array();
	    if(!empty($SubscriptionData)){
	         
	        foreach($SubscriptionData as $subscriptionRow){
	           // print_r($subscriptionRow);
	           // die;
	            $carousel['product_carousel_title_one'] = $subscriptionRow->product_carousel_title_one;
	            $carousel['product_carousel_slider_one'] = $subscriptionRow->product_carousel_slider_one;
	            $carousel['product_carousel_title_two'] = $subscriptionRow->product_carousel_title_two;
	            $carousel['product_carousel_slider_two'] = $subscriptionRow->product_carousel_slider_two;
	            $carousel['product_carousel_title_three'] = $subscriptionRow->product_carousel_title_three;
	            $carousel['product_carousel_slider_three'] = $subscriptionRow->product_carousel_slider_three;
	            $carousel['product_carousel_title_four'] = $subscriptionRow->product_carousel_title_four;
	            $carousel['product_carousel_slider_four'] = $subscriptionRow->product_carousel_slider_four;
	            array_push($response['carousel'],$carousel);
	        }
	    }
	    $response['carousel'] = $carousel;
        echo json_encode(array("subscription" =>$SubscriptionData));
	}
	
	public function user(){
	    if($this->input->post('user_device')){
	       $userDevice = $this->input->post('user_device');
	       
	       $getData = $this->DataModel->viewUser($userDevice, 'ios_user');
	       
	       if(!empty($getData)){
	           $userData = $this->DataModel->viewUser($userDevice, 'ios_user');
               echo json_encode($userData);
	       } else {
	           $newData = array(
    	        'user_device'=>$this->input->post('user_device')
        	   );
    	       $result = $this->DataModel->addUser('ios_user',$newData);
    
        	   if($result){
        	       $userData = $this->DataModel->viewUser($userDevice, 'ios_user');
                   echo json_encode($userData);
    	       }
	       }
	       
	    } else {
	        $status = "error";
            echo json_encode(array("response"=>$status)); 
	    }
	}
	
	public function reviewed(){
	    if($this->input->post('user_device') and $this->input->post('user_review')){
	       $userDevice = $this->input->post('user_device');
	       $userReview = $this->input->post('user_review');
	       
    	   $editData = array(
    	        'user_review'=>$userReview
    	   );
    		
    	   $result = $this->DataModel->editUser($userDevice,'ios_user',$editData);
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
