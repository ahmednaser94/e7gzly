<?php

session_start();
ob_start();

require_once '../private/class/CookiesHistory.php';

if (!isset($_SESSION['logged'])) {
  $user = new CookiesHistory();

  if (isset($_COOKIE["data"])) {
    // if cookie is valid then login the user
    if ($user->logged()) {
      $name = explode(" ",  $_SESSION['name']);
      $_SESSION['name'] = $name[0];
      header('Location: ' . $_SERVER['PHP_SELF'] . '');
    } else
      header('Location: ../index.php');
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>E7GZLY</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <!-- <script src="js/about_contacts.js"></script> -->
  <link rel="stylesheet" href="css/all.css">
  <link rel="stylesheet" href="css/fontawsome.min.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="scss/main.css">
  <link rel="shortcut icon" href="#" />

</head>

<body>
  <section <?php echo strpos($_SERVER['PHP_SELF'], 'index.php') ? '' : 'class="py-5"'; ?>>

    <header class=" <?php echo !strpos($_SERVER['PHP_SELF'], 'index.php') ? 'nav-scrolled' : ''; ?>">
      <a href="index.php" class="site-logo   " aria-label="homepage">E7GZLY</a>
      <nav class="main-nav ">
        <ul class="nav-list ">
          <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) : ?>

            <li class="nav-list-item">
              <a href="#how" class="nav-link scroll">How to </a>
            </li>
            <li class="nav-list-item">
              <a href="#partners" class=" nav-link scroll">Our Partners</a>
            </li>
            <li class="nav-list-item">
              <a href="#footer" class=" nav-link scroll">Contact</a>
            </li>
          <?php endif; ?>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 1) : ?>
            <li class="nav-list-item">
              <a href="my_tickets.php" class="nav-link ">My Tickets</a>
            </li>
            <li class="nav-list-item ">
              <a href="book.php" class="nav-link nav-link--btn">Book Ticket</a>
            </li>
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-center text-capitalize " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo ucfirst($_SESSION['name']) ?>
              </a>
              <div id="name-menu" class="dropdown-menu   <?php echo !strpos($_SERVER['PHP_SELF'], 'index.php') ? '' : ''; ?>" aria-labelledby="navbarDropdown">
                <a class="nav-link" href="profile.php">Profile</a>
                <a class="nav-link" href="reset_pass.php">Settings</a>
                <div class="dropdown-divider"></div>
                <a class="nav-link" href="logout.php">Logout</a>
              </div>
            </li>
          <?php endif; ?>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] != 1) : ?>
            <a href="logout.php" class="nav-link ">Logout</a>
          <?php endif; ?>


          <?php if (!isset($_SESSION['user_id'])) : ?>
            <li class="nav-list-item ">
              <a href="#" data-toggle="modal" data-target="#modal-login" class="nav-link nav-link--btn">Book Ticket</a>
            </li>
            <li class="nav-list-item">
              <a class="nav-link nav-link--btn" href="#" data-toggle="modal" data-target="#modal-login">Login</a>
            </li>
            <li class="nav-list-item">
              <a class="nav-link nav-link--btn nav-link--btn--highlight" href="register.php">Join</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>

      <div class="burger">
        <div class="line "></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>

    </header>

    <!-- END nav -->
    <script src="js/main_header.js"></script>

    <!-- LOGIN MODAL -->
    <div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-loginLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header p-2">
            <h3 id="modal-loginLabel" class="modal-title text-center font-weight-bold text-capitalize mx-auto text-info">User Login</h3>
            <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="login_form" class="d-block mx-auto w-50 pb-3" action="" method="post">
              <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" name="login_email" id="login_email" placeholder="Email" type="email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,20}$" class="form-control" id="login_password" minlength="5" maxlength="20" name="login_password" placeholder="Password" type="password" aria-describedby="password" required>
              </div>
              <div class="custom-control custom-checkbox">
                <input type="checkbox" value="remember" class="custom-control-input" id="remember-me">
                <label class="custom-control-label" for="remember-me">Remember Me</label>
              </div>
              <button name="form-btn" class="btn btn-primary form-btn d-block mx-auto px-5" type="submit">login</button>
            </form>
            <a href="pass_recovery.php">Forgotten Password</a>
          </div>
        </div>
      </div>
    </div>

    <script src="./js/login.js"></script>

    <!-- Alert Modal -->
    <div class="modal fade" id="msg-alert" tabindex="-1" role="dialog" aria-labelledby="msg-alertTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="msg-alertCenterTitle">Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h5 class="text-center text-capitalize text-info" id="msg-modal-body"></h5>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
          </div>
        </div>
      </div>
    </div>


    <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) : ?>
     
       <section class="carousel " >
            <div class="inner">
                <div class="slide active">
                    <div class="carousel-caption  d-md-block home-text">
                        <h2 class="hero-text mb-5 font-weight-normal " data-text="Save time, Save money... ">Save time, Save money..</h2>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 1) : ?>
                        <a class="button home-book button-accent mt-4" href="book.php">Book</a>
                        <?php elseif(!isset($_SESSION['user_id'])):  ?>
                        <a class="button home-book button-accent mt-4" href="#" data-toggle="modal" data-target="#modal-login">Book</a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="slide">
                    <div class="carousel-caption  d-md-block home-text">
                        <h2 class="hero-text mb-5 font-weight-normal " data-text="Save time, Save money... ">Save time, Save money..</h2>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 1) : ?>
                        <a class="button home-book button-accent mt-4" href="book.php">Book</a>
                        <?php elseif(!isset($_SESSION['user_id'])):  ?>
                        <a class="button home-book button-accent mt-4" href="#" data-toggle="modal" data-target="#modal-login">Book</a>
                        <?php endif ?>
                    </div>
                </div>
                <div class="slide">
                    <div class="carousel-caption  d-md-block home-text">
                        <h2 class="hero-text mb-5 font-weight-normal " data-text="Save time, Save money... ">Save time, Save money..</h2>
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 1) : ?>
                        <a class="button home-book button-accent mt-4" href="book.php">Book</a>
                        <?php elseif(!isset($_SESSION['user_id'])):  ?>
                        <a class="button home-book button-accent mt-4" href="#" data-toggle="modal" data-target="#modal-login">Book</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <div class="arrow arrow-left"></div>
            <div class="arrow arrow-right"></div>
        </section>
     

    <?php endif; ?>
  </section>