<?php
require_once 'branch_service.php';


class Service_Employee extends Branch_Service implements Operations
{
    var $service_employee_id, $emp_id, $window;


    // check if employee has a window and compare it with input window 
    public function checkEmployeeWindow()
    {
        $result = $this->RUNSearch('SELECT * FROM service_employees WHERE org_id = ? AND emp_id = ?', [$this->org_id, $this->emp_id]);

        if ($result->rowCount() > 0) {
            $windowCheck = $result->fetch();
            $result->closeCursor();
            if ($windowCheck['window'] != $this->window) {
                return false;
            }
        }
        $result->closeCursor();
        return true;
    }


    public function checkWindow()
    {
        $result = $this->RUNSearch('SELECT * FROM service_employees WHERE org_id = ? AND branch_id = ? AND window = ? ', [$this->org_id, $this->branch_id, $this->window]);

        if ($result->rowCount() > 0) {
            $windowCheck = $result->fetch();
            $result->closeCursor();
            if ($windowCheck['emp_id'] != $this->emp_id)
                return false;
        }
        $result->closeCursor();
        return true;
    }


    public function Add()
    {
        // check if this employee window changed
        $checkEmpWindow = $this->checkEmployeeWindow();

        // check if exists service employee window changed
        if (!$checkEmpWindow) {
            return "window change";
        }
        if ($checkEmpWindow) {

            // check if window has an employee
            $checkwindow = $this->checkWindow();

            if (!$checkwindow) {
                return "window exists";
            }
        }

        // link employee into a service
        return $this->RunDML('INSERT INTO service_employees (org_id, branch_id,br_service_id, emp_id, window) VALUES (?,?,?,?,?)', [$this->org_id, $this->branch_id, $this->br_service_id, $this->emp_id, $this->window], 'Employee successfully Added!');
    }

    public function Update()
    {
        $checkwindow = $this->checkEmployeeWindow();

        if (!$checkwindow) {
            return "window exists";
        }

        // check if the window already assigned to employee
        $check2 = $this->RUNSearch('SELECT * FROM service_employees WHERE org_id = ? AND branch_id = ? AND window = ? ', [$this->org_id, $this->branch_id, $this->window]);

        // check if exists service employee window changed
        if ($check2->rowCount() > 0) {
            $windowCheck = $check2->fetch();
            $check2->closeCursor();
            if ($windowCheck['emp_id'] != $this->emp_id)
                return "window exists";
        }

        return $this->RunDML("UPDATE service_employees SET br_service_id = ?, emp_id = ?, window = ?  WHERE id=?", [$this->br_service_id, $this->emp_id, $this->window, $this->service_employee_id], "Service Updated!");
    }

    public function Delete()
    {
        return $this->RunDML("DELETE FROM service_employees WHERE id = ?", [$this->service_employee_id], "Employee Deleted!");
    }

    public function Search()
    { }

    public function getServiceEmployeeDetails()
    {
        $result = $this->RUNSearch("SELECT * from getserviceemployee WHERE org_id = ? AND branch_id = ? AND  id=? ", [$this->org_id, $this->branch_id, $this->service_employee_id]);

        // return data if there is any
        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    public function getServiceEmployees()
    {
        $result = $this->RUNSearch('SELECT * from getserviceemployee WHERE org_id= ? AND branch_id = ?', [$this->org_id, $this->branch_id]);

        // return data if there is any
        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    public function CountOrgServEmp()
    {
        $result = $this->RUNSearch('SELECT SUM(serv_emp) as total_serv_emp FROM count_serv_emp WHERE org_id = ?', [$this->org_id]);

        // return data if there is any
        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    public function CountBranchServEmp()
    {
        $result = $this->RUNSearch('SELECT serv_emp FROM count_serv_emp WHERE org_id = ? AND branch_id = ?', [$this->org_id, $this->branch_id]);

        // return data if there is any
        return $result->rowCount() > 0 ? $result->fetch() : false;
    }





    public function setServiceEmpID($service_employee_id)
    {
        return $this->service_employee_id = $service_employee_id;
    }

    public function getServiceEmpID()
    {
        return $this->service_employee_id;
    }


    public function setEmpID($emp_id)
    {
        return $this->emp_id = $emp_id;
    }

    public function getEmpID()
    {
        return $this->emp_id;
    }


    public function setWindow($window)
    {
        return $this->window = $window;
    }

    public function getWindow()
    {
        return $this->window;
    }
}
