<?php require_once '../private/main_header.php';

if (isset($_SESSION['logged']) == FALSE || $_SESSION['user_type'] != 1) {
  header('Location: index.php');
}

?>

<div class="site-section py-5 home-intro">
  <div class="container ">
    <div class="row ">
      <div class="col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <form id="book_form" class="d-block mx-auto pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h3 class="text-center font-weight-bold text-capitalize">Ticket Booking </h3>
          <div class="form-group">
            <label for="category">Select Category</label>
            <select required class="form-control" id="category">
              <option disabled selected value="">Choose category</option>
            </select>
          </div>
          <div id="org_section" class="form-group">
            <label for="organization">Select Organization</label>
            <select required class="form-control" id="organization">
              <option disabled selected value="">Choose Organization</option>
            </select>
          </div>
          <div id="br_section" class="form-group">
            <label for="branch">Select Branch</label>
            <select required class="form-control" id="branch">
              <option disabled selected value="">Choose Branch</option>
            </select>
          </div>
          <div id="serv_section" class="form-group">
            <label for="service">Service Type</label>
            <select required class="form-control" id="service">
              <option disabled selected value="">choose Service type</option>
            </select>
          </div>

          <button id='book_btn' name="form-btn" value="add" class="btn btn-primary form-btn d-block mx-auto py-3 px-5" type="submit">Book Ticket</button>
        </form>
      </div>
    </div>
    <div id='service_info' class="container py-5 d-block">
      <div class="row text-primary text-center">
        <div class="col-sm-12  col-md-6 ">
          <h3 class="text-capitalize font-weight-bolder"><i class="fal fa-user-clock"></i> waiting Customers</h3>
          <h3 id='waiting_customers' class="  p-3 text-dark"></h3>
        </div>
        <div class="col-sm-12 col-md-6 text-center">
          <h3 class="text-capitalize font-weight-bolder "><i class="far fa-clock"></i> Estimated Time</h3>
          <h5 id='ETA' class="text-capitalize p-3 text-dark"> </h5>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('#book_btn').on("click", function(e) {
    var ok = confirm("are you sure to request a ticket?!");
    if (!ok) {
      e.preventDefault();
    }
  })
</script>

<?php require_once '../private/main_footer.php'; ?>