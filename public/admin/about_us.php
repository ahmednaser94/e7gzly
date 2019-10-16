<?php
require_once 'header.php';
?>




<div class="site-section py-5">
  <div class="container ">
    <div class="row ">
      <div class="col-12">
        <div class="about_us pb-5">
          <h2 class="text-center py-3">About us </h2>
          <h4 class="about_us_body">

          </h4>
        </div>
        <hr>

        <form id="about_us_form" class="d-block mx-auto pb-3 w-75" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h3 class="text-center font-weight-bold text-capitalize">About us Update</h3>
          <div class="form-group">
            <textarea  class="about_us_edit form-control input-default  mx-auto" rows="10"></textarea>

          </div>
          <button name="form-btn" id="about_button" value="update" class="btn btn-primary form-btn px-5 float-left " type="submit">Update</button>
          <button name="form-btn" value="delete" class="delete btn btn-danger form-btn px-5 float-right " type="submit">Delete</button>
        </form>
      </div>
    </div>
  </div>
  <script>
    $('.delete').on("click", function(e) {
      var ok = confirm("are you sure to Delete About Us?!");
      if (!ok) {
        e.preventDefault();
      }
    })
  </script>


  <?php require_once 'footer.php'; ?>