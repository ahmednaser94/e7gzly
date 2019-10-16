<?php 
require_once 'header.php';

?>
 
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body text-center">
        <h3 class="d-inline-block text-info ">Categories</h3>
          <a class="d-inline-block float-right mr-5" href="category_add.php"><button type="button" class="btn btn-outline-info">Add Category </button></a>
          <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                <th>Name</th>
                  <th>Update</th>
                </tr>
              </thead>
              <tbody id="categories">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require_once 'footer.php'; ?>
