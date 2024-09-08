<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['json/app-main-data'] = 'Json/appMainData';
$route['json/main-data'] = 'Json/mainData';
$route['json/view-data'] = 'Json/viewData';
$route['json/view-data'.'/(:num)'] = 'Json/viewData/$1';
$route['json/search-data'] = 'Json/searchData';
$route['json/new-data-download'] = 'Json/newDataDownload';
$route['json/new-data-view'] = 'Json/newDataView';
$route['json/send-token-data'] = 'Json/sendTokenData';



