<?php
require_once "../private/class/Contacts.php";
require_once 'filter.php';

session_start();

$con = new Contacts();

switch ($_GET['do']) {

    case 'get_contacts': {
            $data = $con->Search();
        }
        break;

    case 'contacts_update': {
            $con->setPhone(trim($_POST['phone']));
            $con->setEmail(trim($_POST['email']));
            $con->setFB(trim($_POST['fb']));
            $con->setTwitter(trim($_POST['twitter']));
            $con->setInstagram(trim($_POST['instagram']));
            $con->setYoutube(trim($_POST['youtube']));
            $con->setLinkedin(trim($_POST['linkedin']));

            if ($_POST['form-btn'] == 'add')
                $data = $con->add();
            else if ($_POST['form-btn'] == 'update')
                $data = $con->Update();
            else if ($_POST['form-btn'] == 'delete')
                $data = $con->Delete();
        }
        break;


}
