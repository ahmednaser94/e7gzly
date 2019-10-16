$(function() {
  if(window.location.pathname == '/index.php' || window.location.pathname == '/') {
    $(window)
    .on(`scroll`, function() {
      var top = $(this).scrollTop();
      var height = $(`#carousel`).height() - 100;

      if(top > height) {
        if(!$(`#header`).hasClass(`fixed`)) {
          $(`#header`).addClass(`fixed`);
        }
      }
      else {
        if($(`#header`).hasClass(`fixed`)) {
          $(`#header`).removeClass(`fixed`);
        }
      }
    })
    .on(`resize`, function() {
      var width = $(this).width();

      if(width >= 992) {
        var header = $(`#header`);
        var button = $(`[data-target="#header-navbar"]`);
        var block = $(`#header-navbar`);

        if(!$(button).hasClass(`collapsed`)) {
          $(button).addClass(`collapsed`);
        }

        if($(block).hasClass(`show`)) {
          $(block).removeClass(`show`);
        }

        if($(header).hasClass(`collapsed`)) {
          $(header).removeClass(`collapsed`);
        }
      }
    });

    
$(document).ready(function () {

  var scrollLink = $('.scroll');

  // Smooth scrolling
  scrollLink.click(function (e) {
    e.preventDefault();

    $('body,html').animate({
      scrollTop: $(this.hash).offset().top
    }, 1000);
  });

  // Active link switching
  $(window).scroll(function () {
    var scrollbarLocation = $(this).scrollTop();

    scrollLink.each(function () {
      var sectionOffset = ($(this.hash).offset().top) - 20;

      if (sectionOffset <= scrollbarLocation) {
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
      }
    })

  })

})

var counter = function () {
  $('#partners').waypoint(function (direction) {

    if (direction === 'down' && !$(this.element).hasClass('ftco-animated')) {

      var comma_separator_number_step = $.animateNumber.numberStepFactories.separator(',')
      $('.number').each(function () {
        var $this = $(this),
          num = $this.data('number');
        $this.animateNumber({
          number: num,
          numberStep: comma_separator_number_step
        }, 4000);
      });

    }

  }, {
    offset: '95%'
  });

}
setTimeout(() => {
  counter();
}, 1000);


  }
 


  $(`#header-navbar`)
  .on(`show.bs.collapse`, function() {
    $(`#header`).addClass(`collapsed`);
    $(`#header-button`).addClass(`clicked`);
  })
  .on(`hide.bs.collapse`, function() {
    $(`#header`).removeClass(`collapsed`);
    $(`#header-button`).removeClass(`clicked`);
  });

  $(`#header-navbar .navbar-nav .nav-item .nav-link:not(.dropdown-toggle)`).on(`click`, function() {
    var width = $(window).width();

    if(width < 992) {
      $(`[data-target="#header-navbar"]`).trigger(`click`);
    }
  });

  $(window).trigger(`scroll`);
});