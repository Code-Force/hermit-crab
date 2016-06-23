<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There is one reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
*/
$route['activate/validation/:any'] = "activate/validation/$1";
$route['uploader/upload/:any'] = "uploader/upload/$1";
$route['uploader/upload'] = "uploader/upload";
$route['uploader/blank'] = "uploader/blank";
$route['reset/validation/:any'] = "reset/validation/$1";
$route[':any'] = "blogger";
$route['discover'] = "discover";
$route['signup'] = "signup";
$route['signin'] = "signin";
$route['settings'] = "settings";
$route['signout'] = "signout";
$route['terms-and-conditions'] = "terms_and_conditions";
$route['forgot'] = "forgot";
$route['resend'] = "resend";
$route['write'] = "write";
$route['profile'] = "profile";
$route['help'] = "help";
$route['about'] = "about";
$route['notifications'] = "notifications";
$route['connectfacebook'] = "connectfacebook";
$route['connecttwitter'] = "connecttwitter";
$route['connectgoogleplus'] = "connectgoogleplus";
$route['signup/errorfacebook'] = "signup/errorfacebook";
$route['signup/errortwitter'] = "signup/errortwitter";
$route['signup/errorgoogle'] = "signup/errorgoogle";
$route['signup/twitter'] = "signup/twitter";
$route['connecttwitter/oauth'] = "connecttwitter/oauth";
$route['connecttwitter/callback'] = "connecttwitter/callback";
$route['imgselect'] = "imgselect";
$route['getmorestories'] = "getmorestories";
$route['disconnectsocial'] = "disconnectsocial";
$route['google_test'] = "google_test";
$route['follow'] = "follow";
$route['like'] = "like";
$route['checknotifications'] = "checknotifications";
$route['submitfeedback'] = "submitfeedback";
$route['comment'] = "comment";
$route['contact'] = "contact";
$route['resend'] = "resend";
$route['bugs-and-reporting'] = "bugs_and_reporting";
$route['privacy-policy'] = "privacy_policy";
$route['updateme'] = "updateme";

$route['default_controller'] = 'home';
$route['404_override'] = 'fuel/page_router';
/*
| Uncomment this line if you want to use the automatically generated sitemap based on your navigation.
| To modify the sitemap.xml, go to the views/sitemap_xml.php file.
*/ 
//$route['sitemap.xml'] = 'sitemap_xml';

include(MODULES_PATH.'/fuel/config/fuel_routes.php');

/* End of file routes.php */
/* Location: ./application/config/routes.php */