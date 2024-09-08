<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Publish Data Routes
$route['json/applock-main-data'] = 'Json/applockMainData';
$route['json/applock-view-data'] = 'Json/applockViewData';
$route['json/applock-view-data'.'/(:num)'] = 'Json/applockViewData/$1';
$route['json/applock-viewed-data'] = 'Json/applockViewedData';
$route['json/applock-download-data'] = 'Json/applockDownloadData';
$route['json/applock-applied-data'] = 'Json/applockAppliedData';

// Unpublish Data Routes
$route['json/development-main-data'] = 'Json/developmentMainData';
$route['json/development-view-data'] = 'Json/developmentViewData';
$route['json/development-view-data'.'/(:num)'] = 'Json/developmentViewData/$1';
