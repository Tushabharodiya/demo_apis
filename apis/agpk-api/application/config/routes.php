<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['json/keyboard-main-data'] = 'Json/keyboardMainData';
$route['json/keyboard-view-data'] = 'Json/keyboardViewData';
$route['json/keyboard-view-data'.'/(:num)'] = 'Json/keyboardViewData/$1';


