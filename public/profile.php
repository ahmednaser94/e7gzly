<?php  require_once '../private/main_header.php'; 

if(isset($_SESSION['logged']) == FALSE || $_SESSION['user_type'] != 1 ) {
  header('Location: index.php');
}
?>

<div class="container py-3 home-intro">
  <div class="row ">
    <div class="col-12 col-md-6 offset-md-3">
      <form id="profile-form" class="d-block mx-auto pb-3" action="" method="post">
        <h3 class="text-center font-weight-bold py-3 text-capitalize">Update Profile </h3>
        <div class="form-group">
            <label for="_name">Full Name</label>
            <input class="form-control" minlength="10" maxlength="40"  name="_name" placeholder="Full Name" type="text" id="_name" required>
            <div id="name_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input class="form-control is-valid" name="phone" placeholder="Phone" type="text" id="phone" minlength="8" maxlength="11" required>
            <div id="phone_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input class="form-control" minlength="15" maxlength="100"  name="address" placeholder="Address" type="text" id="address" required>
            <div id="address_feedback" class=""></div>
          </div>


        <button name="form-btn" value="update" id="profile_btn" class="btn btn-primary form-btn  d-block mx-auto px-5 " type="submit">Update</button>

    </div>
    </form>
  </div>
</div>

<?php require_once '../private/main_footer.php'; ?>