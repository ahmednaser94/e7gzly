<?php
require_once 'Branch.php';


class Service extends Branch implements Operations
{

    var $service_id, $details, $time, $chars;



    public function Add()
    {
        // check if this branch already exists

        if ($this->CheckService())
            return "exists";
        
        return $this->RunDML("INSERT INTO services (org_id, name,details,time,chars) VALUES (?,?,?,?,?)", [$this->org_id, $this->name, $this->details, $this->time, $this->chars], "Service Added!");
    }

    public function Update()
    {

        return $this->RunDML("UPDATE services SET name = ?, details = ?, time = ?, chars = ? WHERE id = ?", [$this->name, $this->details, $this->time, $this->chars, $this->service_id], "Service Updated!");
    }

    public function Delete()
    {
        return $this->RunDML("DELETE FROM services WHERE id = ?", [$this->service_id], "Service Deleted!");
    }

    public function Search()
    { }

    // get all services inside an organization
    public function getServices()
    {

        $result = $this->RUNSearch("SELECT * FROM services WHERE org_id = ? ORDER BY name ASC", [$this->org_id]);
        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }
    public function getService()
    {

        $result = $this->RUNSearch("SELECT * FROM services WHERE org_id = ? AND id = ?", [$this->org_id, $this->service_id]);
        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    public function CountServices()
    {

        $result = $this->RUNSearch("SELECT COUNT(id) as serv_count FROM services WHERE org_id = ?", [$this->org_id]);
        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    public function CheckService()
    {
        $check = $this->RUNSearch('SELECT org_id, name FROM services WHERE org_id =? AND name = ?', [$this->org_id, $this->name]);

        if ($check->rowCount() > 0) {
            $check->closeCursor();
            return true;
        }
        return false;
    }

    public function setServiceID($service_id)
    {
        return $this->service_id = $service_id;
    }

    public function getServiceID()
    {
        return $this->service_id;
    }

    public function setDetails($details)
    {
        return $this->details = $details;
    }

    public function getDetails()
    {
        return $this->details;
    }

    public function setTime($time)
    {
        return $this->time = $time;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setChars($chars)
    {
        return $this->chars = $chars;
    }

    public function getChars()
    {
        return $this->chars;
    }
}
