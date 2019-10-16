<?php
require_once "../private/class/User.php";
require_once "../private/class/CookiesHistory.php";
require_once 'filter.php';

session_start();

$user = new User();
$f = new filters();

$co = new CookiesHistory();

$passRegEx = '/^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$/';

switch ($_GET['do']) {

  case "reg": {
      $user->setName($f->filterString($_POST['_name']));
      $user->setEmail($f->filterEmail($_POST['email']));


      if (!preg_match($passRegEx, $_POST['password'])) {
        $data = "password is not correct";
        break;
      }
      $user->setPassword($_POST['password']);


      $phone = filter_var(trim($_POST['phone']), FILTER_SANITIZE_NUMBER_INT);
      if ($phone == '') {
        $data = "Phone number is not valid";
        break;
      } else {
        $user->setPhone($phone);
      }

      $user->setPhone($phone);
      $user->setAddress(trim($_POST['address']));
      $user->setUserType((int) trim($_POST['user_type']));

      if ($_POST['user_type'] != 1) {
        // if user is employee or a manager fill these fields 
        $user->setOrgID((int) trim($_POST['organization']));
        $user->setBranchID((int) trim($_POST['branch']));
        $user->setCompID(trim($_POST['comp_id']));
      }

      $data = $user->Add();
    }
    break;

  case 'user_login': {
      // login code here
      $user->setEmail($f->filterEmail($_POST['email']));
      if (!preg_match($passRegEx, $_POST['password'])) {
        $data = "password is not correct";
        return false;
      }
      $user->setPassword($_POST['password']);

      $login = $user->UserLogin();
      // $data = $login;
      if ($login) {
        // unset recovery password sessions 
        unset($_SESSION['recovery_name']);
        unset($_SESSION['recovery_email']);
        unset($_SESSION['recovery_phone']);
        unset($_SESSION['recovery_user_id']);
        unset($_SESSION['phone_digits']);

        // email is not correct
        if ($login == 'email')
          $data = 'email';
        // password is not correct
        else if ($login == 'password') {
          $recovery = $user->getUser();
          $_SESSION['recovery_name'] = $recovery['name'];
          $_SESSION['recovery_email'] = $recovery['email'];
          $_SESSION['recovery_phone'] = $recovery['phone'];
          $_SESSION['recovery_user_id'] = $recovery['user_id'];
          $_SESSION['phone_digits'] = substr($recovery['phone'], -4);
          $data = 'password';
        } else {
          if ($login['status'] == 'approved') {

            // if remember me is checked
            if (isset($_POST['remember']))
              $co->RememberME($login['user_id']);

            // login the user
            $_SESSION['logged'] = true;
            $_SESSION['user_id'] = $login['user_id'];
            $name = explode(" ", $login['name']);
            $_SESSION['name'] = $name[0];

            switch ($login['user_type_id']) {
                // customer
              case 1: {
                  $_SESSION['user_type'] = $login['user_type_id'];
                }
                break;

                // employee or manager
              case 2:
              case 3: {
                  $_SESSION['user_type'] = $login['user_type_id'];
                  $_SESSION['org_id'] = $login['org_id'];
                  $_SESSION['branch_id'] = $login['branch_id'];
                }
                break;

                // organization
              case 4: {
                  $_SESSION['user_type'] = $login['user_type_id'];
                  $_SESSION['org_id'] = $login['org_id'];
                }
                break;
                // ADMIN
              case 5: {
                  $_SESSION['user_type'] = $login['user_type_id'];
                }
                break;
            }
            $data = $login;
          } else {
            $data = $login['status'];
          }
        }
      }
    }
    break;

    // check if recovery phone match with user input
  case "check_recovery_phone": {
      $phone = trim($_POST['phone']);
      if (!($phone == $_SESSION['recovery_phone']))
        $data = "wrong phone";
      else
        $data = true;
    }
    break;

    // unsubscribe a user 
  case "delete_account": {
      $user->setUserID($_SESSION['user_id']);

      $data = $user->Delete();
    }
    break;

    // check if email is exists in DB
  case "check_email": {
      $user->setEmail(trim($_POST['email']));
      $data = $user->checkUserEmail();
    }
    break;

    // check if phone is exists in DB
  case "check_phone": {
      $user->setPhone(trim($_POST['phone']));
      $data = $user->checkUserPhone();
    }
    break;

    // check if phone is exists in DB
  case "check_branch_manager": {
      $user->setOrgID(trim($_POST['org_id']));
      $user->setBranchID(trim($_POST['branch_id']));
      $data = $user->checkBranchManager();
    }
    break;

    // check if company ID is exists in DB
  case "check_comp_id": {
      $user->setOrgID(trim($_POST['org_id']));
      $user->setCompID(trim($_POST['comp_id']));
      $data = $user->checkUserID();
    }
    break;

    // get managers of a branch if any
  case 'get_branch_managers': {
      $user->setOrgID($_SESSION['org_id']);
      $user->setBranchID($_POST['branch_id']);
      $data = $user->GetManagers();
    }
    break;

    // get employees of a branch if any
  case 'get_branch_employees': {
      $user->setOrgID($_SESSION['org_id']);
      $user->setBranchID($_SESSION['branch_id']);
      $data = $user->GetBranchEmployees();
    }
    break;

    // get Number of a branch Employees if any
  case 'count_branch_employees': {
      $user->setOrgID($_SESSION['org_id']);
      $user->setBranchID($_SESSION['branch_id']);
      $data = $user->CountBranchEmployees();
    }
    break;

    // get Number of a org Employees and managers if any
  case 'count_org_employees_managers': {
      $user->setOrgID($_SESSION['org_id']);
      $data = $user->CountOrgEmployees();
    }
    break;

    // get Number of a pending Employees and managers if any
  case 'count_pending_employees': {
      $user->setOrgID($_SESSION['org_id']);
      $data = $user->CountPendingEmployees();
    }
    break;

    // update Employee Data
  case 'employee_update': {
      // general in add or update or delete
      $user->setOrgID(trim($_SESSION['org_id']));
      $user->setCompID(trim($_POST['comp_id']));
      $user->setName(trim($_POST['_name']));
      $user->setPhone(trim($_POST['phone']));
      $user->setAddress(trim($_POST['address']));
      $user->setUserType(trim($_POST['user_type']));

      // if branch exists
      if (isset($_POST['branch'])) {
        $user->setBranchID(trim($_POST['branch']));

        // if manager exists
        if (isset($_POST['manager']))
          $user->setManager(trim($_POST['manager']));
      }

      // in case of update we need to add status and user_id
      if ($_POST['form-btn'] == 'update') {
        $user->setUserID(trim($_POST['user_id']));
        $user->setStatus(trim($_POST['status']));
        $data = $user->Update();
      }

      // in case of delete we need to add user_id
      else if ($_POST['form-btn'] == 'delete') {
        $user->setUserID(trim($_POST['user_id']));
        $data = $user->DeleteEmployee();
      }
      // in case of adding... we need password and email 
      else if ($_POST['form-btn'] == 'add') {
        $user->setEmail(trim($_POST['email']));
        if (!preg_match($passRegEx, $_POST['password'])) {
          $data = "password is not correct";
          return false;
        }
        $user->setPassword(trim($_POST['password']));
        $data = $user->AddEmployee();
      }
    }
    break;

    // Organization User Update - Add - Delete
  case 'Update_org_user': {

      $user->setOrgID(trim($_POST['org_id']));
      $user->setName(trim($_POST['name']));
      $user->setPhone(trim($_POST['phone']));
      $user->setAddress(trim($_POST['address']));
      $user->setUserType(4);


      if (isset($_POST['user_id']))
        $user->setUserID(trim($_POST['user_id']));

      // in case of update we need to add status and user_id
      if ($_POST['form-btn'] == 'update')
        $data = $user->Update();
      // in case of delete we need to add user_id
      else if ($_POST['form-btn'] == 'delete')
        $data = $user->Delete();
      // in case of adding... we need password and email 
      else if ($_POST['form-btn'] == 'add') {
        $user->setEmail(trim($_POST['email']));
        if (!preg_match($passRegEx, $_POST['password'])) {
          $data = "password is not correct";
          return false;
        }
        $user->setPassword(trim($_POST['password']));
        $data = $user->Add();
      }
    }
    break;


    // get all employees inside an organization
  case 'get_all_employees': {
      $user->setOrgID($_SESSION['org_id']);
      $data = $user->GetEmployees();
      if (!$data) {
        return "No Employees in this Organization";
      }
    }
    break;

    // get all org users
  case 'get_org_users': {
      $data = $user->getOrgUsers();
    }
    break;

    // get all org users
  case 'get_org_user': {
      $user->setUserID(trim($_POST['user_id']));
      $data = $user->getOrgUser();
    }
    break;

    // get employee data to be updated
  case 'get_employee_data': {
      $user->setOrgID($_SESSION['org_id']);
      $user->setUserID(trim($_POST['user_id']));
      $data = $user->GetEmployee();
      if (!$data) {
        return "No user with this ID";
      }
    }
    break;

    // get org user Profile
  case 'org_user_profile': {
      $user->setUserID(trim($_SESSION['user_id']));
      $data = $user->getProfile();
    }
    break;

    // update org user Profile
  case 'user_update': {
      $user->setUserType(trim($_SESSION['user_type']));
      $user->setUserID(trim($_SESSION['user_id']));
      $user->setName(trim($_POST['_name']));
      $user->setPhone(trim($_POST['phone']));
      $user->setAddress(trim($_POST['address']));

      $name = explode(" ", trim($_POST['_name']));
      $_SESSION['name'] = $name[0];

      $update = $user->Update();

      // if (strpos($update, 'successfully'))
      //   $data = $update;
      if (strpos($update, 'phone'))
        $data = "this phone already exists!";
      else
        $data = $update;
    }
    break;


    // update user password
  case 'password_update': {
      $user->setUserType(trim($_SESSION['user_type']));
      $user->setUserID(trim($_SESSION['user_id']));
      if (!preg_match($passRegEx, $_POST['old_password'])) {
        $data = "password is not correct";
        return false;
      }
      $user->setPassword(trim($_POST['old_password']));
      if (!preg_match($passRegEx, $_POST['new_password'])) {
        $data = "password is not correct";
        return false;
      }
      $user->setNewPassword(trim($_POST['new_password']));
      $data = $user->updatePassword();
    }
    break;
}
