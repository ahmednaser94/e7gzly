<?php
require_once 'header.php';

if (!$_SESSION['logged'])
    header('Location: ../index.php');
else if ($_SESSION['logged'] && $_SESSION['user_type'] != 4)
    header('Location: ../denied.php');
?>
 

<!-- get the branch data by AJAX -->
<div class="container py-3 ">
  <div class="row ">
    <div class="col-12 col-md-6 offset-md-3">
      <form id="branch-form" class="d-block mx-auto pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3 class="text-center font-weight-bold py-3 text-capitalize">Branch Update \ Delete</h3>
        <div class="form-group">
          <select disabled class="form-control input-default" id="branch_id" name="branch_id">
          </select>
        </div>
        <div class="br_container">
          <div class="form-group">
            <label for="_name">Branch Name</label>
            <input class="form-control input-default" name="_name" placeholder="Name" type="text" id="_name" required>
            <div id="name_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="br_code">Branch Code</label>
            <input class="form-control input-default" name="br_code" placeholder="Code" type="text" id="br_code" required>
            <div id="br_code_feedback" class=""></div>
          </div>
          <label for="area">Branch Area</label>
          <div class="form-group">
            <select required class="form-control input-default" id="area" name="area">
              <option disabled selected value="">choose Area</option>
            </select>
            <div id="area_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="address">Branch Address</label>
            <input class="form-control input-default" name="address" placeholder="Address" type="text" id="address" minlength="15" maxlength="100" >
            <div id="address_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="phone">Branch Phone</label>
            <input class="form-control input-default" name="br_phone" placeholder="Phone" type="text" min="0" minlength="4" maxlength="12" id="br_phone" required>
            <div id="phone_feedback" class=""></div>
          </div>

          <button name="delete" value="update" class="btn btn-primary form-btn  px-3 float-left" type="submit">Update Branch</button>

          <button name="delete" value="delete" class="delete btn btn-danger form-btn mx-auto px-3 float-right" type="submit">Delete Branch</button>
        </div>
      </form>
    </div>
  </div>


  <!-- confirm on delete branch -->
  <script>
    $(`.delete`).on("click", function(e) {
      var ok = confirm("are you sure to Delete this Branch?!");
      if (!ok) {
        e.preventDefault();
      }

    })
  </script>

<?php require_once 'footer.php'; ?>