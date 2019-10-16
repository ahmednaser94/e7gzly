<?php
require_once 'Category.php';

class Organization extends Category implements Operations
{

    var $org_id, $license, $URL, $phone;


    public function Add()
    {
        // check if this email already exists
        $check = $this->LicenseCheck();

        if (!$check)
            return $this->RUNDML('INSERT INTO organizations (cat_id,name,license,url,phone) VALUES (?,?,?,?,?)', [$this->cat_id, $this->name, $this->license, $this->URL, $this->phone], 'organization added!');
        else
            return $check;
    }

    // check if organization already registered by license
    public function LicenseCheck()
    {
        $result = $this->RUNSearch("SELECT * FROM organizations WHERE license =?", [$this->license]);

        return $result->rowCount() > 0 ? "This license already exists!" : false;
    }

    public function Update()
    {
        return $this->RUNDML('UPDATE organizations SET cat_id = ?, name = ?, license = ?,url= ?, phone=? WHERE id = ?', [$this->cat_id, $this->name, $this->license, $this->URL, $this->phone, $this->org_id], 'Organization Updated!');
    }

    public function Delete()
    {
        return $this->RUNDML('DELETE FROM organizations WHERE id = ?', [$this->org_id], 'Organization Deleted!');
    }

    public function Search()
    {
        $result = $this->RUNSearch("SELECT * FROM getorgs");
        // return data if there is any

        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    public function GetCatOrgs()
    {
        $result = $this->RUNSearch('SELECT * FROM organizations WHERE cat_id = ?', [$this->cat_id]);

        // return data if there is any
        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    public function GetOrg()
    {
        $result = $this->RUNSearch('SELECT * FROM getorgs WHERE id = ?', [$this->org_id]);

        // return data if there is any
        return $result->rowCount() > 0 ? $result->fetch() : false;
    }



    public function setOrgID($org_id)
    {
        return $this->org_id = $org_id;
    }

    public function getOrgID()
    {
        return $this->org_id;
    }

    public function setURL($URL)
    {
        return $this->URL = $URL;
    }

    public function getURL()
    {
        return $this->URL;
    }

    public function setLicense($license)
    {
        return $this->license = $license;
    }

    public function getLicense()
    {
        return $this->license;
    }

    public function setPhone($phone)
    {
        return $this->phone = $phone;
    }

    public function getPhone()
    {
        return $this->phone;
    }
}
