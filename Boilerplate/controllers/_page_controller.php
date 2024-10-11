<?php
if(!isset($pages_requested) ) $pages_requested=$page=$url_array[1];




$param1=$pages = explode("_", $pages_requested) ;
$page_requested=$pages[0];
// $subPage = $pages[1];
$subPage = isset($pages[1]) ? $array[1] : '';
// $subPage2 = $pages[2];
$subPage2 = isset($pages[2]) ? $array[2] : '';


$param2 = [];
$param3 = [];
$param4 = [];
// $param2=$subPages = explode("_", urldecode($url_array[2])) ;
if (isset($url_array[2]) && $url_array[2] !== null) {
    $decodedUrl = urldecode($url_array[2]);
    $param2 = explode("_", $decodedUrl);
}
// $param3=$subPages2 = explode("_", urldecode($url_array[3])) ;
if (isset($url_array[3]) && $url_array[3] !== null) {
    $decodedUrl = urldecode($url_array[3]);
    $param3 = explode("_", $decodedUrl);
}
// $param4=$subPages3 = explode("_", urldecode($url_array[4])) ;
if (isset($url_array[4]) && $url_array[4] !== null) {
    $decodedUrl = urldecode($url_array[4]);
    $param4 = explode("_", $decodedUrl);
}


// if(isset($email)) $_POST['email']=stripslashes($email);


$crtl=_CONTROLER_PATH."forms/"; // shortening the path to include some files
// var_dump($page_requested);
// die();




include _APPS_PATH."/appsController/defaultController.php";


$random = $lib->random(); // Generate a random number to be added to url for customer logged in (to prevent browser to cache html data


include _VIEW_PATH.$view;
