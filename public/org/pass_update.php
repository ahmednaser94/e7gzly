<?php
require_once 'header.php';

if (!$_SESSION['logged'])
    header('Location: ../index.php');
else if ($_SESSION['logged'] && !($_SESSION['user_type'] > 1 && $_SESSION['user_type'] < 5))
    header('Location: ../denied.php');
?>

<div class="container py-3 ">
  <div class="row ">
    <div class="col-12 col-md-6 offset-md-3">
      <form id="pass_form" class="d-block mx-auto pb-3" action="" method="post">
        <h3 class="text-center font-weight-bold py-3 text-capitalize">Update Password </h3>

          <div class="form-group">
            <label for="old_password">Old Password</label>
            <input  class="form-control input-default" id="old_password" minlength="1" maxlength="20" name="old_password" placeholder="Old Password" type="password" aria-describedby="password" required>
            <div id="pass_alert" class=""></div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <small id="psscaption" class="form-text">Password must contain at least 1 lowercase, 1 uppercase, 1 number, one special character and length from 5 to 10 character (@ $ ! . % * ? &)</small>
            <input pattern="^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$" class="form-control input-default" id="password" minlength="5" maxlength="20" name="password" placeholder="Password" type="password" aria-describedby="password" required>
            <div id="pass_alert" class=""></div>
          </div>
          <div class="form-group">
            <label for="confirmation">Password Confirmation</label>
            <input pattern="^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$" class="form-control input-default" id="confirmation" minlength="5" maxlength="20" name="confirmation" placeholder="Password Confirmation" type="password" required>
            <div id="confirm_alert" class=""></div>
          </div>


        <button id="pass-btn" name="form-btn" value="update" class="btn btn-primary form-btn  d-block mx-auto px-5 " type="submit">Update Password</button>
        
    </div>
    </form>
  </div>
</div>

<?php require_once 'footer.php'; ?>