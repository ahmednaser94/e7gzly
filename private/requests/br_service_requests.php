<?php

require_once '../private/class/branch_service.php';
require_once 'filter.php';

session_start();

$br_serv = new Branch_Service();

switch ($_GET['do']) {

        // update Employee Data
    case 'br_service_update': {
            // general in add or update or delete
            $br_serv->setOrgID(trim($_SESSION['org_id']));
            $br_serv->setBranchID(trim($_SESSION['branch_id']));
            $br_serv->setServiceID(trim($_POST['service_id']));

            // if update
            if (isset($_POST['br_service_id'])) {
                $br_serv->setBranchServiceID(trim($_POST['br_service_id']));
            }

            // in case of update we need to add status and user_id
            if ($_POST['form-btn'] == 'update') {
                $data = $br_serv->Update();
            }

            // in case of delete we need to add user_id
            else if ($_POST['form-btn'] == 'delete') {
                $data = $br_serv->Delete();
            }
            // in case of adding we need password and email 
            else if ($_POST['form-btn'] == 'add') {

                $data = $br_serv->Add();
            }
        }
        break;


        // get branch services details by SESSION
    case 'get_branch_services': {
            $br_serv->setOrgID($_SESSION['org_id']);
            $br_serv->setBranchID($_SESSION['branch_id']);
            $data = $br_serv->getBranchServices();
        }
        break;

        // get branch services details by POST
    case 'get_branch_services_post': {
            $br_serv->setOrgID(trim($_POST['org_id']));
            $br_serv->setBranchID(trim($_POST['branch_id']));
            $data = $br_serv->getBranchServices();
        }
        break;

        // get a branch services details
    case 'get_branch_service_details': {
            $br_serv->setOrgID(trim($_SESSION['org_id']));
            $br_serv->setBranchID(trim($_SESSION['branch_id']));
            $br_serv->setBranchServiceID(trim($_POST['br_service_id']));
            $data = $br_serv->getBranchServiceDetails();
        }
        break;

        // get aggregate services inside a branch 
    case 'get_aggregate_br_serv': {
            $br_serv->setOrgID(trim($_SESSION['org_id']));
            $br_serv->setBranchID(trim($_SESSION['branch_id']));
            $data = $br_serv->getAggregateBrServices();
        }
        break;

        // get count of branch services per branch
    case 'count_br_services_branch': {
            $br_serv->setOrgID(trim($_SESSION['org_id']));
            $br_serv->setBranchID(trim($_SESSION['branch_id']));
            $data = $br_serv->BranchServiceCountPerBranch();
        }
        break;

        // get details about a service 
    case 'get_br_serv_status': {
            $br_serv->setOrgID(trim($_POST['org_id']));
            $br_serv->setBranchID(trim($_POST['branch_id']));
            $br_serv->setBranchServiceID(trim($_POST['br_service_id']));
            $data = $br_serv->getBranchServiceStatus();
        }
        break;
}
