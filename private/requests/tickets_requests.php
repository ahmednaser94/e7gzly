<?php
require_once "../private/class/Ticket.php";
require_once 'filter.php';

session_start();

$t = new Ticket();

switch ($_GET['do']) {


        // Add ticket
    case 'add_ticket': {
            $t->setOrgID(trim($_POST['org_id']));
            $t->setBranchID(trim($_POST['branch_id']));
            $t->setBranchServiceID(trim($_POST['br_service_id']));
            $t->setUserID($_SESSION['user_id']);

            $data = $t->Add();
        }
        break;

        // delete ticket
    case 'delete_ticket': {
            $t->setTicketID(trim($_POST['ticket_id']));

            $data = $t->Delete();
        }
        break;

        // get all tickets of a customer
    case 'my_tickets': {
            $t->setUserID($_SESSION['user_id']);

            $data = $t->MyTickets();
        }
        break;

        // get all waiting customers per employee
    case 'get_waiting_per_emp': {
            $t->setEmpID($_SESSION['user_id']);

            $data = $t->WaitingPerEmployee();
        }
        break;

        // next customer
    case 'next_customer': {
            $t->setEmpID($_SESSION['user_id']);

            $data = $t->NextCustomer();
        }
        break;

        // get current customer
    case 'current_customer': {
            $t->setEmpID($_SESSION['user_id']);

            $data = $t->CurrentCustomer();
        }
        break;

        // get current customer
    case 'waiting_service_customer': {
            $t->setUserID($_SESSION['user_id']);
            $t->setBranchServiceID($_POST['br_service_id']);

            $data = $t->WaitingPerServicePerCustomer();
        }
        break;


        // get waiting per branch
    case 'waiting_per_branch': {
            $t->setOrgID($_SESSION['org_id']);
            $t->setBranchID($_SESSION['branch_id']);

            $data = $t->WaitingPerBranch();
        }
        break;

        // get waiting per org
    case 'waiting_per_org': {
            $t->setOrgID($_SESSION['org_id']);

            $data = $t->WaitingPerOrg();
        }
        break;

        // get details about a ticket
    case 'ticket_details': {
            $t->setBranchID($_SESSION['branch_id']);
            $t->setChars($_POST['chars']);
            $t->setReceiptNO($_POST['receipt_number']);

            $data = $t->TicketDetails();
        }
        break;
}
