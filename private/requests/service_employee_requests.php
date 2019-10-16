<?php
require_once "../private/class/Service_Employee.php";
require_once 'filter.php';

session_start();

$serv_emp = new Service_Employee();

switch ($_GET['do']) {

    case 'service_employee_update': {
        $serv_emp->setOrgID(trim($_SESSION['org_id']));
        $serv_emp->setBranchID(trim($_SESSION['branch_id']));
        $serv_emp->setBranchServiceID(trim($_POST['br_service_id']));
        $serv_emp->setEmpID(trim($_POST['emp']));
        $serv_emp->setWindow(trim($_POST['window']));

        if(isset($_POST['service_employee_id']))
            $serv_emp->setServiceEmpID(trim($_POST['service_employee_id']));

        if ($_POST['form-btn'] == 'update') { 
            $data = $serv_emp->Update();
        }
        if ($_POST['form-btn'] == 'delete') {
            $data = $serv_emp->Delete();
        }
        if ($_POST['form-btn'] == 'add') { 
            
            $data = $serv_emp->Add();

        }
    }
    break;

    case 'get_serv_employee_data':{
        $serv_emp->setOrgID(trim($_SESSION['org_id']));
        $serv_emp->setBranchID(trim($_SESSION['branch_id']));
        $serv_emp->setServiceEmpID(trim($_POST['service_employee_id']));
        
        $data = $serv_emp->getServiceEmployeeDetails();

    }
    break;

    case 'get_serv_employees':{
        $serv_emp->setOrgID(trim($_SESSION['org_id']));
        $serv_emp->setBranchID(trim($_SESSION['branch_id']));
        
        $data = $serv_emp->getServiceEmployees();

    }
    break;


    case 'count_org_serv_employees':{
        $serv_emp->setOrgID(trim($_SESSION['org_id']));
        
        $data = $serv_emp->CountOrgServEmp();

    }
    break;

    case 'count_branch_serv_employees':{
        $serv_emp->setOrgID(trim($_SESSION['org_id']));
        $serv_emp->setBranchID(trim($_SESSION['branch_id']));
        
        $data = $serv_emp->CountBranchServEmp();

    }
    break;



}