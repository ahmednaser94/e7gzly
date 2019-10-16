<?php
require_once 'header.php';

if (!$_SESSION['logged'])
    header('Location: ../index.php');
else if ($_SESSION['logged'] && $_SESSION['user_type'] != 4)
    header('Location: ../denied.php');
?>
 
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body text-center">
        <h3 class="d-inline-block text-info ">Branches' List</h3>
          <a class="d-inline-block float-right mr-5" href="branch_add.php"><button type="button" class="btn btn-outline-info">Add Branch</button></a>
          <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>Org Name</th>
                  <th>Branch Area</th>
                  <th>Branch Code</th>
                  <th>Branch Name</th>
                  <th>Branch Address</th>
                  <th>Branch phone</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody id="branch-list-table">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require_once 'footer.php'; ?>
