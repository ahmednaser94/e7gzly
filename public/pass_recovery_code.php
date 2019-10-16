<?php require_once '../private/main_header.php'; 
if (!isset($_SESSION['code'])){
  header('Location: index.php');
}
?>


<div class="site-section py-5 home-intro">
  <div class="container ">
    <div class="row ">
      <div id="code_div" class="col-12">
        <h3 class="text-center font-weight-bold text-capitalize">Password Recovery</h3>
        <form id="recovery_code_form" class="pb-5 d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div  class="form-group">
            <label for="recovery_code">Code</label>
            <input required class="form-control" name="recovery_code" placeholder="Recovery Code" type="text" id="recovery_code" minlength="5" maxlength="5">
            <small>Recovery code consists of 5 digits</small>
          </div>

          <button id="code_btn" class="btn btn-primary form-btn d-block mx-auto px-5" type="submit">Confirm</button>
        </form>
      </div>
        <div class="col-12">
        <form id="pass_reset_form" class=" py-5 mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h3 class="text-center font-weight-bold text-capitalize">Please Choose a New Password</h3>
          <div class="form-group">
            <span class="d-none" id="pass_code_hidden"></span>
            <label for="password">Password</label>
            <small id="psscaption" class="form-text">Password must contain at least 1 lowercase, 1 uppercase, 1 number, one special character and length from 5 to 10 character (@ $ ! % * ? &)</small>
            <input pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,20}$" class="form-control" id="password" minlength="5" maxlength="20" name="password" placeholder="Password" type="password" aria-describedby="password" required>
            <div id="pass_alert" class=""></div>
          </div>
          <div class="form-group">
            <label for="confirmation">Password Confirmation</label>
            <input class="form-control" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,20}$" id="confirmation" minlength="5" maxlength="20" name="confirmation" placeholder="Password Confirmation" type="password" required>
            <div id="confirm_alert" class=""></div>
          </div>
          <button id="pass_btn" class="btn btn-primary form-btn d-block mx-auto px-5" type="submit">Update Password</button>
        </form>

      </div>
    </div>
  </div>




  <?php require_once '../private/main_footer.php'; ?>