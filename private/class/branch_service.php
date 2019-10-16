<?php
require_once 'Service.php';


class Branch_Service extends Service implements Operations
{

    var $br_service_id;


    public function Add()
    {
        // check if this service already exists

        $check = $this->RUNSearch('SELECT * FROM branch_services WHERE org_id = ? AND branch_id = ? AND service_id =? ', [$this->org_id, $this->branch_id, $this->service_id]);

        if ($check->fetch()) {
            return "exists";
        } else {

            return $this->RunDML('INSERT INTO branch_services (org_id, branch_id,service_id) VALUES (?,?,?)', [$this->org_id, $this->branch_id, $this->service_id], 'Service successfully Added!');
        }
    }

    public function Update()
    {
        return $this->RunDML("UPDATE branch_services  SET service_id = ? WHERE id = ?", [$this->service_id, $this->br_service_id], "Service Updated!");
    }

    public function Delete()
    {
        return $this->RunDML("DELETE FROM branch_services WHERE id = ?", [$this->br_service_id], "Service Deleted!");
    }

    public function Search()
    { }

    public function BranchServiceCountPerBranch()
    {
        $result = $this->RUNSearch('SELECT count(service_id) as count_br_services FROM branch_services WHERE org_id = ? AND branch_id = ? GROUP BY branch_id
        ', [$this->org_id,$this->branch_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    public function getBranchServiceDetails()
    {
        $result = $this->RUNSearch('SELECT * FROM branch_services WHERE id =?', [$this->br_service_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    public function getBranchServices()
    {
        $result = $this->RUNSearch('SELECT bs.id, bs.org_id, bs.branch_id, bs.service_id,s.`name` FROM branch_services bs JOIN services s ON bs.service_id = s.id WHERE bs.org_id =? AND bs.branch_id = ? ORDER BY s.name ASC', [$this->org_id, $this->branch_id]);

        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    public function getAggregateBrServices()
    {
        $result = $this->RUNSearch('SELECT * FROM br_service_aggregate WHERE org_id =? AND branch_id = ?', [$this->org_id, $this->branch_id]);

        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    public function getBranchServiceStatus()
    {
        $result = $this->RUNSearch('SELECT * FROM br_service_aggregate WHERE org_id =? AND branch_id = ? AND id = ?', [$this->org_id, $this->branch_id, $this->br_service_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }




    // set and get

    public function setBranchServiceID($br_service_id)
    {
        return $this->br_service_id = $br_service_id;
    }
    public function getBranchServiceID()
    {
        return $this->br_service_id;
    }
}
