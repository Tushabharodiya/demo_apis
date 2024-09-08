<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['json/user-login-otp-BRND-365'] = 'Json/userLoginOTP_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/user-app-data-BRND-365'] = 'Json/userAppData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';

$route['json/view-user-data-BRND-365'] = 'Json/viewUserData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/edit-user-profile-BRND-365'] = 'Json/editUserProfile_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/edit-user-language-BRND-365'] = 'Json/editUserLanguage_JD58UE64_LD87AW64_JD87FS34_LG56WS85';

$route['json/view-business-category-BRND-365'] = 'Json/viewBusinessCategory_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/new-business-data-BRND-365'] = 'Json/newBusinessData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/edit-business-data-BRND-365'] = 'Json/editBusinessData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/select-primary-business-BRND-365'] = 'Json/selectPrimaryBusiness_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/change-business-category-BRND-365'] = 'Json/changeBusinessCategory_JD58UE64_LD87AW64_JD87FS34_LG56WS85';

$route['json/apply-coupon-code-BRND-365'] = 'Json/applyCouponCode_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/purchase-result-data-BRND-365'] = 'Json/purchaseResultData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';

$route['json/view-regular-theme-BRND-365'] = 'Json/regularThemeData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/view-custom-theme-BRND-365'] = 'Json/customThemeData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/view-business-theme-BRND-365'] = 'Json/businessThemeData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/view-story-theme-BRND-365'] = 'Json/storyThemeData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/theme-download-data-BRND-365'] = 'Json/themeDownloadData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';

$route['json/new-contact-data-BRND-365'] = 'Json/newContactData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/new-quotation-data-BRND-365'] = 'Json/newQuotationData_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/view-support-option-BRND-365'] = 'Json/viewSupportOption_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/new-support-ticket-BRND-365'] = 'Json/newSupportTicket_JD58UE64_LD87AW64_JD87FS34_LG56WS85';
$route['json/new-keyword-suggestion-BRND-365'] = 'Json/newKeywordSuggestion_JD58UE64_LD87AW64_JD87FS34_LG56WS85';

$route['default_controller'] = 'dashboard';
$route['404_override'] = 'dashboard';
$route['translate_uri_dashes'] = FALSE;
