<?php
require_once 'header.php';
?>
 
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body text-center">
        <h3 class="d-inline-block text-info ">Org Users' List</h3>
          <a class="d-inline-block float-right mr-5" href="org_user_add.php"><button type="button" class="btn btn-outline-info">Add Org User</button></a>
          <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>Organization</th>
                  <th>Name</th>
                  <th>email</th>
                  <th>phone</th>
                  <th>Address</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody id="org_user_table">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require_once 'footer.php'; ?>
