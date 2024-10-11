<?php

switch ($page_requested)
{

    case 'jsp':
        header("Content-Type: text/javascript");
        include(_JS_PATH . $url_array[2]);
        exit;
        break;

    case "login":
        include "login.php";
        break;

    case "login-ajax":
        include "login_ajax.php";
        break;

    case "customer":
        include "customer.php";
        break;

    case "reset-password-ajax": 
        include "forget.php";
        break;

    case "forget":
        if(file_exists(_VIEW_PATH."/fr/forget.phtml"))  $view="/fr/forget.phtml";
        else  $view="/fr/page404.phtml";
        break;

    case "admin-dashboard":
        include "admin-dashboard.php";
        break;

    case "collab-dashboard":
        include "collab-dashboard.php";
        break;

        case "manager-tasks":
            include "manager-tasks.php";
            break;
    
        case "manager-projects-tasks":
            include "manager-projects-tasks.php";
            break;
    
        case "manager-collabs-stats":
            include "manager-collabs-stats.php";
            break;

    case "manager-dashboard":
            include "manager-dashboard.php";
            break;
            case "projets":
                include "project.php";
                break;
                case "admin-mytasks":
                    include "admin-mytasks.php";
                    break;
                    case "collab-mytasks":
                        include "collab-mytasks.php";
                        break;
                        case "manager-dashboard":
                            include "manager-dashboard.php";
                            break;
                
                   
    default:
        include "login.php";
        break;
}