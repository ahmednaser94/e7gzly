<?php
require_once 'header.php';
?>
 
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body text-center">
        <h3 class="d-inline-block text-info ">Organizations' List</h3>
          <a class="d-inline-block float-right mr-5" href="org_add.php"><button type="button" class="btn btn-outline-info">Add Organization</button></a>
          <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                  <th>Category </th>
                  <th>Name</th>
                  <th>License</th>
                  <th>URL</th>
                  <th>Phone</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tbody id="org-list-table">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require_once 'footer.php'; ?>
