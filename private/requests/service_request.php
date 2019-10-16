<?php
require_once "../private/class/Service.php";
require_once 'filter.php';

session_start();
$serv = new Service();

switch ($_GET['do']) {

        // get branch services details for each window
    case 'get_services': {
            $serv->setOrgID(trim($_SESSION['org_id']));
            $data = $serv->getServices();
        }
        break;

    case 'get_service': {
            $serv->setOrgID(trim($_SESSION['org_id']));
            $serv->setServiceID(trim($_POST['service_id']));
            $data = $serv->getService();
        }
        break;

    case 'count_services': {
            $serv->setOrgID(trim($_SESSION['org_id']));
            $data = $serv->CountServices();
        }
        break;

    case 'service_update': {
            $serv->setOrgID(trim($_SESSION['org_id']));
            $serv->setName(trim($_POST['name']));
            $serv->setDetails(trim($_POST['details']));
            $serv->setTime(trim($_POST['time']));
            $serv->setChars(trim($_POST['chars']));

            if ($_POST['form-btn'] == 'add')
                $data = $serv->Add();
            else if ($_POST['form-btn'] == 'update') {
                $serv->setServiceID(trim($_POST['service_id']));
                $data = $serv->Update();
            } else if ($_POST['form-btn'] == 'delete') {
                $serv->setServiceID(trim($_POST['service_id']));
                $data = $serv->Delete();
            }
        }
        break;
}
