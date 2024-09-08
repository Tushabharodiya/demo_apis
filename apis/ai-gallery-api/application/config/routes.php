<?php defined('BASEPATH') OR exit('No direct script access allowed');

$route['json/ai-gallery-main-category-data'] = 'Json/aiGalleryMainCategoryData';
$route['json/ai-gallery-main-category-data'.'/(:num)'] = 'Json/aiGalleryMainCategoryData/$1';

$route['json/ai-gallery-view-category-data'] = 'Json/aiGalleryViewCategoryData';
$route['json/ai-gallery-view-category-data'.'/(:num)'] = 'Json/aiGalleryViewCategoryData/$1';
