<?php require_once '../private/main_header.php'; ?>


<div class="site-section py-5 home-intro">
  <div class="container ">
    <div class="row ">
      <div class="col-12 offset-0 col-lg-6 offset-lg-3">
        <h3 class="text-center font-weight-bold text-capitalize">User Registration</h3>
        <form id="reg_form" class="d-block mx-auto pb-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <label>User Type</label>
          <div class="custom-control custom-radio">
            <input type="radio" id="customer" checked name="user_type" value="1" class="custom-control-input">
            <label class="custom-control-label" for="customer">Customer</label>
          </div>
          <div class="custom-control custom-radio">
            <input type="radio" id="employee" name="user_type" value="2" class="custom-control-input">
            <label class="custom-control-label" for="employee">Employee</label>
          </div>
          <div class="custom-control custom-radio">
            <input type="radio" id="manager" name="user_type" value="3" class="custom-control-input">
            <label class="custom-control-label" for="manager">Branch Manager</label>
          </div>
          <div class="form-group">
            <label for="_name">Full Name</label>
            <input class="form-control" minlength="10" maxlength="40" name="_name" placeholder="Full Name" type="text" id="_name" required>
            <div id="name_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" class="form-control " name="email" placeholder="Email" type="email" required>
            <div id="mail_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input name="phone" class="form-control " placeholder="Phone" type="text" id="phone" minlength="8" maxlength="11" required>
            <div id="phone_feedback" class=""></div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <small id="psscaption" class="form-text">Password must contain at least 1 lowercase, 1 uppercase, 1 number, one special character and length from 5 to 20 character (@ $ ! % * ? &)</small>
            <input pattern="^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$" class="form-control" id="password" minlength="5" maxlength="20" name="password" placeholder="Password" type="password" aria-describedby="password" required>
            <div id="pass_alert" class=""></div>
          </div>
          <div class="form-group">
            <label for="confirmation">Password Confirmation</label>
            <input class="form-control" pattern="^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$" id="confirmation" minlength="5" maxlength="20" name="confirmation" placeholder="Password Confirmation" type="password" required>
            <div id="confirm_alert" class=""></div>
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <input class="form-control" minlength="15" maxlength="100" name="address" placeholder="Address" type="text" id="address" required>
            <div id="address_feedback" class=""></div>
          </div>

          <div class="comp">
            <div class="form-group">
              <label for="organization">Organization</label>
              <select class="form-control" id="organization" name="organization">
                <option disabled selected value="">choose Organization</option>
              </select>
            </div>
            <div id="br_emp_container">
              <div class="form-group">
                <label for="branch">Branch</label>
                <select class="form-control" id="branch" name="branch">
                  <option disabled selected value="">choose Branch</option>
                </select>
                <div id="branch_feedback" class=""></div>
              </div>
              <div class="form-group">
                <label for="comp_id">Employee ID</label>
                <input class="form-control" name="comp_id" id="comp_id" placeholder="Employee ID" type="text">
                <div id="comp_id_alert" class=""></div>
              </div>
            </div>
          </div>

          <button id="register" name="form_btn" class="btn btn-primary form-btn d-block mx-auto px-5" type="submit">Register</button>
        </form>
      </div>
    </div>
  </div>



  <script src="js/register.js"></script>




  <?php require_once '../private/main_footer.php'; ?>