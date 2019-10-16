
var feedMsg = {
  good: "Looks Good!",
  "emptyMail": "Please Enter an Email!",
  "enterMail": "Please Enter a Valid Email!",
  "mailExists": "Email already exists!",
  "nameShort": "Name is too short",
  "emptyPhone": "Please Enter a Phone!",
  "enterPhone": "Please Enter a Valid Phone Number!",
  "PhoneExists": "Phone already exists!",
  "emptyID": "Please Enter an ID!",
  "IDexists": "ID already exists!",
  "longName": "Name is too long must be between 10 and and 40 characters",
  "shortName": "Name is too short must be between 10 and and 40 characters",
  "shortPass": "Password less than 5 characters",
  "invalidPass": "Password Does not meet requirements!!",
  "notMatching": "Password not matching!!",
  "matchPass": "Password Match!",
  "longAddress": "Address is too long must be between 15 and and 100 characters",
  "shortAddress": "Address is too short must be between 15 and and 100 characters",
  "mailAvail": "Email is available!",
  "phoneAvail": "Phone is available!",
  "IDAvail": "ID is available!",
};

var msgClass = {
  valid: "valid-feedback",
  invalid: "invalid-feedback"
};

// show a message for the user under input
function ValidAlert(a, b, c) {
  $(a)
    .removeClass()
    .addClass(b);
  $(a)
    .html(c)
    .show();
  return true;
}

// check the link of the page of contains specific path
function checkPage(page) {
  return window.location.pathname.includes(page) ? true : false;
}

if (checkPage("profile")) {
  $.ajax(`../api.php?section=users&do=org_user_profile`, {
    method: `POST`,
    data: {

    },
    success: function (data, textStatus, jqXHR) {
      if (data == 'false') {
        $('#msg-modal-body').html("There is no User with this ID");
        $('#msg-alert').modal('toggle');
        setTimeout(() => {
          location.href = "/Qproject/public/org/index.php"
        }, 3000);
        return false;
      } else {
        profile = JSON.parse(data);
        $('#_name').val(profile.name);
        $('#address').val(profile.address);
        $('#phone').val(profile.phone);
      }
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  })

}

/* ====================================== 
    Booking Ticket
====================================== */
if (checkPage("book.php")) {

  $.ajax(`../api.php?section=categories&do=get_categories`, {
    method: `POST`,
    data: {
      'cat': 'cat'
    },
    success: function (data, textStatus, jqXHR) {
      if (data == "false") {
        $("#msg-modal-body").html(`There are no Categories!`);
        $("#msg-alert").modal("toggle");
        setTimeout(() => {
          location.href = "/Qproject/public/index.php"
        }, 3000);
        return false;
      } else {
        categories = JSON.parse(data);
        $('#category').html('');
        $("#category").append(`<option disabled selected value="">Choose category</option>`);

        categories.forEach(function (cat) {
          $("#category").append(
            `<option value="${cat.id}">${cat.name}</option>`
          );
        });
      }
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });

}



/* ====================================== 
    show Tickets
====================================== */
if (checkPage("my_tickets.php")) {
  $.ajax(`../api.php?section=tickets&do=my_tickets`, {
    method: `POST`,
    data: {
      'ticket': 'ticket'
    },
    success: function (data, textStatus, jqXHR) {
      if (data == "false") {
        $("#msg-modal-body").html(`There are no tickets yet!!`);
        $("#msg-alert").modal("toggle");
        setTimeout(() => {
          location.href = "index.php"
        }, 3000);
        return false;
      } else {
        tickets = JSON.parse(data);

        $("#tickets_container").html('');
        tickets.forEach(function (ticket) {


          var waiting = 0;
          var ETA = 0;
          var brServiceID = ticket.br_service_id;
          $.ajax(`../api.php?section=tickets&do=waiting_service_customer`, {
            method: `POST`,
            data: {
              'br_service_id': brServiceID
            },
            success: function (data, textStatus, jqXHR) {
              if (data == 'false') {
                return false;
              }
              else {
                num = JSON.parse(data);
                waiting = num.waiting
                ETA = waiting * ticket.time;
                var time = '';
                if (ETA > 60)
                  time = `${Math.floor(ETA / 60)} Hour(s) &  ${ETA % 60} Min`;
                else
                  time = `${ETA} Min`;


                $("#tickets_container").append(`
          <div id="ticket_container" class="col-10 offset-1 col-md-3 offset-md-1 d-flex">
          <div class="services text-center" data-toggle="tooltip" data-placement="top" title="${ticket.address}">
            <div class="icon mt-2 d-flex justify-content-center align-items-center">
            <span class="icon-ticket pb-3"> </span>
            </div>
            <h3>Ticket No:<span class="font-weight-bolder"> ${ticket.chars}${ticket.number}</span> </h3>
            <div class="text-left media-body">
              <p class="my-0 pt-4">Organization: <span class="text-uppercase font-weight-bold">${ticket.org}</span></p>
              <p class="my-0"> Branch: <span class="font-weight-bold text-capitalize" >${ticket.branch}</span></p>
              <p class="my-0"> Service: <span class="font-weight-bold text-capitalize">${ticket.service}</span></p>
              <p class="my-0">Waiting Customers: <span class="font-weight-bold text-capitalize">${waiting}</span></p>
              <p class="mb-3">Estimated Time: <span class="font-weight-bold text-capitalize">${time}</span></p>
              <button value="${ticket.id}" class=" btn btn-danger form-btn float-right px-3 ticket_delete">Delete</button>
              </div>
          </div>
        </div>
          `);
                $('[data-toggle="tooltip"]').tooltip()
              }
            },
            error: function (jqXhr, textStatus, errorThrown) {
              console.log(errorThrown);
            }
          });
        });


      }
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });

}

// if (document.querySelector('.nav-scrolled')) {

//   $('.dropdown-menu').removeClass('bg-transparent').removeClass('text-white');
// }


// if (checkPage("pass_recovery.php")) {


// }