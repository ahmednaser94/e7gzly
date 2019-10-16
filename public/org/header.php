<?php

session_start();
ob_start();

require_once '../../private/class/CookiesHistory.php';


if (isset($_SESSION['logged'])) {

  if (!($_SESSION['user_type'] > 1 && $_SESSION['user_type'] < 5))
    header('Location: ../denied.php');
}


if (!isset($_SESSION['logged'])) {

  $user = new CookiesHistory();
  if ($user->logged()) {
    $name = explode(" ",  $_SESSION['name']);
    $_SESSION['name'] = $name[0];
    
    header('Location: ' . $_SERVER['PHP_SELF'] . '');
  } else
    header('Location: ../index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>E7GZLY</title>

  <!-- Custom Stylesheet -->
  <!-- <script src="js/jquery-3.4.1.min.js"></script> -->
  <script src="plugins/common/common.min.js"></script>


  <link href="./plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/fontawsome.min.css">
  <link rel="stylesheet" href="css/all.css">
  <link href="css/style.css" rel="stylesheet">

  <script src="./js/org_header.js"></script>
<?php echo "<script>localStorage.setItem('user_type',".$_SESSION['user_type'].")</script>"; ?>
</head>

<body>

  <!--*******************
        Preloader start
    ********************-->
  <div id="preloader">
    <div class="loader">
      <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
      </svg>
    </div>
  </div>
  <!--*******************
        Preloader end
    ********************-->


  <!--**********************************
        Main wrapper start
    ***********************************-->
  <div id="main-wrapper">

    <!--**********************************
            Nav header start
        ***********************************-->
    <div class="nav-header">
      <div class="brand-logo">
        <a href="index.php">
          <h4 class="text-white">E7GZLY</h4>
        </a>
      </div>
    </div>
    <div class="nav-header">
      <div class="brand-logo">
        <a href="index.php">
          <h2 class="logo-abbr text-white">E</h2>
          <span class="logo-compact text-white font-weight-bold">E7GZLY</span>
          <span class="brand-title text-white font-weight-bold">
            E7GZLY
          </span>
        </a>
      </div>
    </div>
    <!--**********************************
            Nav header end
        ***********************************-->

    <!--**********************************
            Header start
        ***********************************-->
    <div class="header">
      <div class="header-content clearfix">

        <div class="nav-control">
          <div class="hamburger">
            <span class="toggle-icon"><i class="icon-menu"></i></span>
          </div>
        </div>
        <div class="header-left">
          <div class="input-group icons">
            <div class="input-group-prepend">
              <div class="header-right pt-2">
                <h3 class="text-capitalize">Welcome <?php echo $_SESSION['name'] ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

    <!--**********************************
            Sidebar start
        ***********************************-->
    <div class="nk-sidebar">
      <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
          <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 4) : ?>
            <li class="nav-label">Branches</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="fas fa-code-branch"></i><span class="nav-text">Branches</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="branches.php">Branches List</a></li>
                <li><a href="branch_add.php">Add Branch</a></li>
              </ul>
            </li>
            <li class="nav-label">Employees</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="fas fa-users"></i><span class="nav-text">Employees</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="employees_list.php">Employees List</a></li>
                <li><a href="employee_approval.php">Pending Employees</a></li>
                <li><a href="employee_add.php">Add Employee</a></li>
              </ul>
            </li>
            <li class="nav-label">Services</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="fab fa-servicestack"></i><span class="nav-text">Services</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="services_org.php">Services List</a></li>
                <li><a href="service_org_add.php">Add Service</a></li>
              </ul>
            </li>
          <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 3) : ?>

            <li class="nav-label">Services</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="fab fa-servicestack"></i><span class="nav-text">Branch Services</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="br_services.php">Branch Services List</a></li>
                <li><a href="br_service_add.php">Add Branch Service</a></li>
              </ul>
            </li>

            <li class="nav-label">Employees</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="fas fa-users"></i><span class="nav-text">Employees</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="ticket_details.php">Ticket Details</a></li>
                <li><a href="employees_list.php">Employees List</a></li>
                <li><a href="service_emp.php">Service Employees List</a></li>
                <li><a href="service_emp_add.php">Add Service Employee</a></li>
              </ul>
            </li>
          <?php elseif (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 2) : ?>

          
          <?php endif; ?>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] < 5) : ?>
            <li class="nav-label">Profile</li>
            <li>
              <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="fas fa-user"></i><span class="nav-text">Profile</span>
              </a>
              <ul aria-expanded="false">
                <li><a href="profile.php">Update Profile</a></li>
                <li><a href="pass_update.php">Change Password</a></li>
                <li><a href="../logout.php">Logout</a></li>
              <?php endif; ?>
              </ul>
            </li>
        </ul>
      </div>
    </div>
    <!--**********************************
            Sidebar end
        ***********************************-->

    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">

      <!-- Modal -->
      <div class="modal fade" id="msg-alert" tabindex="-1" role="dialog" aria-labelledby="msg-alertTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="msg-alertCenterTitle">Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h4 class="text-center text-capitalize text-info" id="msg-modal-body"></h4>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>