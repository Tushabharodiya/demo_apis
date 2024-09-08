<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Publish Data Routes
$route['json/charging-main-data'] = 'Json/chargingMainData';
$route['json/charging-view-data'] = 'Json/chargingViewData';
$route['json/charging-view-data'.'/(:num)'] = 'Json/chargingViewData/$1';
$route['json/charging-viewed-data'] = 'Json/chargingViewedData';
$route['json/charging-download-data'] = 'Json/chargingDownloadData';
$route['json/charging-applied-data'] = 'Json/chargingAppliedData';

// Unpublish Data Routes
$route['json/development-main-data'] = 'Json/developmentMainData';
$route['json/development-view-data'] = 'Json/developmentViewData';
$route['json/development-view-data'.'/(:num)'] = 'Json/developmentViewData/$1';
