<?php
require_once 'header.php';

if (!$_SESSION['logged'])
  header('Location: ../index.php');
else if ($_SESSION['logged'] && $_SESSION['user_type'] != 3)
  header('Location: ../denied.php');
?>

<div class="site-section py-5">
  <div class="container ">
    <div class="row ">
      <div class="col-12">
        <form id="ticket_details_form" class="d-block mx-auto w-50 pb-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <h3 class="text-center font-weight-bold text-capitalize">Ticket Details</h3>
          <input class="form-control input-default col-3 offset-3 d-inline-block " maxlength="3" id="ticket_chars" placeholder="Characters" type="text" required>
          <input class="form-control input-default col-3 d-inline-block " id="ticket_number" placeholder="Number" type="number" min="1" required>
          <button id="ticket_btn" value="add" class="btn btn-primary form-btn d-block mx-auto mt-4 px-5" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-8 mx-auto" id="ticket_details_table">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table header-border table-hover verticle-middle">
            <thead>
              <tr>
                <th scope="col text-">Ticket Number</th>
                <th scope="col">Employee</th>
                <th scope="col">Started</th>
                <th scope="col">Ended</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody id="ticket_tbody">
              <tr>

              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php require_once 'footer.php'; ?>