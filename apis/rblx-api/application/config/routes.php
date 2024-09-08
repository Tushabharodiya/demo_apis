<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['json/rblx-main-data'] = 'Json/rblxMainData';

$route['json/rblx-most-loved-data'] = 'Json/rblxMostLovedData';
$route['json/rblx-most-loved-data'.'/(:num)'] = 'Json/rblxMostLovedData/$1';

$route['json/rblx-trending-data'] = 'Json/rblxTrendingData';
$route['json/rblx-trending-data'.'/(:num)'] = 'Json/rblxTrendingData/$1';

$route['json/rblx-shoes-data'] = 'Json/rblxShoesData';
$route['json/rblx-shoes-data'.'/(:num)'] = 'Json/rblxShoesData/$1';

$route['json/rblx-shirt-data'] = 'Json/rblxShirtData';
$route['json/rblx-shirt-data'.'/(:num)'] = 'Json/rblxShirtData/$1';

$route['json/rblx-pant-data'] = 'Json/rblxPantData';
$route['json/rblx-pant-data'.'/(:num)'] = 'Json/rblxPantData/$1';

$route['json/rblx-girl-shirt-data'] = 'Json/rblxGirlShirtData';
$route['json/rblx-girl-shirt-data'.'/(:num)'] = 'Json/rblxGirlShirtData/$1';

$route['json/rblx-girl-pant-data'] = 'Json/rblxGirlPantData';
$route['json/rblx-girl-pant-data'.'/(:num)'] = 'Json/rblxGirlPantData/$1';

$route['json/rblx-boy-shirt-data'] = 'Json/rblxBoyShirtData';
$route['json/rblx-boy-shirt-data'.'/(:num)'] = 'Json/rblxBoyShirtData/$1';

$route['json/rblx-boy-pant-data'] = 'Json/rblxBoyPantData';
$route['json/rblx-boy-pant-data'.'/(:num)'] = 'Json/rblxBoyPantData/$1';

$route['json/rblx-download-data'] = 'Json/rblxDownloadData';
$route['json/rblx-liked-data'] = 'Json/rblxLikedData';
$route['json/rblx-viewed-data'] = 'Json/rblxViewedData';

$route['json/rblx-search-data'] = 'Json/rblxSearchData';
$route['json/rblx-search-data'.'/(:num)'] = 'Json/rblxSearchData/$1';