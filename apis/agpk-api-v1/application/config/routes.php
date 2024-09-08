<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['json/keyboard-main-data'] = 'Json/keyboardMainData';
$route['json/keyboard-theme-data'] = 'Json/keyboardThemeData';
$route['json/keyboard-category-data'] = 'Json/keyboardCategoryData';
$route['json/keyboard-view-data'] = 'Json/keyboardViewData';
$route['json/keyboard-view-data'.'/(:num)'] = 'Json/keyboardViewData/$1';
$route['json/keyboard-search-data'] = 'Json/keyboardSearchData';
$route['json/keyboard-search-data'.'/(:num)'] = 'Json/keyboardSearchData/$1';


