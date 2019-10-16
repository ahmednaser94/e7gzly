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
    } else {
      header('Location: ../index.php');
    }
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
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/main.js"></script>
  <link rel="stylesheet" href="css/fontawesome_free.css">
  <link rel="stylesheet" href="css/fontawesome_pro.css">
  <link rel="stylesheet" href="css/fontawsome.min.css">
  <link rel="stylesheet" href="css/icomoon.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style2.css">
  <!-- <link rel="stylesheet" href="css/style.css"> -->
  <link rel="stylesheet" href="css/main.css">
  <link rel="shortcut icon" href="#" />
</head>

<body>
  <section <?php echo strpos($_SERVER['PHP_SELF'], 'index.php') ? 'id="particles-js"' : 'class="py-5"'; ?>>
    <header id="header" class="<?php echo strpos($_SERVER['PHP_SELF'], 'index.php') ? '' : 'fixed'; ?>" >
      <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-light px-4 py-3">
        <a class="navbar-brand" href="index.php">
          <img src="img/Logo.png" height="48" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#header-navbar" id="header-button">
          <svg viewBox="0 0 24 24" height="24">
              <g class="bars">
                <rect x="12" y="0" />
                <rect x="12" y="18" />
                <rect x="12" y="9" />
                <rect x="12" y="9" />
              </g>
            </svg>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="header-navbar">
          <ul class="navbar-nav text-uppercase text-center">
            <?php if (strpos($_SERVER['PHP_SELF'], 'index.php')) : ?>
              <li class="nav-item">
                <a class="nav-link scroll" href="#how">How to</a>
              </li>
              <li class="nav-item">
                <a class="nav-link scroll" href="#partners">Our Partners</a>
              </li>
              <li class="nav-item">
                <a class="nav-link scroll" href="#footer">Contact</a>
              </li>
            <?php endif; ?>
            <?php if (!isset($_SESSION['user_id'])) : ?>
              <li class="nav-item">
                <a class="nav-link btn btn-outline-primary px-4 text-uppercase" data-toggle="modal" data-target="#modal-login" href="#">Book Ticket</a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn btn-outline-primary px-4 text-uppercase" href="register.php">Join</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#modal-login" href="#">Login</a>
              </li>
            <?php else : ?>
              <?php if($_SESSION['user_type'] == 1) : ?>
              <li class="nav-item">
                <a class="nav-link btn btn-outline-primary px-4" href="book.php">Book Ticket</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="my_tickets.php">My Tickets</a>
              </li>
              <li class="nav-item">
                <div class="dropdown">
                  <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" href="#">
                    <?php echo ucfirst($_SESSION['name']) ?>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right border-0">
                    <a class="dropdown-item" href="profile.php">Profile</a>
                    <a class="dropdown-item" href="reset_pass.php">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
                </div>
              </li>
              <?php else: ?>
              <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
              </li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
        </div>
      </nav>
    </header>

    <header hidden class="w-100 py-2 <?php echo !strpos($_SERVER['PHP_SELF'], 'index.php') ? 'nav-scrolled' : ''; ?>">
      <a href="index.php" class="site-logo">
        <img src="img/Logo_White.png" alt="" height="48">
      </a>

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
              <div id="name-menu" class="dropdown-menu  <?php echo !strpos($_SERVER['PHP_SELF'], 'index.php') ? '' : 'bg-transparent text-white'; ?>" aria-labelledby="navbarDropdown">
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
            <a id="forget_pass_link" class="d-none" href="pass_recovery.php">Forgotten Password</a>
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
      <div id="carousel">
        <div id="carousel-x" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carousel-x" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-x" data-slide-to="1"></li>
            <li data-target="#carousel-x" data-slide-to="2"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('img/bg1.jpg')">
              <img src="img/bg1.jpg" class="d-block" alt="...">
              <div class="carousel-caption">
                <h2>Save time, Save money..</h2>
                <div class="pt-3">
                  <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 1) : ?>
                  <a class="btn btn-outline-primary px-4 text-uppercase" href="book.php">Book Ticket</a>
                  <?php elseif (!isset($_SESSION['user_id'])) :  ?>
                  <a class="btn btn-outline-primary px-4 text-uppercase" href="#" data-toggle="modal" data-target="#modal-login">Book Ticket</a>
                  <?php endif ?>
                </div>
              </div>
            </div>
            
            <div class="carousel-item" style="background-image: url('img/bg2.jpg')">
              <img src="img/bg2.jpg" class="d-block" alt="...">
              <div class="carousel-caption">
                <h2>Save time, Save money..</h2>
                <div class="pt-3">
                  <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 1) : ?>
                  <a class="btn btn-outline-primary px-4 text-uppercase" href="book.php">Book Ticket</a>
                  <?php elseif (!isset($_SESSION['user_id'])) :  ?>
                  <a class="btn btn-outline-primary px-4 text-uppercase" href="#" data-toggle="modal" data-target="#modal-login">Book Ticket</a>
                  <?php endif ?>
                </div>
              </div>
            </div>

            <div class="carousel-item" style="background-image: url('img/bg3.jpg')">
              <img src="img/bg3.jpg" class="d-block" alt="...">
              <div class="carousel-caption">
                <h2>Save time, Save money..</h2>
                <div class="pt-3">
                  <?php if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 1) : ?>
                  <a class="btn btn-outline-primary px-4 text-uppercase" href="book.php">Book Ticket</a>
                  <?php elseif (!isset($_SESSION['user_id'])) :  ?>
                  <a class="btn btn-outline-primary px-4 text-uppercase" href="#" data-toggle="modal" data-target="#modal-login">Book Ticket</a>
                  <?php endif ?>
                </div>
              </div>
            </div>

          </div>
          <a class="carousel-control-prev" href="#carousel-x" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carousel-x" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>

    <?php endif; ?>
  </section>