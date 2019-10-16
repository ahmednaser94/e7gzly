<?php
require_once "../private/class/About_us.php";
require_once 'filter.php';

session_start();

$ab = new About_us();

switch ($_GET['do']) {

    case 'get_about_us': {
        $data = $ab->Search();

    }
    break;

    case 'Update_about_us': {
        
        $ab->setDetails(trim($_POST['details']));
        if($_POST['form-btn'] == 'update')
            $data = $ab->Update();
        else if($_POST['form-btn'] == 'add')
            $data = $ab->Add();
        else if($_POST['form-btn'] == 'delete')
            $data = $ab->Delete();
    }
    break;

    case 'statistics': {
        
            $data = $ab->getStats();
    }
    break;

    case 'admin_statistics': {
        
            $data = $ab->getAdminStats();
    }
    break;


}