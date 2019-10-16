<?php
require_once 'header.php';

if (!$_SESSION['logged'])
  header('Location: ../index.php');
else if ($_SESSION['logged'] && !($_SESSION['user_type'] < 5 && $_SESSION['user_type'] > 2))
  header('Location: ../denied.php');
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body text-center">
          <h3 class="d-inline-block text-info ">Employees' List</h3>
          <?php if ($_SESSION['user_type'] == 4) : ?>
            <a class="d-inline-block float-right mr-5" href="employee_add.php"><button type="button" class="btn btn-outline-info">Add Employee</button></a>
            <div class="table-responsive">
              <table  id="org_employees" class="table table-striped table-bordered zero-configuration">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Manager</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Update</th>
                  </tr>
                </thead>
                <tbody id="org_tbody">
                </tbody>
              </table>
            </div>

          <?php endif ?>


          <?php if ($_SESSION['user_type'] == 3) : ?>
            <div class="table-responsive">
              <table  id="branch_employees" class="table table-striped table-bordered zero-configuration">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                  </tr>
                </thead>
                <tbody id="br_tbody">
                </tbody>
              </table>
            </div>


          <?php endif ?>

        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'footer.php'; ?>