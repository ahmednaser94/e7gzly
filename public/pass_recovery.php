<?php  require_once '../private/main_header.php'; ?>


<div class="site-section py-5 home-intro">
  <div class="container ">
    <div class="row ">
      <div class="col-12">
        <h3 class="text-center font-weight-bold text-capitalize">Password Recovery</h3>
        <form id="forget_pass_form" class="d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="custom-control custom-radio">
            <input type="radio" id="by_email" checked name="type" value="email" class="custom-control-input">
            <label class="custom-control-label" for="by_email">via Email</label>
          </div>
          <div class="custom-control custom-radio">
            <input type="radio" id="by_phone" name="type" value="phone" class="custom-control-input">
            <label class="custom-control-label" for="by_phone">via Phone</label>
          </div>
          
          <div id="phone_cont" class="form-group">
            <label for="phone">Phone</label>
            <p>Plese Enter last 4 digits of your mobile +2********<?php echo isset($_SESSION['phone_digits']) ? $_SESSION['phone_digits']: ''; ?></p>
            <input class="form-control" name="phone" placeholder="Phone" type="text" id="phone" minlength="8" maxlength="11" >
            <div id="phone_feedback" class=""></div>
          </div>

          <button id="pass_form_btn"name="form_btn" class="btn btn-primary form-btn d-block mx-auto px-5" type="submit">Send Code</button>
        </form>
      </div>
    </div>
  </div>




<?php require_once '../private/main_footer.php'; ?>
