<?php
require_once 'Area.php';

class Branch extends Area implements Operations
{

    var $branch_id, $code, $address;


    public function checkBranch()
    {
        $result = $this->RUNSearch('SELECT org_id, code FROM branches WHERE org_id =? AND code = ?', [$this->org_id, $this->code]);

        return $result->rowCount() > 0 ? "This branch already exists" : false;
    }

    public function Add()
    {
        // check if this branch already exists
        $check = $this->checkBranch();
        if (!$check)
            return $this->RunDML('INSERT INTO branches (org_id, code, name, address, area_id,phone) VALUES (?,?,?,?,?,?)', [$this->org_id, $this->code, $this->name, $this->address, $this->getAreaID(), $this->phone], 'Branch successfully Added!');

        else
            return $check;
    }

    // update branch data
    public function Update()
    {
        return $this->RunDML('UPDATE branches SET org_id =?, code = ? , name = ?, address = ?, area_id = ?, phone = ? WHERE id = ?', [$this->org_id, $this->code, $this->name, $this->address, $this->area_id, $this->phone, $this->branch_id], "Branch Updated successfully!");
    }

    // delete branch
    public function Delete()
    {
        return $this->RunDML('DELETE FROM branches WHERE org_id =? AND  id = ?', [$this->org_id, $this->branch_id], "Branch Deleted successfully!");
    }

    public function Search()
    { }

    // get branches for specific organization
    public function GetBranches()
    {
        $result = $this->RUNSearch('SELECT * FROM getBranchesInfo WHERE org_id =?', [$this->org_id]);

        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    // get details about a branch
    public function GetBranch()
    {
        $result = $this->RUNSearch("SELECT * FROM getBranchesInfo WHERE org_id =? AND br_id =?", [$this->org_id, $this->branch_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    // get branches count of an org
    public function CountBranches()
    {
        $result = $this->RUNSearch("SELECT COUNT(id) as br_count FROM branches WHERE org_id =?", [$this->org_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    // check if Phone exists by AJAX function
    public function checkBranchPhone()
    {
        $result = $this->RUNSearch('SELECT * FROM branches WHERE org_id =? AND phone = ?', [$this->org_id, $this->phone]);
        return $result->rowCount() > 0 ? "exists" : "available";
    }


    public function setBranchID($branch_id)
    {
        return $this->branch_id = $branch_id;
    }

    public function getBranchID()
    {
        return $this->branch_id;
    }
    public function setBranchCode($code)
    {
        return $this->code = $code;
    }

    public function getBranchCode()
    {
        return $this->code;
    }

    public function setAddress($address)
    {
        return $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }
}
