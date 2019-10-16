<?php
require_once 'Database.php';
require_once 'Operations.php';

class User extends Database implements Operations
{

    var $user_id, $org_id, $branch_id, $comp_id, $name, $email, $password, $new_password, $phone, $address, $manager, $user_type_id, $status;


    // add users via registration form 
    public function Add()
    {
        // check first if the user exists
        $checkUserExists = $this->UserExists();
        if (!$checkUserExists) {
            switch ($this->user_type_id) {
                    // customer
                case 1: {
                        return $this->RunDML("INSERT INTO users (name,email,password,phone,address,user_type_id,status) VALUES(?,?,?,?,?,?,'approved')", [$this->name, $this->email, $this->hashedPass($this->password), $this->phone, $this->address, $this->user_type_id], "User has been registered successfully!");
                    }
                    break;
                    // employee
                case 2: {
                        return $this->RunDML("INSERT INTO users (org_id,branch_id,comp_id,name,email,password,phone,address,user_type_id,status) VALUES(?,?,?,?,?,?,?,?,?,'pending')", [$this->org_id, $this->branch_id, $this->comp_id, $this->name, $this->email, $this->hashedPass($this->password), $this->phone, $this->address, $this->user_type_id], "User has been registered successfully, please wait for your company's Approval!");
                    }
                    break;
                    // branch manager
                case 3: {
                        $checkManager = $this->CheckBranchManager();
                        if (!$checkManager)
                            return $this->RunDML("INSERT INTO users (org_id,branch_id,comp_id,name,email,password,phone,address,user_type_id,status) VALUES(?,?,?,?,?,?,?,?,?,'pending')", [$this->org_id, $this->branch_id, $this->comp_id, $this->name, $this->email, $this->hashedPass($this->password), $this->phone, $this->address, $this->user_type_id], "User has been registered successfully, please wait for your company's Approval!");
                        else
                            return $$checkManager;
                    }
                    break;

                    // organization
                case 4: {
                        // check if organization already exists 
                        $orgCheck = $this->CheckOrganization();
                        if (!$orgCheck)
                            return $this->RunDML("INSERT INTO users (org_id,name,email,password,phone,address,user_type_id,status) VALUES(?,?,?,?,?,?,4,'approved')", [$this->org_id, $this->name, $this->email, $this->hashedPass($this->password), $this->phone, $this->address], "User has been registered successfully!");
                        else
                            return $orgCheck;
                    }
                    break;

                default:
                    return "User type must be selected!";
                    break;
            }
        } else
            return $checkUserExists;
    }

    // add employees from org user
    public function AddEmployee()
    {
        switch ($this->user_type_id) {
            case 2: {
                    if ($this->manager == '')
                        return $this->RunDML("INSERT INTO users (org_id,branch_id,comp_id,name,email,password,phone,address,user_type_id,status) VALUES(?,?,?,?,?,?,?,?,?,'approved')", [$this->org_id, $this->branch_id, $this->comp_id, $this->name, $this->email, $this->hashedPass($this->password), $this->phone, $this->address, $this->user_type_id], "User has been registered successfully");

                    // user has branch and manager
                    else
                        return $this->RunDML("INSERT INTO users (org_id,branch_id,comp_id,name,email,password,phone,address,manager,user_type_id,status) VALUES(?,?,?,?,?,?,?,?,?,?,'approved')", [$this->org_id, $this->branch_id, $this->comp_id, $this->name, $this->email, $this->hashedPass($this->password), $this->phone, $this->address, $this->manager, $this->user_type_id], "User has been registered successfully");
                }
                break;

            case 3: {
                    // user has branch but no manager
                    $checkManager = $this->CheckBranchManager();
                    if (!$checkManager)
                        return $this->RunDML("INSERT INTO users (org_id,branch_id,comp_id,name,email,password,phone,address,user_type_id,status) VALUES(?,?,?,?,?,?,?,?,?,'approved')", [$this->org_id, $this->branch_id, $this->comp_id, $this->name, $this->email, $this->hashedPass($this->password), $this->phone, $this->address, $this->user_type_id], "User has been registered successfully");
                    else
                        return $checkManager;
                }
                break;

            default:
                return 'select the right user type';
                break;
        }
    }


    // delete any user using user ID
    public function Delete()
    {
        return $this->RunDML("DELETE FROM users WHERE user_id= ?", [$this->user_id], "User has been successfully removed!");
    }

    public function Search()
    { }

    // Delete user
    public function DeleteEmployee()
    {
        return $this->RunDML("DELETE FROM users WHERE user_id= ? AND org_id = ?", [$this->user_id, $this->org_id], "User has been successfully removed!");
    }

    public function UserLogin()
    {
        $login = $this->RUNSearch("SELECT * FROM users  WHERE email =? ", [$this->email]);
        if ($login->rowCount() != 1)
            return "email";
        else {
            $result = $login->fetch();
            return $this->verifyPass($this->password, $result['password']) ? $result : "password";
        }
    }

    // Update user data by organization User
    public function Update()
    {
        switch ($this->user_type_id) {
            case 1: {
                    return $this->RUNDML("UPDATE users SET name = ?, phone = ?, address = ? WHERE user_id = ? ", [$this->name, $this->phone, $this->address, $this->user_id], "User has been successfully updated!");
                }
                break;

            case 2:
            case 3: {
                    // if user has no branch
                    if ($this->branch_id == '') {
                        return $this->RUNDML("UPDATE users SET comp_id = ?, name = ?, phone = ?, address = ?, user_type_id = ?, status = ? WHERE user_id = ? ", [$this->comp_id, $this->name, $this->phone, $this->address, $this->user_type_id, $this->status, $this->user_id], "User has been successfully updated!");
                    }
                    // user has branch
                    else {
                        // user has no manager
                        if ($this->manager == '')
                            return $this->RUNDML("UPDATE users SET branch_id = ?, comp_id = ?, name = ?, phone = ?, address = ?, user_type_id = ?, status = ? WHERE user_id = ? ", [$this->branch_id, $this->comp_id, $this->name, $this->phone, $this->address, $this->user_type_id, $this->status, $this->user_id], "User has been successfully updated!");
                        // user has manager
                        else
                          if ($this->user_id == $this->manager)
                            return "You can't assign the same employee as a manager for himself\herself";
                        else
                            return $this->RUNDML("UPDATE users SET branch_id = ?, comp_id = ?, name = ?, phone = ?, address = ?, manager = ?, user_type_id = ?, status = ? WHERE user_id = ? ", [$this->branch_id, $this->comp_id, $this->name, $this->phone, $this->address, $this->manager, $this->user_type_id, $this->status, $this->user_id], "User has been successfully updated!");
                    }
                }
                break;

            case 4: {
                    return $this->RUNDML("UPDATE users SET org_id = ?, name = ?, phone = ?, address = ? WHERE user_id = ? AND user_type_id = 4", [$this->org_id, $this->name, $this->phone, $this->address, $this->user_id], "User has been successfully updated!");
                }
                break;

            default:
                return "User type must be selected!";
                break;
        }
    }

    // check if email exists by AJAX function
    public function checkUserEmail()
    {
        $result = $this->RUNSearch('SELECT * FROM users WHERE email =?', [$this->email]);
        return $result->rowCount() > 0 ? "exists" : "available";
    }

    // check if Phone exists by AJAX function
    public function checkUserPhone()
    {
        $result = $this->RUNSearch('SELECT * FROM users WHERE phone = ?', [$this->phone]);
        return $result->rowCount() > 0 ? "exists" : "available";
    }

    // check if Phone exists by AJAX function
    public function checkPhoneBeforeUodate()
    {
        $result = $this->RUNSearch('SELECT * FROM users WHERE phone = ?', [$this->phone]);
        return $result->rowCount() > 0 ? "exists" : "available";
    }

    // check if company ID exists by AJAX function
    public function checkUserID()
    {
        $result = $this->RUNSearch('SELECT * FROM users WHERE (org_id = ? AND comp_id = ?)', [$this->org_id, $this->comp_id]);
        return $result->rowCount() > 0 ? "exists" : "available";
    }


    public function UserExists()
    {
        $result = $this->RUNSearch("SELECT * FROM users  WHERE email =? OR phone = ? OR (org_id = ? AND comp_id = ?)", [$this->email, $this->phone, $this->org_id, $this->comp_id]);

        if ($result->rowCount() > 0) {
            $res = $result->fetch();
            $result->closeCursor();
            if ($res['email'] == $this->email)
                return ("This Email already Exists!");
            else if ($res['phone'] == $this->phone)
                return ("This Phone already Exists!");
            else if ($res['org_id'] == $this->org_id && $res['comp_id'] == $this->comp_id)
                return ("This Employee ID already Exists!");
        }
        return false;
    }

    // check if Branch manager exists
    public function CheckBranchManager()
    {
        $result = $this->RUNSearch("SELECT * FROM users  WHERE org_id = ? AND branch_id = ? and user_type_id = 3", [$this->org_id, $this->branch_id]);
        return $result->rowCount() > 0 ? "This branch already has a manager, contact your organization!" : false;
    }

    // check if organization exists
    public function CheckOrganization()
    {
        $result = $this->RUNSearch('SELECT * FROM users WHERE org_id = ? AND user_type_id = 4', [$this->org_id]);
        return $result->rowCount() > 0 ? "This Organization already has a user!" : false;
    }

    // show all employees inside an organization
    public function GetEmployees()
    {
        $result = $this->RUNSearch('SELECT * FROM getAllEmployees WHERE org_id = ?', [$this->org_id]);


        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    // get all data about employee
    public function GetEmployee()
    {
        $result = $this->RUNSearch('SELECT * FROM getAllEmployees WHERE org_id = ? AND user_id = ?', [$this->org_id, $this->user_id]);


        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    // show all managers inside a branch
    public function GetManagers()
    {
        $result = $this->RUNSearch('SELECT user_id, name FROM users WHERE org_id = ? AND branch_id = ? AND user_type_id = 3 AND status ="approved"', [$this->org_id, $this->branch_id]);

        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    // show all Employees inside a branch
    public function GetBranchEmployees()
    {
        $result = $this->RUNSearch("SELECT user_id, comp_id, emp_name, email, phone  FROM getallemployees WHERE org_id = ? AND branch_id = ? AND user_type_id = 2 AND status ='approved'", [$this->org_id, $this->branch_id]);

        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    // get Employees count a branch
    public function CountOrgEmployees()
    {
        $result = $this->RUNSearch("SELECT SUM(branch_emp) as employees, SUM(org_managers) as managers FROM count_employees WHERE org_id = ? GROUP BY org_id", [$this->org_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    // get Employees count a branch
    public function CountBranchEmployees()
    {
        $result = $this->RUNSearch("SELECT branch_emp FROM count_employees WHERE org_id = ? AND branch_id = ?
        ", [$this->org_id, $this->branch_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    // get Pending Employees count 
    public function CountPendingEmployees()
    {
        $result = $this->RUNSearch("SELECT COUNT(user_id) as pending FROM users WHERE org_id = 6 and status = 'pending'
        ", [$this->org_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    // show all Organization Users
    public function getOrgUsers()
    {
        $result = $this->RUNSearch("SELECT *  FROM orgusers", []);

        return $result->rowCount() > 0 ? $result->fetchAll() : false;
    }

    // get Organization User data
    public function getOrgUser()
    {
        $result = $this->RUNSearch("SELECT *  FROM orgusers WHERE user_id = ?", [$this->user_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    // get info for profile
    public function getProfile()
    {
        $result = $this->RUNSearch('SELECT * FROM getProfile WHERE user_id = ?', [$this->user_id]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    // get user info in recovery
    public function getUser()
    {
        $result = $this->RUNSearch("SELECT user_id, name, email, phone FROM users WHERE email =? ", [$this->email]);

        return $result->rowCount() > 0 ? $result->fetch() : false;
    }

    // Uodate password in recovery
    public function RecoveryPass()
    {
        return $this->RUNDML("UPDATE users SET password = ? WHERE user_id = ?", [$this->hashedPass($this->new_password), $this->user_id], "password Updated successfully!");
    }

    public function GetUserPassword()
    {
        $result = $this->RUNSearch('SELECT password FROM users WHERE user_id = ?', [$this->user_id]);
        return $result->fetch();
    }

    // Update Password - INCOMPLETE
    public function updatePassword()
    {
        $res = $this->GetUserPassword();

        // check if the old password is correct
        if ($this->verifyPass($this->password, $res['password'])) {

            // check to not let the user update the same password
            if ($this->verifyPass($this->new_password, $res['password'])) {
                return "You can't choose the same old password";
            }
            return $this->RUNDML("UPDATE users SET password = ? WHERE user_id = ?", [$this->hashedPass($this->new_password), $this->user_id], "password Updated successfully!");
        } else {
            return "Incorrect old password!";
        }
    }


    // set and get
    public function setUserID($id)
    {
        return $this->user_id = $id;
    }

    public function getUserID()
    {
        return $this->user_id;
    }

    public function setOrgID($org_id)
    {
        return $this->org_id = $org_id;
    }

    public function getOrgID()
    {
        return $this->org_id;
    }

    public function setBranchID($branch_id)
    {
        return $this->branch_id = $branch_id;
    }

    public function getBranchID()
    {
        return $this->branch_id;
    }

    public function setCompID($comp_id)
    {
        return $this->comp_id = $comp_id;
    }
    public function getCompID()
    {
        return $this->comp_id;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEmail($email)
    {
        return $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        return $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setNewPassword($new_password)
    {
        return $this->new_password = $new_password;
    }

    public function getNewPassword()
    {
        return $this->new_password;
    }

    public function hashedPass($password)
    {

        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPass($password, $DBpassword)
    {

        return password_verify($password, $DBpassword);
    }

    public function setPhone($phone)
    {
        return $this->phone = $phone;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setAddress($address)
    {
        return $this->address = $address;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setManager($manager)
    {
        return $this->manager = $manager;
    }
    public function getManager()
    {
        return $this->manager;
    }

    public function setUserType($user_type_id)
    {
        return $this->user_type_id = $user_type_id;
    }
    public function getUserType()
    {
        return $this->user_type_id;
    }
    public function setStatus($status)
    {
        return $this->status = $status;
    }
    public function getStatus()
    {
        return $this->status;
    }
}
