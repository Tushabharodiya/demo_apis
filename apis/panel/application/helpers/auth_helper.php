<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
    
    if ( ! function_exists('isApiValidation')){
        function isApiValidation($apiAuth){
            if($apiAuth != null){
                if($apiAuth == "KF-LH-QL-VF-56-89-15-64-ED-HJ-JU-QS"){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }


