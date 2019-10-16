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
if (checkPage("branches.php") ||
  checkPage("employee_update.php") || checkPage("employee_add.php")) {

  $.ajax(`../../api.php?section=branches&do=get_org_branches`, {
    method: `POST`,
    data: {
      'org': 'org'
    },
    success: function (data, textStatus, jqXHR) {
      if (data == 'false') {
        if (checkPage("branches.php")) {
          $(`table tr:last`).after(`<tr><td valign="top" colspan="7" class="dataTables_empty "><h4 class='text-danger' > There are no branches yet!</h4> </td></tr>`);
          $(`table tr:last`).after(`<tr><td valign="top" colspan="7" class="dataTables_empty "><a href="branch_add.php"><button type="button" class="btn mb-1 btn-outline-info">Start Adding Branches</button></a> </td></tr>`);
          $('#msg-modal-body').html(`There are no branches yet!`);
          $('#msg-alert').modal('toggle');
          return false;
        } else if (checkPage("employee_update.php") || checkPage("employee_add.php")) {
          var branchSelect = $(`#branch`)
          branchSelect.html('');
          branchSelect.append(`<option disabled selected value=''>Organization has no branches</option>`);
          return false;
        }
      } else {
        branches = JSON.parse(data);
        if (checkPage("branches.php")) {
          row = $('tbody');
          row.html('');
          branches.forEach(function (branch) {
            row.append(`<tr>
                                    <td>${branch.org}</td>
                                    <td>${branch.area}</td>
                                    <td>${branch.code}</td>
                                    <td>${branch.name}</td>
                                    <td>${branch.address}</td>
                                    <td>${branch.phone}</td>
                                    <td class='text-center'>
                                    <a class='label label-secondary' href='./branch_update.php?id=${branch.br_id}'>Update</a></td>
                                    </tr>
                                    `);
          })
        } else if (checkPage("employee_update.php") || checkPage("employee_add.php")) {
          var branchSelect = $(`#branch`)
          branchSelect.html('');
          if (branches.length == 0) {
            branchSelect.append(`<option disabled selected value=''>Organization has no branches</option>`);
            return false;
          }
          branchSelect.append(`<option disabled selected value=''>Choose Branch</option>`);
          branchSelect.append(`<option value=''>No Branch</option>`);
          branches.forEach(function (branch) {
            branchSelect.append(`
                    <option value='${branch.br_id}'>${branch.name}</option>
                    `);
          })
          if (checkPage("employee_update.php")) {
            $.urlParam = function (name) {
              var results = new RegExp(`[\?&]${name}=([^&#]*)`).exec(window.location.search);
              return (results !== null) ? results[1] || 0 : false;
            }
            var ID = $.urlParam('id');

            // load employee data  from DB
            $.ajax(`../../api.php?section=users&do=get_employee_data`, {
              method: `POST`,
              data: {
                'user_id': ID
              },
              success: function (data, textStatus, jqXHR) {
                if (data == 'false') {
                  $('#msg-modal-body').html("There is no Employee with this ID");
                  $('#msg-alert').modal('toggle');
                  setTimeout(() => {
                    location.href = "../../org/employees_list.php"
                  }, 3000);
                  return false;
                }
                user = JSON.parse(data);

                // get managers of the user branch
                $.ajax(`../../api.php?section=users&do=get_branch_managers`, {
                  method: `POST`,
                  data: {
                    'branch_id': user.branch_id
                  },
                  success: function (data, textStatus, jqXHR) {
                    if (data == 'false') {
                      $(`#manager`).append(`<option disabled selected value=''>Branch has no managers</option>`);
                    } else {
                      managers = JSON.parse(data);
                      var managerSelect = $(`#manager`)
                      managerSelect.html('');
                      managerSelect.append(`<option disabled selected value=''>Choose Manager</option>`);
                      managerSelect.append(`<option value=''>No Manager</option>`);

                      managers.forEach(function (manager) {
                        managerSelect.append(`
                              <option value='${manager.user_id}'>${manager.name}</option>
                              `);
                      })
                    }
                    $(`#user_id`).html('');
                    $(`#user_id`).append(`<option disabled selected value="${user.user_id}">${user.emp_name}</option>`);
                    $(`#branch option[value=${user.branch_id}]`).attr('selected', 'selected');
                    $('#comp_id').val(user.comp_id);
                    $('#_name').val(user.emp_name);
                    $('#address').val(user.address);
                    $('#phone').val(user.phone);
                    $(`#manager option[value=${user.managerID}]`).attr('selected', 'selected');
                    $(`#user_type option[value=${user.user_type_id}]`).attr('selected', 'selected');
                    $(`#status option[value=${user.status}]`).attr('selected', 'selected');

                  },
                  error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                  }
                })
              },
              error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
              }
            });
          }
        }
      }

    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  })
}


/* ======================================================
        get employees of an organization
====================================================== */
if (checkPage("employees_list") || checkPage("employee_approval")) {

  if (localStorage.getItem("user_type") == 3) {

    $.ajax(`../../api.php?section=users&do=get_branch_employees`, {
      method: `POST`,
      data: {

      },
      success: function (data, textStatus, jqXHR) {
        if (data == 'false') {
          $('#branch_employees tr:last').after(`<tr><td valign="top" colspan="9" class="dataTables_empty"><h4 class='text-danger' > There are no Employees yet!</h4> </td></tr>`);
          $('#msg-modal-body').html(`There are no employees yet!`);
          $('#msg-alert').modal('toggle');
          return false;
        } else {
          employees = JSON.parse(data);
          row = $('#br_tbody');
          row.html('');
          employees.forEach(function (emp) {
            emp.emp_name = Capitalize(emp.emp_name);
            row.append(`<tr>
            <td>${emp.comp_id}</td>
            <td>${emp.emp_name}</td>
              <td>${emp.email}</td>
              <td>${emp.phone}</td> </tr>`);
          })
        }
      }, error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  if (localStorage.getItem("user_type") == 4) {
    $.ajax(`../../api.php?section=users&do=get_all_employees`, {
      method: `POST`,
      data: {
        'org': 'org'
      },
      success: function (data, textStatus, jqXHR) {
        if (data == 'false') {
          $('#org_employees tr:last').after(`<tr><td valign="top" colspan="9" class="dataTables_empty"><h4 class='text-danger' > There are no Employees yet!</h4> </td></tr>`);
          $('#org_employees tr:last').after(`<tr><td valign="top" colspan="9" class="dataTables_empty"><a href="employee_add.php"><button type="button" class="btn mb-1 btn-outline-info">Start Adding Employees</button></a> </td></tr>`);
          $('#msg-modal-body').html(`There are no employees yet!`);
          $('#msg-alert').modal('toggle');
          return false;
        } else {
          employees = JSON.parse(data);
          row = $('#org_tbody');
          row.html('');
          employees.forEach(function (emp) {

            // if no manager print no manager instead of null!
            emp.manager = emp.manager == null ? 'No Manager' : emp.manager;
            emp.branch = emp.branch == null ? 'No Branch' : emp.branch;

            // capitalize each word
            emp.emp_name = Capitalize(emp.emp_name);
            emp.branch = Capitalize(emp.branch);

            var status;
            if (emp.status === 'approved')
              status = `<span class="label label-pill label-success">Approved</span>`;
            else if (emp.status === 'pending')
              status = `<span class="label label-pill label-warning">Pending</span>`;
            else
              status = `<span class="label label-pill label-danger">Rejected</span>`;

            if (checkPage("employee_approval")) {
              if (emp.status == 'pending') {
                row.append(`<tr>
                            <td>${emp.comp_id}</td>
                            <td>${emp.emp_name}</td>
                            <td>${emp.branch}</td>
                            <td>${emp.email}</td>
                            <td>${emp.phone}</td>
                            <td>${emp.manager}</td>
                            <td>${emp.user_type}</td>
                            <td class="text-center">${status}</td>
                            <td class='text-center'><a class='label label-secondary' href='./employee_update.php?id=${emp.user_id}'>Update</a></td>
                            </tr>
                            `);
              }
            } else {
              row.append(`<tr>
                        <td>${emp.comp_id}</td>
                        <td>${emp.emp_name}</td>
                        <td>${emp.branch}</td>
                        <td>${emp.email}</td>
                        <td>${emp.phone}</td>
                        <td>${emp.manager}</td>
                        <td>${emp.user_type}</td>
                        <td class="text-center">${status}</td>
                        <td class='text-center'><a class='label label-secondary' href='./employee_update.php?id=${emp.user_id}'>Update</a></td>
                        </tr>
                        `);
            }
          })
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    })
  }

}
/* ======================================================
        get branches areas
====================================================== */
if (checkPage("branch_add") || checkPage("branch_update")) {

  $.ajax(`../../api.php?section=branches&do=get_branches_areas`, {
    method: `POST`,
    data: {
      'org': 'org'
    },
    success: function (data, textStatus, jqXHR) {
      if (data == 'false') {
        $(`#area`).append(`<option value=""> There are no areas! </option>`);
        $('#msg-modal-body').html(`There are no areas yet!`);
        $('#msg-alert').modal('toggle');
        return false;
      }
      areas = JSON.parse(data);
      areas.forEach(function (area) {
        $(`#area`).append(`
            <option value="${area.id}"> ${area.name} </option>
            `);
      })
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  })

}

/* ======================================================
        load branch data to be update
====================================================== */
if (checkPage("branch_update")) {

  $.urlParam = function (name) {
    var results = new RegExp(`[\?&]${name}=([^&#]*)`).exec(window.location.search);
    return (results !== null) ? results[1] || 0 : false;
  }

  var branchID = $.urlParam('id');

  $.ajax(`../../api.php?section=branches&do=get_branch_details`, {
    method: `POST`,
    data: {
      'branch_id': branchID
    },
    success: function (data, textStatus, jqXHR) {
      if (data == 'false') {
        $('#msg-modal-body').html("There is no Branch with this ID");
        $('#msg-alert').modal('toggle');
        setTimeout(() => {
          location.href = "../../org/branches.php"
        }, 3000);
        return false;
      }

      branch = JSON.parse(data);
      $(`#branch_id`).html('');
      $(`#branch_id`).append(`<option disabled selected value="${branch.br_id}">${branch.name}</option>`);
      $('#_name').val(branch.name);
      $('#br_code').val(branch.code);
      $(`#area option[value=${branch.area_id}]`).attr('selected', 'selected');
      $('#address').val(branch.address);
      $('#br_phone').val(branch.phone);

    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  })

}


/* ==================================== 
    Get Org user data to be updated
=======================================*/
if (checkPage("profile")) {
  $.ajax(`../../api.php?section=users&do=org_user_profile`, {
    method: `POST`,
    data: {
      'org': 'org'
    },
    success: function (data, textStatus, jqXHR) {
      if (data == 'false') {
        $('#msg-modal-body').html("There is no User with this ID");
        $('#msg-alert').modal('toggle');
        setTimeout(() => {
          location.href = "index.php"
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
    GET DETAILS ABOUT SERVICES
====================================== */
if (checkPage("br_services.php")) {
  // get aggregate branch services
  $.ajax(
    `../../api.php?section=branch_services&do=get_aggregate_br_serv`,
    {
      method: `POST`,
      data: {
        org: "org"
      },
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          if (checkPage("br_services.php")) {
            $(`table tr:last`).after(
              `<tr><td valign="top" class="dataTables_empty "><h4 class='text-danger' > There are no branches yet!</h4> </td></tr>`
            );
            $("#msg-modal-body").html(`There are no Services yet!`);
            $("#msg-alert").modal("toggle");
            return false;
          }
        } else {
          services = JSON.parse(data);
          row = $("#service_aggregate");
          row.html("");

          services.forEach(function (service) {
            row.append(`<tr>
                                      <td >${service.service}</td>
                                      <td>${service.total}</td>
                                      <td>${service.pending}</td>
                                      <td>${service.served}</td>
                                      <td>${service.waiting}</td>
                                      <td>${service.servtime} Min</td>
                                      <td>${service.estimated} Min</td>
                                      <td class='text-center'>
                                <a class='badge badge-primary px-4 py-2' href='./br_service_update.php?id=${service.id}'>Update</a></td>
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
    UPDATE - ADD - DELETE branch services
====================================== */
if (checkPage("br_service_add.php") || checkPage("br_service_update.php") || checkPage("service_emp_add.php") || checkPage("service_emp_update.php") || checkPage("services_org.php")) {
  // get organization services
  $.ajax(`../../api.php?section=services&do=get_services`, {
    method: `POST`,
    data: {
      'org': "org"
    },
    success: function (data, textStatus, jqXHR) {
      if (data == "false") {
        $("#service_id").html(
          `<option disabled selected value="">There are no services in your organization </option>`
        );
        $("#msg-modal-body").html(`There are no Services yet!`);
        $("#msg-alert").modal("toggle");
        return false;
      } else {
        services = JSON.parse(data);

        services.forEach(function (service) {
          if (checkPage("services_org.php")) {
            $('#service_list_table').append(`<tr>
              <td >${service.name}</td>
              <td>${service.details}</td>
              <td>${service.time}</td>
              <td>${service.chars}</td>
              <td class='text-center'>
              <a class='badge badge-primary px-4 py-2' href='./service_org_update.php?id=${service.id}'>Update</a></td>
              </tr>
              `);
          }
          $("#service_id").append(
            `<option value="${service.id}">${service.name}</option>`
          );
        });

        // get details about a Branch service
        if (checkPage("br_service_update.php")) {

          $.urlParam = function (name) {
            var results = new RegExp(`[\?&]${name}=([^&#]*)`).exec(window.location.search);
            return (results !== null) ? results[1] || 0 : false;
          }
          var brServiceID = $.urlParam('id');

          $.ajax(`../../api.php?section=branch_services&do=get_branch_service_details`, {
            method: `POST`,
            data: {
              'br_service_id': brServiceID
            },
            success: function (data, textStatus, jqXHR) {
              if (data == "false") {
                $("#msg-modal-body").html(`There are no Services with this ID!`);
                $("#msg-alert").modal("toggle");
                setTimeout(() => {
                  location.href = "../../br_services.php"
                }, 2000);
                return false;
              } else {
                service = JSON.parse(data);
                $('#br_service_id').html('');
                $(`#service_id option[value=${service.service_id}]`).attr('selected', 'selected');
                $('#br_service_id').append(`<option disabled selected value="${service.id}"> ${service.id} -  ${$(`#service_id option:selected`).html()}</option>`);
              }
            },
            error: function (jqXhr, textStatus, errorThrown) {
              console.log(errorThrown);
            }
          });
        }

      }
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });

  // get branch services
  if (checkPage("service_emp_add.php") || checkPage("service_emp_update.php")) {
    // get branch services
    $.ajax(`../../api.php?section=branch_services&do=get_branch_services`, {
      method: `POST`,
      data: {
        org: "org"
      },
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $("#br_service_id").html(
            `<option disabled selected value="">There are no services in your branch </option>`
          );
          $("#msg-modal-body").html(`There are no services  in your branch yet!`);
          $("#msg-alert").modal("toggle");
          return false;
        } else {
          BrServices = JSON.parse(data);
          BrServices.forEach(function (service) {
            $("#br_service_id").append(
              `<option value="${service.id}"> ${service.branch_id} - ${service.name}</option>`
            );
          });
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }
  if (!checkPage("services_org.php")) {
    // get employees of a branch
    $.ajax(`../../api.php?section=users&do=get_branch_employees`, {
      method: `POST`,
      data: {

      },
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $(`#emp`).append(
            `<option disabled selected value=''>Branch has no employees</option>`
          );
          return false;
        } else {

          employees = JSON.parse(data);
          var employeeList = $(`#emp`);
          employeeList.html("");
          employeeList.append(`<option disabled selected value=''>Choose Employee</option>`);
          employees.forEach(function (employee) {
            employeeList.append(`
                          <option value='${employee.user_id}'>${employee.emp_name}</option> <br>
                          `);
          });
        }

      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    })
  };
}


/* ====================================== 
    get services employee
====================================== */
if (checkPage("service_emp_update.php")) {


  $.urlParam = function (name) {
    var results = new RegExp(`[\?&]${name}=([^&#]*)`).exec(window.location.search);
    return (results !== null) ? results[1] || 0 : false;
  }
  var serviceEmployeeId = $.urlParam('id');

  // get service employee details
  $.ajax(`../../api.php?section=service_employee&do=get_serv_employee_data`, {
    method: `POST`,
    data: {
      'service_employee_id': serviceEmployeeId
    },
    success: function (data, textStatus, jqXHR) {
      if (data === 'false') {
        $("#msg-modal-body").html(`There are no services employee with this ID!`);
        $("#msg-alert").modal("toggle");
        setTimeout(() => {
          location.href = "../../service_emp_add.php"
        }, 2000);
        return false;
      }
      else {
        servEmp = JSON.parse(data);
        $('#service_emp_id').html('');
        $('#service_emp_id').append(`<option disabled selected value='${servEmp.id}'>${servEmp.service_name}</option>`);


        $(`#br_service_id option[value=${servEmp.br_service_id}]`).attr('selected', 'selected');
        $(`#emp option[value=${servEmp.emp_id}]`).attr('selected', 'selected');
        $(`#window option[value=${servEmp.window}]`).attr('selected', 'selected');
      }
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });


}
/* ====================================== 
    get all services employees
====================================== */
if (checkPage("service_emp.php")) {

  $.ajax(
    `../../api.php?section=service_employee&do=get_serv_employees`,
    {
      method: `POST`,
      data: {
        org: "org"
      },
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          if (checkPage("service_emp.php")) {
            $(`table tr:last`).after(
              `<tr><td valign="top" colspan="4" class="dataTables_empty "><h4 class='text-danger' > There are no service employees yet!</h4> </td></tr>`
            );
            $("#msg-modal-body").html(`There are no service employees yet!`);
            $("#msg-alert").modal("toggle");
            return false;
          }
        } else {
          brServices = JSON.parse(data);
          row = $("#emp_service_details");
          row.html("");

          brServices.forEach(function (service) {
            row.append(`<tr>
                                <td>${service.service_name}</td>
                                <td >${service.emp_name}</td>
                                <td>${service.window}</td>
                                <td class='text-center'>
                                <a class='badge badge-primary px-4 py-2' href='./service_emp_update.php?id=${service.id}'>Update</a></td>
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


if (checkPage("index.php")) {
  if (localStorage.getItem("user_type") == 2) {

    // get number of waiting customers
    $.ajax(`../../api.php?section=tickets&do=get_waiting_per_emp`, {
      method: `POST`,
      data: {
        'user': 'user'
      },
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $("#msg-modal-body").html(`There are no waiting customers!`);
          $("#msg-alert").modal("toggle");
          return false;
        } else {
          waiting = JSON.parse(data);
          $('#waiting').html(waiting.waiting);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });


    // get current customer data if any
    $.ajax(`../../api.php?section=tickets&do=current_customer`, {
      method: `POST`,
      data: {
        'user': 'user'
      },
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $("#msg-modal-body").html(`There are no pending customers!`);
          $("#msg-alert").modal("toggle");
          return false;
        } else {
          pending = JSON.parse(data);
          $('#cust_name').html(pending.customer);
          $('#service_name').html(pending.service);
          $('#ticket_name').html(`${pending.chars} ${pending.receipt_no}`);

        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }

  if (localStorage.getItem("user_type") == 3) {

    // get total Employees per branch
    $.ajax(`../../api.php?section=users&do=count_branch_employees`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#emp_ecount').html('0');
        } else {
          totalEmployees = JSON.parse(data);
          $('#emp_ecount').html(totalEmployees.branch_emp);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });

    // get total serving employees per branch
    $.ajax(`../../api.php?section=service_employee&do=count_branch_serv_employees`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#serving_emp').html('0');
        } else {
          servingEmp = JSON.parse(data);
          $('#serving_emp').html(servingEmp.serv_emp);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });

    // get total branch services per branch
    $.ajax(`../../api.php?section=branch_services&do=count_br_services_branch`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#br_services').html('0');
        } else {
          brServices = JSON.parse(data);
          $('#br_services').html(brServices.count_br_services);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });

    // get total waiting customers per branch
    $.ajax(`../../api.php?section=tickets&do=waiting_per_branch`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#waiting').html('0');
        } else {
          waiting = JSON.parse(data);
          $('#waiting').html(waiting.br_waiting);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
  }


  if (localStorage.getItem("user_type") == 4) {

    // get total branch services per branch
    $.ajax(`../../api.php?section=branches&do=count_branches`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#br_count').html('0');
        } else {
          branches = JSON.parse(data);
          $('#br_count').html(branches.br_count);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });
    
    // get total Employees per org
    $.ajax(`../../api.php?section=users&do=count_org_employees_managers`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#emp_count').html('0');
          $('#managers_count').html('0');
        } else {
          totalEmployees = JSON.parse(data);
          $('#total_emp').html(parseInt(totalEmployees.employees) + parseInt(totalEmployees.managers));
          $('#emp_count').html(totalEmployees.employees);
          $('#managers_count').html(totalEmployees.managers);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });

    // get total Pending Employees per org
    $.ajax(`../../api.php?section=users&do=count_pending_employees`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#pending_emp').html('0');
        } else {
          pendingEmp = JSON.parse(data);
          $('#pending_emp').html(pendingEmp.pending);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });

    // get total Serving Employees per org
    $.ajax(`../../api.php?section=service_employee&do=count_org_serv_employees`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#serving_emp').html('0');
        } else {
          servingEmp = JSON.parse(data);
          $('#serving_emp').html(servingEmp.total_serv_emp);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });


    // get total services per org
    $.ajax(`../../api.php?section=services&do=count_services`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#serv_count').html('0');
        } else {
          services = JSON.parse(data);
          $('#serv_count').html(services.serv_count);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });


    // get total Waiting customers per org
    $.ajax(`../../api.php?section=tickets&do=waiting_per_org`, {
      method: `POST`,
      success: function (data, textStatus, jqXHR) {
        if (data == "false") {
          $('#waiting').html('0');
        } else {
          waiting = JSON.parse(data);
          $('#waiting').html(waiting.org_waiting);
        }
      },
      error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
      }
    });

  }


}

if (checkPage("profile")) {
  $.ajax(`../../api.php?section=users&do=org_user_profile`, {
    method: `POST`,
    data: {
      'org': 'org'
    },
    success: function (data, textStatus, jqXHR) {
      if (data == 'false') {
        $('#msg-modal-body').html("There is no User with this ID");
        $('#msg-alert').modal('toggle');
        setTimeout(() => {
          location.href = "index.php"
        }, 3000);
        return false;
      } else {
        profile = JSON.parse(data);
        $('#_name').val(profile.name);
        $('#phone').val(profile.phone);
        $('#address').val(profile.address);
      }
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  })

}




/* ====================================== 
    get organization service to be updated 
====================================== */
if (checkPage("service_org_update.php")) {


  $.urlParam = function (name) {
    var results = new RegExp(`[\?&]${name}=([^&#]*)`).exec(window.location.search);
    return (results !== null) ? results[1] || 0 : false;
  }
  var serviceID = $.urlParam('id');

  // get service employee details
  $.ajax(`../../api.php?section=services&do=get_service`, {
    method: `POST`,
    data: {
      'service_id': serviceID
    },
    success: function (data, textStatus, jqXHR) {
      if (data === 'false') {
        $("#msg-modal-body").html(`There is no service with this ID!`);
        $("#msg-alert").modal("toggle");
        setTimeout(() => {
          location.href = "../../org/services_org.php"
        }, 2000);
        return false;
      }
      else {
        service = JSON.parse(data);
        $('#service_id').html('');
        $('#service_id').append(`<option disabled selected value='${service.id}'>${service.name}</option>`);

        $('#_name').val(service.name);
        $('#details').val(service.details);
        $('#time').val(service.time);
        $('#char').val(service.chars);

      }
    },
    error: function (jqXhr, textStatus, errorThrown) {
      console.log(errorThrown);
    }
  });


}