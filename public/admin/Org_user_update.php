<?php
require_once 'header.php';
?>

<div class="site-section py-5">
  <div class="container ">
    <div class="row ">
      <div class="col-12">
        <form id="org_user_form" class="d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h3 class="text-center font-weight-bold text-capitalize">Organization User Update</h3>
          <div class="form-group">
            <select id="user_id" disabled selected class="form-control input-default"  name="user_id">
            </select>
          </div>
          <div class="form-group">
            <label for="org">Organization </label>
            <select autofocus class="form-control input-default" id="org" name="org">
              <option disabled selected value="">Choose Organization</option>
            </select>
          </div>
          <div class="form-group">
            <label for="_name">Full Name</label>
            <input  id="_name" class="form-control input-default" name="_name" placeholder="Full Name" type="text" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input id="phone"  class="form-control input-default" name="phone" placeholder="Phone" type="text" minlength="8" maxlength="11" required>
            <div id="phone_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input id="address" class="form-control input-default" minlength="15" maxlength="100" name="address" placeholder="Address" type="text"  required>
            <div id="address_alert" class=""></div>
          </div>


          <button name="delete" value="update" class="btn btn-primary form-btn  px-3 float-left" type="submit">Update </button>

          <button name="delete" value="delete" class="delete btn btn-danger form-btn mx-auto px-3 float-right" type="submit">Delete </button>
        </form>
      </div>
    </div>
  </div>


  <!-- confirm on delete branch -->
  <script>
    $(`.delete`).on("click", function(e) {
      var ok = confirm("are you sure to Delete this User?!");
      if (!ok) {
        e.preventDefault();
      }

    })
  </script>
  <?php require_once 'footer.php'; ?>