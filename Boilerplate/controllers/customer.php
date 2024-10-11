<?php

/*
 * retrieve the second parameter from the URL
 */

$viewPath = "customer/";


$sub_page = $url_array[2];


if (!$_SESSION['customer']['authValidated']) {
	echo "denied||" . $lang->trl("Authentification requise !");
	exit;
}


$title = $lang->trl($iniObj->serviceName);
switch ($sub_page) {

	case "home":
		include "dashboard.php";
		break;

	
		
	case "logout":
		include "logout.php";
		break;
		

	default:
		
		if (!$_SESSION['customer']['authValidated']) {
			header("Location: /login");
			exit;
		} 
		else {
			$cache = false;
			$view = "fr/login.phtml";
		}
		break;

}