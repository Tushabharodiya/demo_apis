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
	
	public function apps(){
        $appCode = $this->input->post('app_code');
        $appVersion = $this->input->post('app_version');
        $appDevice = $this->input->post('app_device');
        
        if($appDevice == "iOS"){
            if(!empty($appCode) and !empty($appVersion)){
            $response = array();
    	    $response['apps'] = array();
    	    $response['version'] = array();
    	    $response['ads'] = array();
    	    $response['banner'] = array();
    	    
            $getApp = $this->JsonModel->viewApp($appCode, 'android_apps');
            if($getApp != null){
                $appID = $getApp->app_id;
                $appStatus = $getApp->app_status;
                $appData=array(
                    'app_package' => $getApp->app_package,
                    'app_email' => $getApp->app_email,
                    'app_store' => $getApp->app_store,
            		'app_privacy' => $getApp->app_privacy,
            		'app_terms' => $getApp->app_terms
        		);
        		$response['apps'] = $appData;
        		
        		$getVersion = $this->JsonModel->viewVersion($appID, $appVersion, 'android_version');
                if($getVersion != null){
                    $versionID = $getVersion->version_id;
                    $versionData=array(
                        'app_ads' => $getVersion->app_ads,
                        'splash_ads' => $getVersion->splash_ads,
                        'screen_ads' => $getVersion->screen_ads,
                		'app_banner' => $getVersion->app_banner,
                		'app_review' => $getVersion->app_review,
                		'app_update' => $getVersion->app_update,
                		'update_title' => $getVersion->update_title,
                		'update_description' => $getVersion->update_description,
                		'update_button' => $getVersion->update_button,
                		'update_url' => $getVersion->update_url,
                		'app_blog_status' => "true",
                		'ads_count' => 2,
                		'review_count' => 2,
                		
            		);
            		$response['version'] = $versionData;
                }
        		
                $getAds = $this->JsonModel->viewAds($appID, 'android_ads');
                if($getAds != null){
                    $adsData=array(
            		    'ads_priority' => $getAds->ads_priority,
            		    
            		    'is_banner' => $getAds->is_banner,
            		    'is_native' => $getAds->is_native,
            		    'is_interstitial' => $getAds->is_interstitial,
            		    'is_rewarded' => $getAds->is_rewarded,
            		    'is_open' => $getAds->is_open,
        
                        'google_banner_one' => $getAds->google_banner_one,
                		'google_banner_two' => $getAds->google_banner_two,
                		'google_native_one' => $getAds->google_native_one,
                		'google_native_two' => $getAds->google_native_two,
                		'google_interstitial_one' => $getAds->google_interstitial_one,
                		'google_interstitial_two' => $getAds->google_interstitial_two,
                		'google_rewarded_one' => $getAds->google_rewarded_one,
                		'google_rewarded_two' => $getAds->google_rewarded_two,
                		'google_open' => $getAds->google_open,
        
                        'facebook_banner_one' => $getAds->facebook_banner_one,
                		'facebook_banner_two' => $getAds->facebook_banner_two,
                		'facebook_native_one' => $getAds->facebook_native_one,
                		'facebook_native_two' => $getAds->facebook_native_two,
                		'facebook_interstitial_one' => $getAds->facebook_interstitial_one,
                		'facebook_interstitial_two' => $getAds->facebook_interstitial_two,
                		'facebook_rewarded_one' => $getAds->facebook_rewarded_one,
                		'facebook_rewarded_two' => $getAds->facebook_rewarded_two
            		);
            		$response['ads'] = $adsData;
                }
                
                $getJson = $this->JsonModel->viewJson($appID, 'android_json');
        		$bannerIDs = $getJson->json_data;
        		$bannerArray = explode(",",$bannerIDs);
        		foreach ($bannerArray as $row) {
        	        $banner_id = $row;
        	        $getJson = $this->JsonModel->viewBanner($banner_id, 'android_banner');
        	        array_push($response['banner'],$getJson);
        	    }
                
                $dataResponse = $this->dataCount($appID, $appStatus, $versionID);
                if(!empty($dataResponse)){
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
        } else {
            $status = "error";
            echo json_encode(array("response"=>$status));
        }
        } else {
            if(!empty($appCode) and !empty($appVersion)){
            $response = array();
    	    $response['apps'] = array();
    	    $response['version'] = array();
    	    $response['ads'] = array();
    	    $response['banner'] = array();
    	    
            $getApp = $this->JsonModel->viewApp($appCode, 'android_apps');
            if($getApp != null){
                $appID = $getApp->app_id;
                $appStatus = $getApp->app_status;
                $appData=array(
                    'app_package' => $getApp->app_package,
                    'app_email' => $getApp->app_email,
                    'app_store' => $getApp->app_store,
            		'app_privacy' => $getApp->app_privacy,
            		'app_terms' => $getApp->app_terms
        		);
        		$response['apps'] = $appData;
        		
        		$getVersion = $this->JsonModel->viewVersion($appID, $appVersion, 'android_version');
                if($getVersion != null){
                    $versionID = $getVersion->version_id;
                    $versionData=array(
                        'app_ads' => $getVersion->app_ads,
                        'splash_ads' => $getVersion->splash_ads,
                        'screen_ads' => $getVersion->screen_ads,
                		'app_banner' => $getVersion->app_banner,
                		'app_review' => $getVersion->app_review,
                		'app_update' => $getVersion->app_update,
                		'update_title' => $getVersion->update_title,
                		'update_description' => $getVersion->update_description,
                		'update_button' => $getVersion->update_button,
                		'update_url' => $getVersion->update_url,
                		'app_blog_status' => "true",
                		'ads_count' => 2,
                		'review_count' => 2,
                		
            		);
            		$response['version'] = $versionData;
                }
        		
                $getAds = $this->JsonModel->viewAds($appID, 'android_ads');
                if($getAds != null){
                    $adsData=array(
            		    'ads_priority' => $getAds->ads_priority,
            		    
            		    'is_banner' => $getAds->is_banner,
            		    'is_native' => $getAds->is_native,
            		    'is_interstitial' => $getAds->is_interstitial,
            		    'is_rewarded' => $getAds->is_rewarded,
            		    'is_open' => $getAds->is_open,
        
                        'google_banner_one' => $getAds->google_banner_one,
                		'google_banner_two' => $getAds->google_banner_two,
                		'google_native_one' => $getAds->google_native_one,
                		'google_native_two' => $getAds->google_native_two,
                		'google_interstitial_one' => $getAds->google_interstitial_one,
                		'google_interstitial_two' => $getAds->google_interstitial_two,
                		'google_rewarded_one' => $getAds->google_rewarded_one,
                		'google_rewarded_two' => $getAds->google_rewarded_two,
                		'google_open' => $getAds->google_open,
        
                        'facebook_banner_one' => $getAds->facebook_banner_one,
                		'facebook_banner_two' => $getAds->facebook_banner_two,
                		'facebook_native_one' => $getAds->facebook_native_one,
                		'facebook_native_two' => $getAds->facebook_native_two,
                		'facebook_interstitial_one' => $getAds->facebook_interstitial_one,
                		'facebook_interstitial_two' => $getAds->facebook_interstitial_two,
                		'facebook_rewarded_one' => $getAds->facebook_rewarded_one,
                		'facebook_rewarded_two' => $getAds->facebook_rewarded_two
            		);
            		$response['ads'] = $adsData;
                }
                
                $getJson = $this->JsonModel->viewJson($appID, 'android_json');
        		$bannerIDs = $getJson->json_data;
        		$bannerArray = explode(",",$bannerIDs);
        		foreach ($bannerArray as $row) {
        	        $banner_id = $row;
        	        $getJson = $this->JsonModel->viewBanner($banner_id, 'android_banner');
        	        array_push($response['banner'],$getJson);
        	    }
                
                $dataResponse = $this->dataCount($appID, $appStatus, $versionID);
                if(!empty($dataResponse)){
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
        } else {
            $status = "error";
            echo json_encode(array("response"=>$status));
        }
        }
        
	}
	
	
	public function dataCount($appID, $appStatus, $versionID){
 	    $ip = $_SERVER['REMOTE_ADDR'];
 	    //$access_key = '579b830535247e81ebc9ddfb53b0e0c1'; // Old Token
        $access_key = '7c8a39decd55b93d42cde7dc09c412af'; // New Token
        
        // Initialize CURL:
        $ch = curl_init('https://api.ipapi.com/'.$ip.'?access_key='.$access_key.'&hostname=1&security=1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);
        
        // Decode JSON response:
        $api_result = json_decode($json, true);

 	    if($appStatus == "development"){
 	        if(isset($api_result['error']['code']) == null){
     	       return $this->developmentData($appID, $versionID, $api_result);
     	    } else {
     	       return false;
     	    }
     	    //return false;
 	    } else if ($appStatus == "publish"){
 	        /*if(isset($api_result['error']['code']) == null){
     	       return $this->publishData($appID, $versionID, $api_result);
     	    } else {
     	       return false;
     	    }*/
     	    return false;
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
        
        $getBlocked = $this->JsonModel->viewBlocked($zipCode, 'android_blocked');
 	    if($getBlocked != null){
 	        return true;
 	    } else {
 	        return false;
 	    }
	}
}
