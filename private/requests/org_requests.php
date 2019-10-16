<?php
require_once "../private/class/Organization.php";
require_once 'filter.php';

session_start();

$org = new Organization();

switch ($_GET['do']) { 

    case 'get_all_organizations':{
        
       $data = $org->Search();

    }
    break;

    case 'get_cat_organizations':{
        
        $org->setCatID(trim($_POST['cat_id']));

       $data = $org->GetCatOrgs();

    }
    break;

    case 'get_organization':{
        
        $org->setOrgID(trim($_POST['org_id']));

       $data = $org->GetOrg();

    }
    break;

    case 'org_update':{
        
        $org->setCatID(trim($_POST['cat_id']));
        $org->setName(trim($_POST['name']));
        $org->setLicense(trim($_POST['license']));
        $org->setURL(trim($_POST['url']));
        $org->setPhone(trim($_POST['phone']));
        
        if(isset($_POST['org_id']))
            $org->setOrgID(trim($_POST['org_id']));
        
        if($_POST['form-btn'] == 'add')
            $data = $org->Add();
        else if($_POST['form-btn'] == 'update')
            $data = $org->Update();
        else if($_POST['form-btn'] == 'delete')
            $data = $org->Delete();

    }
    break;


}
