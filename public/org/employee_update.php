<?php
require_once 'header.php';

if (!$_SESSION['logged'])
    header('Location: ../index.php');
else if ($_SESSION['logged'] && $_SESSION['user_type'] != 4)
    header('Location: ../denied.php');
?>

<div class="container py-3 ">
  <div class="row ">
    <div class="col-12 col-md-6 offset-md-3">
      <form id="employee_form" class="d-block mx-auto pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3 class="text-center font-weight-bold py-3 text-capitalize">Employee Update \ Delete</h3>
        <div class="form-group">
          <select disabled class="form-control input-default" id="user_id" name="user_id">
          </select>
        </div>
        <div class="form-group">
          <label for="_name">Branch Name</label>
          <select class="form-control input-default" id="branch" name="branch">
          </select>
        </div>
        <div class="form-group">
          <label for="comp_id"> Employee ID</label>
          <input class="form-control input-default" name="comp_id" placeholder="ID" type="text" id="comp_id" required>
        </div>
        <div class="form-group">
          <label for="_name"> Name</label>
          <input class="form-control input-default" name="_name" placeholder="Name" type="text" id="_name" required>
        </div>
        <div class="form-group">
          <label for="phone"> Phone</label>
          <input class="form-control input-default" name="phone" placeholder="Phone" type="text" id="phone" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input class="form-control input-default" minlength="15" maxlength="100" name="address" placeholder="Address" type="text" id="address" required>
            <div id="address_alert" class=""></div>
          </div>
        <div class="form-group">
          <label for="manager">Manager</label>
          <select class="form-control input-default" id="manager" name="manager">
          </select>
        </div>

        <div class="form-group">
          <label for="user_type">User Type</label>
          <select class="form-control input-default" id="user_type" name="user_type">
              <option value="2" >Employee</option>
              <option value="3">Manager</option>
          </select>
        </div>
        <div class="form-group">
          <label for="status">Status</label>
          <select class="form-control input-default" id="status" name="status">
              <option value="pending" selected>Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
          </select>
        </div>

        <button name="form-btn" value="update" class="btn btn-primary form-btn  px-3 float-left" type="submit">Update</button>
        
        <button name="form-btn" value="delete" class="delete btn btn-danger form-btn mx-auto px-3 float-right" type="submit">Delete</button>
    </div>
    </form>
  </div>
</div>
<!-- confirm on delete branch -->
<script>
 del =  $('.delete');
  if (del) {
    del.on("click", function(e) {
      var ok = confirm("are you sure to Delete this Employee?!");
      if (!ok) {
        e.preventDefault();
      }
    })
  }


</script>

<?php require_once 'footer.php'; ?>