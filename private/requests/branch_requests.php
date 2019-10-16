<?php
require_once "../private/class/Branch.php";
require_once 'filter.php';
session_start();

$br = new Branch();

switch ($_GET['do']) {

    // get branches areas
    case 'get_branches_areas':{
        $data = $br->getAreas();;
    }
    break;

    // get branches of organization in register page
    case 'get_branches_post':{
        $br->setOrgID($_POST['organization']);
        $data = $br->GetBranches();
    }
    break;
    
    // get details of a branch inside branch update page
    case 'get_branch_details':{
        $br->setOrgID($_SESSION['org_id']);
        $br->setBranchID($_POST['branch_id']);
        $data = $br->GetBranch();
    }
    break;
    

    // Add - Update or delete a branch
    case 'update_branch':{
        $br->setOrgID($_SESSION['org_id']);
        $br->setAreaID($_POST['area']);
        $br->setBranchCode($_POST['br_code']);
        $br->setName($_POST['_name']);
        $br->setAddress($_POST['address']);
        $br->setPhone($_POST['phone']);
        

        if ($_POST['form-btn'] == 'add')
            $data = $br->Add();
        else{
            $br->setBranchID($_POST['br_id']);
            
            if ($_POST['form-btn'] == 'update') 
                $data = $br->Update();
            else if ($_POST['form-btn'] == 'delete')
                $data = $br->Delete();
        }
        
    }
    break;

    // get branches of organization in org user page
    case 'get_org_branches':{
        $br->setOrgID($_SESSION['org_id']);
        $data = $br->GetBranches();
    }
    break;

    // get branches of organization in org user page
    case 'count_branches':{
        $br->setOrgID($_SESSION['org_id']);
        $data = $br->CountBranches();
    }
    break;
    
    // check if phone is exists in DB
    case "check_br_phone": {
        $br->setOrgID($_SESSION['org_id']);
        $br->setPhone(trim($_POST['phone']));
        $data = $br->checkBranchPhone();
    }
    break;


    default:
        # code...
        break;
}
