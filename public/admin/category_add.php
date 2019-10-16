<?php 
require_once 'header.php';
?>

<div class="site-section py-5">
  <div class="container ">
    <div class="row ">
      <div class="col-12">
        <h3 class="text-center font-weight-bold text-capitalize">Add Category</h3>
        <form id="category_form" class="d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group">
            <label for="cat_name">Category Name</label>
            <input type="text" id="cat_name" required class="form-control input-default">
          </div>
          <button name="form-btn" value="add" class="btn btn-primary form-btn d-block mx-auto px-5" type="submit">Add Category</button>
        </form>
      </div>
    </div>
  </div>



<?php require_once 'footer.php'; ?>