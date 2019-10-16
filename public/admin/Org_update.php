<?php
require_once 'header.php';
?>
 

<!-- get the branch data by AJAX -->
<div class="container py-3 ">
  <div class="row ">
    <div class="col-12 col-md-6 offset-md-3">
      <form id="org-form" class="d-block mx-auto pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3 class="text-center font-weight-bold py-3 text-capitalize">Organization Update \ Delete</h3>
        <div class="form-group">
          <select id="org_id" disabled class="form-control input-default"  name="org_id">
          </select>
        </div>
        <div class="form-group">
        <label for="cat_id">Category</label>
          <select id="cat_id" class="form-control input-default"  name="cat_id">
          <option disabled selected value="">Choose Category</option>
          </select>
        </div>
        <div class="br_container">
          <div class="form-group">
            <label for="_name">Organization Name</label>
            <input class="form-control input-default" name="_name" placeholder="Name" type="text" id="_name" required>
          </div>
          <div class="form-group">
            <label for="license">License</label>
            <input id="license" class="form-control input-default" name="license" placeholder="License" type="text" required>
          </div>
          <div class="form-group">
            <label for="url">URL</label>
            <input id="url" class="form-control input-default" name="url" placeholder="URL" type="text"  >
          </div>
          <div class="form-group">
            <label for="phone"> Phone</label>
            <input id="org_phone" class="form-control input-default" name="org_phone" placeholder="Phone" type="text" maxlength="12"  required>
          </div>

          <button name="delete" value="update" class="btn btn-primary form-btn  px-3 float-left" type="submit">Update Org</button>

          <button name="delete" value="delete" class="delete btn btn-danger form-btn mx-auto px-3 float-right" type="submit">Delete Org</button>
        </div>
      </form>
    </div>
  </div>


  <!-- confirm on delete branch -->
  <script>
    $(`.delete`).on("click", function(e) {
      var ok = confirm("are you sure to Delete this Organization?!");
      if (!ok) {
        e.preventDefault();
      }

    })
  </script>

<?php require_once 'footer.php'; ?>