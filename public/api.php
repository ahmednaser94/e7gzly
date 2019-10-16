<?php

switch($_GET['section']) {
    case 'users': {
        require('../private/requests/users_requests.php');
    }
    break;

    case 'categories':{
        require('../private/requests/categories_requests.php');

    }
    break;

    case 'organization':{
        require('../private/requests/org_requests.php');
    }
    break;

    case 'branches': {
        require('../private/requests/branch_requests.php');

    }
    break;


    case 'services':{
        require('../private/requests/service_request.php');
    }
    break;
    
    case 'branch_services':{
        require('../private/requests/br_service_requests.php');
    }
    break;

    case 'service_employee':{
        require('../private/requests/service_employee_requests.php');
    }
    break;

    case 'tickets':{
        require('../private/requests/tickets_requests.php');
    }
    break;
    
    case 'about_us':{
        require('../private/requests/about_us_requests.php');
    }
    break;
    
    case 'contacts':{
        require('../private/requests/contacts_requests.php');
    }
    break;

    case 'pass_recovery':{
        require('../private/pass_recovery.php');
    }
    break;


    default: {
        $data = "No Section Selected.";
    }
    break;
}

echo(json_encode($data));