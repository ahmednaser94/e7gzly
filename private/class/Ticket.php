<?php
require_once 'Service_Employee.php';


class Ticket extends Service_Employee implements Operations
{
    var $ticket_id, $user_id, $receipt_no, $status, $book_time, $started, $ended, $ticketNo;


    public function Add()
    {
        // check if user already booked this service
        if ($this->isBooked())
            return 'Already Booked';

        // get most recent receipt no
        $this->MostRecentTicket();

        // UPDATE tickets number
        $this->UpdateTicketsNumber();

        return $this->RunDML("INSERT INTO tickets (org_id,branch_id,br_service_id,user_id,receipt_no,status,book_time) VALUES (?,?,?,?,?,'waiting',Now())", [$this->org_id, $this->branch_id, $this->br_service_id, $this->user_id, $this->ticketNo], "Booking Done!");
    }


    public function UpdateTicketsNumber()
    {
        $this->pdo->query('UPDATE statistics SET num = (num + 1) WHERE id =1');
    }


    public function isBooked()
    {
        $check = $this->RUNSearch('SELECT * from tickets WHERE org_id = ? AND branch_id = ? AND br_service_id = ? AND user_id = ? AND `status` = "waiting" ', [$this->org_id, $this->branch_id, $this->br_service_id, $this->user_id]);

        if ($check->rowCount() > 0) {
            $check->closeCursor();
            return true;
        }

        return false;
    }

    public function MostRecentTicket()
    {
        $receiptNo = $this->RUNSearch('SELECT receipt_no as rec from tickets WHERE org_id = ? AND branch_id = ? AND br_service_id = ? ORDER BY receipt_no DESC LIMIT 1', [$this->org_id, $this->branch_id, $this->br_service_id]);

        if ($receiptNo->rowCount() > 0) {
            $res = $receiptNo->fetch();
            $receiptNo->closeCursor();
            $this->ticketNo = (int) $res['rec'] + 1;
        } else {
            $receiptNo->closeCursor();
            $this->ticketNo = 1;
        }
        return true;
    }

    public function Update()
    {
        // code here
    }

    public function Delete()
    {
        return $this->RunDML("DELETE FROM tickets WHERE id = ?", [$this->ticket_id], "Ticket Deleted!");
    }

    public function Search()
    { }

    public function MyTickets()
    {
        $result = $this->RUNSearch('SELECT * FROM mytickets  WHERE user_id =?', [$this->user_id]);

        if ($result->rowCount() > 0) {
            $res = $result->fetchAll();
            $result->closeCursor();
            return $res;
        }
        return false;
    }

    // how many customers are waiting before this customer
    public function WaitingPerServicePerCustomer()
    {
        $result = $this->RUNSearch("SELECT sum( CASE WHEN (status = 'waiting' AND br_service_id = ? AND receipt_no < (SELECT receipt_no FROM tickets WHERE user_id = ? AND br_service_id = ? AND status = 'waiting')) THEN 1 ELSE 0 END ) AS waiting FROM tickets", [$this->br_service_id, $this->user_id, $this->br_service_id]);

        if ($result->rowCount() > 0) {
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }
        return false;
    }


    public function WaitingPerBranch()
    {
        $result = $this->RUNSearch('SELECT SUM(waiting) AS br_waiting FROM br_service_aggregate WHERE org_id = ? AND branch_id = ? GROUP BY branch_id', [$this->org_id, $this->branch_id]);

        if ($result->rowCount() > 0) {
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }
        return false;
    }

    public function WaitingPerOrg()
    {
        $result = $this->RUNSearch('SELECT SUM(waiting) AS org_waiting FROM br_service_aggregate WHERE org_id = ? GROUP BY org_id', [$this->org_id]);

        if ($result->rowCount() > 0) {
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }
        return false;
    }


    // check if there is a pending customer
    public function PendingCustomer()
    {
        $result = $this->RUNSearch('SELECT * FROM tickets WHERE emp_id =? AND status = "pending"', [$this->emp_id]);
        if ($result->rowCount() > 0) {
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }
        return false;
    }

    public function EndPendingCustomer($id)
    {
        $this->RUNDML('UPDATE tickets SET status ="served" , ended = NOW() WHERE id = ?', [$id]);
    }

    public function WaitingPerEmployee()
    {
        $result = $this->RUNSearch('SELECT employee, COUNT(status) as waiting FROM servemp  WHERE emp_id =? AND status = "waiting"', [$this->emp_id]);

        if ($result->rowCount() > 0) {
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }
        return false;
    }

    public function FetchNewCustomer()
    {
        return $this->RUNDML('UPDATE tickets SET status ="pending" , emp_id = ? , started = NOW() WHERE id = (SELECT id FROM newestcustomer WHERE emp_id = ? LIMIT 1)', [$this->emp_id, $this->emp_id]);
    }

    public function CurrentCustomer()
    {
        // check if there is a current customer to get his data
        $result = $this->RUNSearch("SELECT * FROM servemp WHERE emp_id = ? AND status = 'pending'", [$this->emp_id]);

        if ($result->rowCount() > 0) {
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }
        return false;
    }

    // fetch new customer to be served
    public function NextCustomer()
    {
        // check if there is a pending customer
        $pending = $this->PendingCustomer();

        // if there is a pending customer, make it served
        if ($pending)
            $this->EndPendingCustomer($pending['id']);

        // check if there are waiting customers
        $waiting = $this->WaitingPerEmployee();
        if ($waiting['waiting'] < 1)
            return "no waiting";

        // if there are waiting cusotemr then fetch a new one
        $this->FetchNewCustomer();

        // return that fetched customer
        return $this->CurrentCustomer();
    }



    public function TicketDetails()
    {
        // check if there is a current customer to get his data
        $result = $this->RUNSearch("SELECT * FROM ticket_details WHERE chars = ? AND receipt_no = ? AND branch_id = ?", [$this->chars, $this->receipt_no,$this->branch_id]);

        if ($result->rowCount() > 0) {
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }
        return false;
    }


    public function setTicketID($ticket_id)
    {
        return $this->ticket_id = $ticket_id;
    }

    public function getTicketID()
    {
        return $this->ticket_id;
    }

    public function setUserID($user_id)
    {
        return $this->user_id = $user_id;
    }

    public function getUserID()
    {
        return $this->user_id;
    }

    public function setReceiptNO($receipt_no)
    {
        return $this->receipt_no = $receipt_no;
    }

    public function getReceiptNO()
    {
        return $this->receipt_no;
    }


    public function setStatus($status)
    {
        return $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }


    public function setBookTime($book_time)
    {
        return $this->book_time = $book_time;
    }

    public function getBookTime()
    {
        return $this->book_time;
    }


    public function setStarted($started)
    {
        return $this->started = $started;
    }

    public function getStarted()
    {
        return $this->started;
    }

    public function setEnded($ended)
    {
        return $this->ended = $ended;
    }

    public function getEnded()
    {
        return $this->ended;
    }
}
