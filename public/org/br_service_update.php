<?php 
require_once 'header.php';

if(!$_SESSION['logged'])
  header('Location: ../index.php');
else if($_SESSION['logged'] && $_SESSION['user_type'] != 3)
  header('Location: ../denied.php');

?>

<div class="site-section py-5">
  <div class="container ">
    <div class="row ">
      <div class="col-12">
        <form id="br_service_form" class="d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h3 class="text-center font-weight-bold text-capitalize">Update Branch Service</h3>
          <div class="form-group">
            <select disabled required class="form-control input-default" id="br_service_id">
            </select>
          </div>
          <div class="form-group">
            <label for="service_id">Service Type</label>
            <select required class="form-control input-default" id="service_id">
              <option disabled selected value="">choose Service type</option>
            </select>
          </div>
          <button name="form-btn" value="update" class="btn btn-primary form-btn  px-3 float-left" type="submit">Update</button>
        
        <button name="form-btn" value="delete" class="delete btn btn-danger form-btn mx-auto px-3 float-right" type="submit">Delete</button>        </form>
      </div>
    </div>
  </div>

<!-- confirm on delete branch -->
<script>
  $('.delete').on("click", function(e) {
      var ok = confirm("are you sure to Delete this Employee?!");
      if (!ok) {
        e.preventDefault();
      }
    })
</script>



<?php require_once 'footer.php'; ?>