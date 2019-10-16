<?php 
require_once 'header.php';

if(!$_SESSION['logged'])
  header('Location: ../index.php');
else if($_SESSION['logged'] && $_SESSION['user_type'] != 3)
  header('Location: ../denied.php');

?>
 
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body text-center">
        <h3 class="d-inline-block text-info ">Branch Services</h3>
          <a class="d-inline-block float-right mr-5" href="br_service_add.php"><button type="button" class="btn btn-outline-info">Add Branch Service</button></a>
          <div class="table-responsive">
            <table class="table table-striped table-bordered zero-configuration">
              <thead>
                <tr>
                <th>Name</th>
                  <th>Total</th>
                  <th>Pending</th>
                  <th>Served</th>
                  <th>Waiting</th>
                  <th>Time</th>
                  <th>ETA</th>
                  <th>Update</th>
                </tr>
              </thead>
              <tbody id="service_aggregate">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php require_once 'footer.php'; ?>
