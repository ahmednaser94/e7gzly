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
        <h3 class="text-center font-weight-bold py-3 text-capitalize">Service Update \ Delete</h3>
      <form id="org_service_form" class="d-block mx-auto pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
          <select id="service_id" required disabled class="form-control input-default"  name="service_id">
          </select>
        </div>
          <div class="form-group">
            <label for="_name"> Name</label>
            <input class="form-control input-default" name="_name" placeholder="Name" type="text" id="_name" required>
          </div>
          <div class="form-group">
            <label for="details">Details</label>
            <input id="details" class="form-control input-default" placeholder="Details" type="text" required>
          </div>
          <div class="form-group">
            <label for="time">Time</label>
            <input id="time" class="form-control input-default" placeholder="Time" type="text" >
          </div>
          <div class="form-group">
            <label for="phone">Character(s)</label>
            <input id="char" class="form-control input-default"  placeholder="Character(s)" type="text" required>
            <div id="phone_feedback" class=""></div>
          </div>

          <button name="delete" value="update" class="btn btn-primary form-btn  px-3 float-left" type="submit">Update </button>

          <button name="delete" value="delete" class="delete btn btn-danger form-btn mx-auto px-3 float-right" type="submit">Delete </button>
      </form>
    </div>
  </div>


  <!-- confirm on delete branch -->
  <script>
    $(`.delete`).on("click", function(e) {
      var ok = confirm("are you sure to Delete this Service?!");
      if (!ok) {
        e.preventDefault();
      }

    })
  </script>

<?php require_once 'footer.php'; ?>