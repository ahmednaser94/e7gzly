<?php  require_once '../private/main_header.php'; 
if (isset($_SESSION['logged']) == FALSE) {
    header('Location: index.php');
  }

?>

<div class="container py-5 home-intro">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center text-danger font-weight-bold">Access is Denied!</h3>
        </div>
    </div>
</div>

<?php  require_once '../private/main_footer.php'; ?>
