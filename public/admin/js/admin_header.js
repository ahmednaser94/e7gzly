// capitalize first letter of each word of a string
function Capitalize(str) {
  return str.split(" ").map(item => item.substring(0, 1).toUpperCase() + item.substring(1)).join(" ")
}

// check the link of the page of contains specific path
function checkPage(page) {
  return (window.location.pathname.includes(page)) ? true : false;
}


/* ======================================================
        get branches of an organization
====================================================== */
if (checkPage("about_us.php")) {
  $.ajax(`../../api.php?section=about_us&do=get_about_us`, {
    method: `POST`,
    data: {
    },
    success: function (data, textStatus, jqXHR) {
      if (data == 'false') {
        $('.about_us').html('There is no about us yet!')
        $('#about_button').val('add');
        $('#about_button').html('Add');
      }
      else {
        About = JSON.parse(data);
        $('.about_us_body').html(About.details);
        $('.about_us_edit').val(About.details);
      }

    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  })
}

if (checkPage("contacts.php")) {
  $.ajax(`../../api.php?section=contacts&do=get_contacts`, {
    method: `POST`,
    data: {
    },
    success: function (data, textStatus, jqXHR) {
      console.log("Output: data", data)
      if (data == 'false') {
        $('#contacts_button').val('add');
        $('#contacts_button').html('Add');
      }
      else {
        contacts = JSON.parse(data);
        $('#phone').val(contacts.phone);
        $('#email').val(contacts.email);
        $('#fb').val(contacts.fb);
        $('#twitter').val(contacts.twitter);
        $('#instagram').val(contacts.instagram);
        $('#youtube').val(contacts.youtube);
        $('#linkedin').val(contacts.linkedin);
      }

    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  })
}


/* ======================================================
        get categories
====================================================== */
if (checkPage("categories") || checkPage("org_add") || checkPage("org_update")) {

  $.ajax(`../../api.php?section=categories&do=get_categories`, {
    method: `POST`,
    data: {
      'cat': 'cat'
    },
    success: function (data, textStatus, jqXHR) {
      if (data == "false") {
        $("#msg-modal-body").html(`There are no Categories!`);
        $("#msg-alert").modal("toggle");
        setTimeout(() => {
          location.href = "../../admin/"
        }, 3000);
        return false;
      } else {
        categories = JSON.parse(data);
        row = $("#categories");
        row.html("");
        categories.forEach(function (cat) {
          if (checkPage("org_add") || checkPage("org_update")) {
            $("#cat_id").append(
              `<option value="${cat.id}">${cat.name}</option>`
            );
          }
          else if (checkPage("categories")) {
            row.append(`<tr>
                  <td >${cat.name}</td>
                  <td class='text-center'>
                  <a class='badge badge-primary px-4 py-2' href='./category_update.php?id=${cat.id}'>Update</a></td></tr>`);
          }
        });
      }
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });

}

/* ======================================================
        get category to be Updated
====================================================== */
if (checkPage("category_update")) {

  $.urlParam = function (name) {
    var results = new RegExp(`[\?&]${name}=([^&#]*)`).exec(window.location.search);
    return (results !== null) ? results[1] || 0 : false;
  }
  var catID = $.urlParam('id');

  $.ajax(`../../api.php?section=categories&do=get_category`, {
    method: `POST`,
    data: {
      'cat_id': catID
    },
    success: function (data, textStatus, jqXHR) {
      if (data == "false") {
        $("#msg-modal-body").html(`There are no Categories!`);
        $("#msg-alert").modal("toggle");
        setTimeout(() => {
          location.href = "../../admin/categories.php"
        }, 3000);
        return false;
      } else {
        category = JSON.parse(data);
        $(`#cat_id`).html('');
        $('#cat_id').html(`<option disabled selected value="${category.id}">${category.name}</option>`)
        $('#cat_name').val(`${category.name}`);
      }
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });

}


/* ====================================== 
    GET Organizations
====================================== */
if (checkPage("orgs.php") || checkPage("org_user_add") || checkPage("org_user_update")) {
  $.ajax(
    `../../api.php?section=organization&do=get_all_organizations`,
    {
      method: `POST`,
      data: {
      },
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
            $(`table tr:last`).after(
              `<tr><td valign="top" class="dataTables_empty "><h4 class='text-danger' > There are no Organizations yet!</h4> </td></tr>`
            );
            $("#msg-modal-body").html(`There are no Organizations yet!`);
            $("#msg-alert").modal("toggle");
            return false;
        } else {
          organizations = JSON.parse(data);
          row = $("#org-list-table");
          row.html("");
          organizations.forEach(function (org) {
            if (checkPage("org_user_add") || checkPage("org_user_update")) {
              $("#org").append(`<option value="${org.id}">${org.name}</option>`);
            }
            else {
              row.append(`<tr>
                  <td >${org.cat}</td>
                  <td >${org.name}</td>
                  <td>${org.license}</td>
                  <td>${org.phone}</td>
                  <td>${org.url}</td>
                  <td class='text-center'>
            <a class='badge badge-primary px-4 py-2' href='./org_update.php?id=${org.id}'>Update</a></td>
                  </tr>
                  `);

            }
          });
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    }
  );
}

/* ====================================== 
    GET Organization to be updated
====================================== */
if (checkPage("org_update.php")) {
  $.urlParam = function (name) {
    var results = new RegExp(`[\?&]${name}=([^&#]*)`).exec(window.location.search);
    return (results !== null) ? results[1] || 0 : false;
  }
  var orgID = $.urlParam('id');

  $.ajax(
    `../../api.php?section=organization&do=get_organization`,
    {
      method: `POST`,
      data: {
        'org_id': orgID
      },
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $("#msg-modal-body").html(`There are no Organization with this ID!`);
          $("#msg-alert").modal("toggle");
          setTimeout(() => {
            location.href = "../../admin/orgs.php"
          }, 2000);
          return false;
        } else {
          organization = JSON.parse(data);
          $(`#org_id`).html('');
          $('#org_id').html(`<option disabled selected value="${organization.id}">${organization.name}</option>`)
          $(`#cat_id option[value=${organization.cat_id}]`).attr('selected', 'selected');
          $('#_name').val(`${organization.name}`);
          $('#license').val(`${organization.license}`);
          $('#url').val(`${organization.url}`);
          $('#org_phone').val(`${organization.phone}`);

        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    }
  );
}


/* ====================================== 
    GET org users
====================================== */
if (checkPage("org_users.php")) {
  $.ajax(
    `../../api.php?section=users&do=get_org_users`,
    {
      method: `POST`,
      data: {
      },
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
            $(`table tr:last`).after(
              `<tr><td valign="top" class="dataTables_empty "><h4 class='text-danger' > There are no users yet!</h4> </td></tr>`
            );
            $("#msg-modal-body").html(`There are no users yet!`);
            $("#msg-alert").modal("toggle");
            return false;
        } else {
          orgUsers = JSON.parse(data);
          row = $("#org_user_table");
          row.html("");
          orgUsers.forEach(function (user) {
            row.append(`<tr>
                <td >${user.org}</td>
                <td >${user.name}</td>
                <td>${user.email}</td>
                <td>${user.phone}</td>
                <td>${user.address}</td>
                <td class='text-center'>
          <a class='badge badge-primary px-4 py-2' href='./org_user_update.php?id=${user.user_id}'>Update</a></td>
                </tr>
                `);
          });
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    }
  );
}


/* ====================================== 
    GET Organization User to be updated
====================================== */
if (checkPage("org_user_update.php")) {

  $.urlParam = function (name) {
    var results = new RegExp(`[\?&]${name}=([^&#]*)`).exec(window.location.search);
    return (results !== null) ? results[1] || 0 : false;
  }
  var orgUserID = $.urlParam('id');

  $.ajax(
    `../../api.php?section=users&do=get_org_user`,
    {
      method: `POST`,
      data: {
        'user_id': orgUserID
      },
      success: function (data, textStatus, jqXHR) {
      console.log("Output: data", data)
        if (data == "false") {
          $("#msg-modal-body").html(`There are no User with this ID!`);
          $("#msg-alert").modal("toggle");
          setTimeout(() => {
            location.href = "../../admin/org_users.php"
          }, 2000);
          return false;
        } else {
          user = JSON.parse(data);
          $("#user_id").append(`<option disabled selected value="${user.user_id}">${user.name}</option>`);

          $(`#org option[value=${user.id}]`).attr('selected', 'selected');
          $('#_name').val(`${user.name}`);
          $('#license').val(`${user.email}`);
          $('#phone').val(`${user.phone}`);
          $('#address').val(`${user.address}`);

        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    }
  );
}


if (checkPage("index.php")) {

  

  $.ajax(`../api.php?section=about_us&do=admin_statistics`, {
    method: `POST`,
    success: function (data, textStatus, jqXHR) {
        if (data == 'false') {
          $('.serve').hide();
        }
        else{
          
          stat = JSON.parse(data);
          $("#org_count").html(stat.organizations);
          $("#customers").html(parseInt(stat.customers));
          $("#total_emp").html(stat.employees);
          $("#managers_count").html(stat.managers);
          $("#emp_count").html((parseInt(stat.employees)+parseInt(stat.managers)));
          $("#tickets").html(stat.daily_tickets);
        }

    },
    error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
    }
})

}