<?php require_once '../private/main_header.php'; ?>


<div id="particles-js2 " class="home-intro">

  <!-- HOW TO E7GZLY
    ================================================== -->

  <section id="how" class=" how container-fluid  text-center text-dark py-5">
    <br>
    <br>
    <div class="px-5 mx-auto">
      <h1 class="mb-3">How To <Span class="text-primary"> E7GZLY</Span></h1>
      <div class="row justify-content-center text-center">
        <div class="col-10 offset-1 col-sm-8 col-md-4 offset-md-0 col-lg-2 ">
          <h4 class=" d-inline-block px-3 py-2 text-white rounded-circle bg-primary">1</h4>
          <h4 class="fixed-height">Select organization</h4>
          <div class="py-2">
            <img src="img\book1.png" alt="" class="img-fluid  ">
          </div>
        </div>
        <div class="col-10 offset-1 col-sm-8  col-md-4 offset-md-0 col-lg-2 offset-lg-1">
          <h4 class="d-inline-block px-3 py-2 text-white rounded-circle bg-primary">2</h4>
          <h4 class="fixed-height">Select service</h4>
          <div class="py-2">
            <img src="img\book2.png" alt="" class="img-fluid">
          </div>
        </div>
        <div class="col-10 offset-1 col-sm-8  col-md-4 offset-md-0 col-lg-2 offset-lg-1">
          <h4 class="d-inline-block px-3 py-2 text-white rounded-circle bg-primary">3</h4>
          <h4 class="fixed-height">Book your ticket</h4>
          <div class="py-2">
            <img src="img\book3.png" alt="" class="img-fluid">
          </div>
          <!-- <img src="img\book3.png" alt="" class="img-fluid py-3  rounded"> -->
        </div>
      </div>
    </div>
  </section>

  <!-- We serve
=========================================-->
  <section class="serve py-4" id="partners">
    <div class="container">
      <br>
      <h1 class="py-4 text-center ">We Serve</h1>
      <div class="row justify-content-center align-items-center">
        <div class="col-6 offset-0 col-md-3 text-center mt-2 ">
          <i class="fas fa-university fa-2x py-2 text-primary"></i>
          <span id='org_count' class="py-1 d-block text-center number" data-number="">0</span>
          <span> Organizations</span>

        </div>
        <div class="col-6 offset-0 col-md-3 offset-md-1 text-center mt-2">
          <i class="far fa-users fa-2x py-2 text-primary"></i>
          <span id='customers_count' class="py-1 d-block number text-center" data-number="">0</span>

          <span>Customers</span>

        </div>
        <div class="col-6 offset-0 col-md-3 offset-md-1 text-center mt-2">
          <i class="fal fa-ticket-alt fa-2x py-2 text-primary"></i>
          <span id='tickets_count' class="py-1 d-block number text-center" data-number="">0</span>
          <span>Tickets</span>

        </div>
      </div>
    </div>
  </section>
  <!-- partner
=========================================-->
  <section class="partner pb-5 container">
    <h1 class=" text-center"> Our Main Partners</h1>

    <div class="partner-container row justify-content-between px-5 align-items-center ">
      <img class="col-6 py-sm-3 col-md-3 " src="img/nti.png" alt="">
      <img class="col-6 py-sm-3 col-md-3  " src="img/cib.png" alt="">
      <img class="col-6 py-sm-3 col-md-3  " src="img/qnb1.png" alt="">
      <img class="col-6 py-sm-3 col-md-3 " src="img/vodafone.png" alt="">

    </div>
  </section>
  <!-- Contact form
=========================================-->


  <?php require_once '../private/main_footer.php'; ?>
  </body>

  </html>