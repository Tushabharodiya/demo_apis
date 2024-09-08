<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
    require 'vendor/autoload.php';
    use Aws\S3\S3Client;
    use Aws\S3\Exception\S3Exception;
    
    if ( ! function_exists('isApiValidation')){
        function isApiValidation($apiAuth){
            if($apiAuth != null){
                if($apiAuth == "R5F6-H8R9-S6J6-J6X2-W3F3-Y8A6-Q6R7-D8H6-A8E6-Y8W5-C5D6"){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }


