<?php
require_once 'header.php';
?>

<div class="site-section py-5">
  <div class="container ">
    <div class="row ">
      <div class="col-12">
        <h3 class="text-center font-weight-bold text-capitalize">Organization User Add</h3>
        <form id="org_user_form" class="d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group">
            <label for="org">Organization </label>
            <select required class="form-control input-default" id="org" name="org">
              <option disabled selected value="">Choose Organization</option>
            </select>
          </div>
          <div class="form-group">
            <label for="_name">Full Name</label>
            <input class="form-control input-default" name="_name" id="_name" placeholder="Full Name" type="text" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control input-default" name="email" id="email" placeholder="Email" type="email" required>
            <div id="mail_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input pattern="^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$" class="form-control input-default" id="password" minlength="5" maxlength="20" name="password" placeholder="Password" type="password" aria-describedby="password" required>
            <div id="pass_alert" class=""></div>
          </div>
          <div class="form-group">
            <label for="confirmation">Password Confirmation</label>
            <input class="form-control input-default" pattern="^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$" id="confirmation" minlength="5" maxlength="20" name="confirmation" placeholder="Password Confirmation" type="password" required>
            <div id="confirm_alert" class=""></div>
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input class="form-control input-default" name="phone" placeholder="Phone" type="text" id="phone" minlength="8" maxlength="11" required>
            <div id="phone_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input class="form-control input-default" minlength="15" maxlength="100" name="address" placeholder="Address" type="text" id="address" required>
            <div id="address_alert" class=""></div>
          </div>


          <button name="form-btn" value="add" class="btn btn-primary form-btn d-block mx-auto px-5" type="submit">Add User</button>
        </form>
      </div>
    </div>
  </div>

    <?php require_once 'footer.php'; ?>