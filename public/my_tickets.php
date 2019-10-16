<?php require_once '../private/main_header.php';

if (isset($_SESSION['logged']) == FALSE || $_SESSION['user_type'] != 1) {
  header('Location: index.php');
}

?>
<div class="container py-5 home-intro">
  
  <div id='tickets_container' class="row no-gutters">
  </div>
</div>
<?php require_once '../private/main_footer.php'; ?>