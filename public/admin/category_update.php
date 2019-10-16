<?php
require_once 'header.php';
?>

<div class="site-section py-5">
  <div class="container ">
    <div class="row ">
      <div class="col-12">
        <form id="category_form" class="d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <h3 class="text-center font-weight-bold text-capitalize">Update Category</h3>
          <div class="form-group">
            <select id="cat_id" disabled required class="form-control input-default">
            </select>
          </div>
          <div class="form-group">
            <label for="cat_name">Category Name</label>
            <input type="text" id="cat_name" required class="form-control input-default">
          </div>
          <button name="form-btn" value="update" class="btn btn-primary form-btn  px-3 float-left" type="submit">Update</button>

          <button name="form-btn" value="delete" class="delete btn btn-danger form-btn mx-auto px-3 float-right" type="submit">Delete</button>
        </form>
      </div>
    </div>
  </div>

  <!-- confirm on delete branch -->
  <script>
    $('.delete').on("click", function(e) {
      var ok = confirm("are you sure to Delete this Category?!");
      if (!ok) {
        e.preventDefault();
      }
    })
  </script>



  <?php require_once 'footer.php'; ?>