var feedMsg = {
    "good": "Looks Good!",
    "emptyMail": "Please Enter an Email!",
    "enterMail": "Please Enter a Valid Email!",
    "mailExists": "Email already exists!",
    "nameShort": "Name is too short",
    "emptyPhone": "Please Enter a Phone!",
    "enterPhone": "Please Enter a Valid Phone Number!",
    "PhoneExists": "Phone already exists!",
    "emptyID": "Please Enter an ID!",
    "IDexists": "ID already exists!",
    "longName": "Name is too long ust be more than 5 and less than 40 characters",
    "shortName": "Name is short short must be more than 5 and less than 40 characters",
    "shortPass": "Password less than 5 characters",
    "invalidPass": "Password Does not meet requirements!!",
    "notMatching": "Password not matching!!",
    "matchPass": "Password Match!",
    "longAddress": "Address is too short must be more than 15 and less than 100 characters",
    "shortAddress": "Address is short long must be more than 15 and less than 100 characters",
    "mailAvail": "Email is available!",
    "phoneAvail": "Phone is available!",
    "IDAvail": "ID is available!",
};

var msgClass = { "valid": "valid-feedback", "invalid": "invalid-feedback" };

// show a message for the user under input
function ValidAlert(a, b, c) {
    $(a).removeClass().addClass(b);
    $(a).html(c).show();
    return true;
}

// check the link of the page of contains specific path
function checkPage(page) {
    return (window.location.pathname.includes(page)) ? true : false;
}


/* ==================================== 
    VALIDATION
=======================================*/
// Name Validation
$(`input[name=_name]`).on('blur', function () {
    var name = $(`input[name=_name]`).val().trim();
    if (name.length > 30) {
        ValidAlert('#name_feedback', msgClass['invalid'], feedMsg['longName']);
        return false;
    }
    else if (name.length > 0 && name.length < 5) {
        ValidAlert('#name_feedback', msgClass['invalid'], feedMsg['shortName']);
        return false;
    }
    else
        $(`#name_feedback`).hide();
})

// branch code validation
$(`input[name=br_code]`).on('blur', function () {
    var br_code = $(`input[name=br_code]`).val().trim();
    if (br_code.length > 15) {
        ValidAlert('#br_code_feedback', msgClass['invalid'], 'Too long branch code');
        return false;
    }
    else if (br_code.length < 1) {
        ValidAlert('#br_code_feedback', msgClass['invalid'], 'Too short branch code');
        return false;
    }
    else
        $(`#br_code_feedback`).hide();
})

// Address Validation
$(`input[name=address]`).on('blur', function () {
    var address = $(`input[name=address]`).val().trim();
    if (address.length > 100) {
        ValidAlert('#address_feedback', msgClass['invalid'], feedMsg['longAddress']);
        return false;
    }
    if (address.length < 15) {
        ValidAlert('#address_feedback', msgClass['invalid'], feedMsg['shortAddress']);
        return false;
    }
    else
        $(`#address_feedback`).hide();

})

// phone Validation
$("#phone").blur(function () {
    var phoneInput = $(`#phone`);
    phoneInput.prop('disabled', true);
    var phone = $("#phone").val().trim();

    if (phone === '') {
        ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['emptyPhone']);
        phoneInput.prop('disabled', false);
        return false;
    }
    else if (phone.length > 0 && (phone.length < 4 || phone.length > 15)) {
        ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['enterPhone']);
        phoneInput.prop('disabled', false);
        return false;
    }
    phoneInput.prop('disabled', false);
})


$(document).on('passValidation', (e, pass) => {
    const passRegex = /^(?=.*[a-z_.])(?=.*[A-Z_.])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z_.\d@$!%*?&]{5,20}$/;
    if (pass.length > 0 && pass.length < 5) {
        ValidAlert('#pass_alert', msgClass['invalid'], feedMsg['shortPass']);
        return false;
    }
    else if (pass.length > 4 && (!passRegex.test(pass))) {
        ValidAlert('#pass_alert', msgClass['invalid'], feedMsg['invalidPass']);
        return false;
    }
    else
        $(`#pass_alert`).hide();
})


// Validate Password
$(`input[name=password]`).on('blur', function () {
    var pass = $(`input[name=password]`).val();
    $(document).trigger("passValidation", [pass]);

})

// validate password confirmation
$(`input[name=confirmation]`).on('blur', function () {
    var confirm = $(`input[name=confirmation]`).val();
    if (confirm.length > 4 && $(`input[name=password]`).val() !== confirm) {
        ValidAlert('#confirm_alert', msgClass['invalid'], feedMsg['notMatching']);
        return false;
    }
    else
        $(`#confirm_alert`).hide();
})


/* ==================================== 
    Update - Delete - Add new branch into an organization
=======================================*/
if (checkPage("branch_add.php") || checkPage("branch_update")) {

    var isPhone = false;

    // Phone check if exists in DB
    $("#br_phone").blur(function () {
        var phoneInput = $(`#br_phone`);
        phoneInput.prop('disabled', true);
        var phone = $("#br_phone").val().trim();

        if (phone === '') {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['emptyPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        else if (phone.length > 0 && (phone.length < 4 || phone.length > 12)) {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['enterPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        else {
            $.ajax(`../../api.php?section=branches&do=check_br_phone`, {
                method: `POST`,
                data: {
                    'phone': phone
                },
                success: function (data, textStatus, jqXHR) {
                    checkPhone = JSON.parse(data);
                    if (checkPhone !== "exists") {
                        ValidAlert('#phone_feedback', msgClass['valid'], feedMsg['phoneAvail']);
                        isPhone = false;
                    }
                    else {
                        isPhone = true;
                        ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['PhoneExists']);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log("Error: ", errorThrown);
                }
            })
            phoneInput.prop('disabled', false);
        }
    })


    // get the value of clicked button(add - update - delete)
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    $(`#branch-form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.btn`).prop('disabled', true);
        if (isPhone == true) {
            $('#msg-modal-body').html(`Please check all fields again!`);
            $('#msg-alert').modal('toggle');
            return false;
        }
        else {
            var branchID = $(`#branch_id option:selected`).val();
            var name = $('#_name').val().trim();
            var branchCode = $('#br_code').val().trim();
            var area = $(`#area`).val().trim();
            var address = $('#address').val().trim();
            var phone = $('#br_phone').val().trim();

            $.ajax(`../../api.php?section=branches&do=update_branch`, {
                method: `POST`,
                data: {
                    'form-btn': action,
                    'br_id': branchID,
                    'area': area,
                    'br_code': branchCode,
                    '_name': name,
                    'address': address,
                    'phone': phone
                },
                success: function (data, textStatus, jqXHR) {
                    reply = JSON.parse(data);
                    $('#msg-modal-body').html(reply);
                    $('#msg-alert').modal('toggle');
                    $(`.btn`).prop('disabled', false);
                    setTimeout(() => {
                        location.href = "../../org/branches.php"
                    }, 3000);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            })
        }
        $(`.btn`).prop('disabled', false);

    });
}


/* ==================================== 
   Employee Add - Update - Delete
=======================================*/
if (checkPage("employee_update") || checkPage("employee_add")) {

    // to prevent form submission if there are exists in DB
    var isMail = false;
    var isPhone = false;
    var isID = false;

    // check if mail exists before 
    $(`#email`).blur(function () {
        // get the values to check for
        $(`#email`).prop('disabled', true);

        var email = $("#email").val().trim();
        if (email === '' || email.length < 9) {
            ValidAlert('#mail_feedback', msgClass['invalid'], feedMsg['emptyMail']);
            $(`#email`).prop('disabled', false);
            return false;
        }
        else if (email.length > 8) {
            const mailRegex = /^([a-zA-Z0-9]+\.?\_?[a-zA-Z0-9]+)+@{1}[a-zA-Z0-9\.]+/;
            if (!(mailRegex.test(email))) {
                ValidAlert('#mail_feedback', msgClass['invalid'], feedMsg['enterMail']);
                $(`#email`).prop('disabled', false);
                return false;
            }
        }
        $.ajax(`../../api.php?section=users&do=check_email`, {
            method: `POST`,
            data: {
                'email': email
            },
            success: function (data, textStatus, jqXHR) {
                checkMail = JSON.parse(data);
                if (checkMail !== "exists") {
                    ValidAlert('#mail_feedback', msgClass['valid'], feedMsg['mailAvail']);
                    var isMail = false;
                }
                else {
                    ValidAlert('#mail_feedback', msgClass['invalid'], feedMsg['mailExists']);
                    var isMail = true;
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log("Error: ", errorThrown);
            }
        })
        $(`#email`).prop('disabled', false);
    })

    // check if phone already exists 
    $("#phone").blur(function () {
        var phoneInput = $(`#phone`);
        phoneInput.prop('disabled', true);
        var phone = $("#phone").val().trim();

        if (phone === '') {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['emptyPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        else if (phone.length > 0 && (phone.length < 8 || phone.length > 11)) {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['enterPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        else {
            $.ajax(`../../api.php?section=users&do=check_phone`, {
                method: `POST`,
                data: {
                    'phone': phone
                },
                success: function (data, textStatus, jqXHR) {
                    checkPhone = JSON.parse(data);
                    if (checkPhone !== "exists") {
                        ValidAlert('#phone_feedback', msgClass['valid'], feedMsg['phoneAvail']);
                        isPhone = false;
                    }
                    else {
                        ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['PhoneExists']);
                        isPhone = true;
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log("Error: ", errorThrown);
                }
            })
            phoneInput.prop('disabled', false);
        }
    })

    // check if Employee ID already exists 
    $("#comp_id").blur(function () {
        var orgID = $('#org-id').html().trim();
        var compID = $("#comp_id").val().trim();

        if (compID === '') {
            ValidAlert('#comp_id_alert', msgClass['invalid'], feedMsg['emptyID']);
        }
        else {
            $.ajax(`../api.php?section=users&do=check_comp_id`, {
                method: `POST`,
                data: {
                    'org_id': orgID,
                    'comp_id': compID
                },
                success: function (data, textStatus, jqXHR) {
                    checkID = JSON.parse(data);
                    if (checkID !== "exists") {
                        ValidAlert('#comp_id_alert', msgClass['valid'], feedMsg['IDAvail']);
                        isID = false;
                    }
                    else {
                        ValidAlert('#comp_id_alert', msgClass['invalid'], feedMsg['IDexists']);
                        isID = true;
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log("Error: ", errorThrown);
                }
            })
        }
    })


    // get managers of a branch
    $("#branch").change(function () {
        brID = $(this).val();

        // get managers from selected branch
        $.ajax(`../../api.php?section=users&do=get_branch_managers`, {
            method: `POST`,
            data: {
                'branch_id': brID
            },
            success: function (data, textStatus, jqXHR) {
                if (data == 'false') {
                    $(`#manager`).append(`<option disabled selected value=''>Branch has no managers</option>`);
                    return false;
                }
                else {
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
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
    })

    // get the value of clicked button to determine what action to be taken
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    //  Add , Update or Delete Employee Data
    $(`#employee_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`#form-btn`).prop('disabled', true);

        if (isMail == true || isPhone == true || isID == true) {
            // alert('Please check all fields again!');
            $('#msg-modal-body').html(`Please check all fields again!`);
            $('#msg-alert').modal('toggle');
            $(`#form-btn`).prop('disabled', false);
            return false;
        }

        // update
        var userID = $(`#user_id option:selected`).val();
        var branchID = $(`#branch option:selected`).val();
        var compID = $('#comp_id').val().trim();
        var name = $('#_name').val().trim();
        var phone = $('#phone').val().trim();
        var address = $('#address').val().trim();
        var manager = $(`#manager option:selected`).val()
        var userType = $(`#user_type option:selected`).val().trim();
        var status = $(`#status option:selected`).val();
        var email = '';
        var password = '';

        // in case of adding employee
        if (action == 'add') {
            email = $('#email').val();
            password = $('#password').val();
        }

        $.ajax(`../../api.php?section=users&do=employee_update`, {
            method: `POST`,
            data: {
                'form-btn': action,
                'user_id': userID,
                'branch': branchID,
                'comp_id': compID,
                'email': email,
                'password': password,
                '_name': name,
                'address': address,
                'phone': phone,
                'manager': manager,
                'user_type': userType,
                'status': status
            },
            success: function (data, textStatus, jqXHR) {
                reply = JSON.parse(data);
                if (reply.includes('exists')) {
                    $('#msg-modal-body').html('Branch already has a manager');
                    $('#msg-alert').modal('toggle');
                    $(`#form-btn`).prop('disabled', false);
                    return false;
                }
                $('#msg-modal-body').html(reply);
                $('#msg-alert').modal('toggle');
                $(`#form-btn`).prop('disabled', false);
                setTimeout(() => {
                    location.href = "../../org/employees_list.php"
                }, 3000);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
        $(`#form-btn`).prop('disabled', false);
    });


}

/* ==================================== 
    Update Org Profile
=======================================*/
if (checkPage("profile")) {

    $("#phone").blur(function () {
        var phoneInput = $(`#phone`);
        phoneInput.prop('disabled', true);
        var phone = $("#phone").val().trim();

        if (phone === '') {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['emptyPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        else if (phone.length > 0 && (phone.length < 4 || phone.length > 12)) {
            ValidAlert('#phone_feedback', msgClass['invalid'], feedMsg['enterPhone']);
            phoneInput.prop('disabled', false);
            return false;
        }
        phoneInput.prop('disabled', false);

    })


    //  Add , Update or Delete Employee Data
    $(`#profile-form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.form-btn`).prop('disabled', true);


        var name = $('#_name').val().trim();
        var address = $('#address').val().trim();
        var phone = $('#phone').val().trim();


        $.ajax(`../../api.php?section=users&do=user_update`, {
            method: `POST`,
            data: {
                '_name': name,
                'phone': phone,
                'address': address
            },
            success: function (data, textStatus, jqXHR) {
                if (data.includes('phone')) {
                    $('#msg-modal-body').html("Phone Already Exists");
                    $('#msg-alert').modal('toggle');
                    $(`.btn`).prop('disabled', false);
                    return false;
                }
                else{
                    reply = JSON.parse(data);
                    $('#msg-modal-body').html(reply);
                    $('#msg-alert').modal('toggle');
                    $(`.btn`).prop('disabled', false);
                    setTimeout(() => {
                        location.href = "profile.php"
                    }, 2000);
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
    })
}


/* ====================================== 
    UPDATE - ADD - DELETE branch services
====================================== */
if (checkPage("br_service_add.php") || checkPage("br_service_update.php")) {

    // get the value of clicked button to determine what action to be taken
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    //  Add , Update or Delete branch Service
    $(`#br_service_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.btn`).prop('disabled', true);

        // Add
        var service_type = $(`#service_id option:selected`).val().trim();

        // This service already assigned to this employee!

        // in case of Updating
        var BrServiceID = '';
        if (action == 'update' || action == 'delete') {
            BrServiceID = $(`#br_service_id option:selected`).val().trim();
        }

        $.ajax(`../../api.php?section=branch_services&do=br_service_update`, {
            method: `POST`,
            data: {
                'form-btn': action,
                'br_service_id': BrServiceID,
                'service_id': service_type,
            },
            success: function (data, textStatus, jqXHR) {
                reply = JSON.parse(data);
                if (reply === "exists") {
                    $('#msg-modal-body').html("This service already added!");
                }
                else {
                    $('#msg-modal-body').html(reply);
                }

                $('#msg-alert').modal('toggle');
                $(`.btn`).prop('disabled', false);
                // setTimeout(() => {
                //     location.href = "../../services.php"
                // }, 3000);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
        $(`.btn`).prop('disabled', false);
    });


}



/* ====================================== 
    UPDATE - ADD - DELETE employee services
====================================== */
if (checkPage("service_emp_add.php") || checkPage("service_emp_update.php")) {

    // get the value of clicked button to determine what action to be taken
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    //  Add , Update or Delete branch Service
    $(`#service_emp_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.btn`).prop('disabled', true);

        // Add
        var brService = $(`#br_service_id option:selected`).val().trim();
        var employee = $(`#emp option:selected`).val().trim();
        var window = $(`#window option:selected`).val().trim();

        // in case of Updating
        if (action == 'update' || action == 'delete') {
            var serviceEmployeeId = $(`#service_emp_id option:selected`).val().trim();;
        }

        $.ajax(`../../api.php?section=service_employee&do=service_employee_update`, {
            method: `POST`,
            data: {
                'form-btn': action,
                'service_employee_id': serviceEmployeeId,
                'br_service_id': brService,
                'emp': employee,
                'window': window
            },
            success: function (data, textStatus, jqXHR) {
                if (data.includes('duplicate_emp_serv')) {
                    $('#msg-modal-body').html("This service already added to the same employee!");
                    $('#msg-alert').modal('toggle');
                    $(`.btn`).prop('disabled', false);
                    return false;
                }
                reply = JSON.parse(data);
                if (reply === "window change") {
                    $('#msg-modal-body').html("you can't assign more than 1 window to an employee!");
                }
                else if (reply === 'window exists') {
                    $('#msg-modal-body').html("you can't assign more than one employee to a window!");

                }
                else {
                    $('#msg-modal-body').html(reply);
                }

                $('#msg-alert').modal('toggle');
                $(`.btn`).prop('disabled', false);
                if (reply.includes('successfully') || reply.includes('Updated') || reply.includes('deleted')) {
                    setTimeout(() => {
                        location.href = "service_emp.php"
                    }, 2000);
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
        $(`.btn`).prop('disabled', false);
    });


}

if (checkPage("index.php")) {
    //  next button
    if (localStorage.getItem("user_type") == 2) {
        $(`#next_customer_form`).on(`submit`, function (e) {
            e.preventDefault();
            $(`#next_button`).prop('disabled', true);

            // get current customer data if any
            $.ajax(`../../api.php?section=tickets&do=next_customer`, {
                method: `POST`,
                data: {
                    'user': 'user'
                },
                success: function (data, textStatus, jqXHR) {
                    if (data == "false" || JSON.parse(data) == 'no waiting') {
                        $("#msg-modal-body").html(`There are no more pending customers!`);
                        $("#msg-alert").modal("toggle");
                        $(`.btn`).prop('disabled', false);
                        return false;
                    } else {
                        pending = JSON.parse(data);
                        var newWaiting = parseInt($('#waiting').html()) - 1;
                        $('#waiting').html(newWaiting);
                        $('#cust_name').html(pending.customer);
                        $('#service_name').html(pending.service);
                        $('#ticket_name').html(`${pending.chars} ${pending.receipt_no}`);
                        setTimeout(() => {
                            $(`#next_button`).prop('disabled', false);
                        }, 10000);
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        })
    }
}


/* ==================================== 
    update user password
=======================================*/

if (checkPage("pass_update.php")) {

    var confirmed = false;
    // Validate Password
    $(`input[name=password]`).on('blur', function () {
        var pass = $(`input[name=password]`).val();
        $(document).trigger("passValidation", [pass]);

        // validate password confirmation
        $(`input[name=confirmation]`).on('blur', function () {
            var confirm = $(`input[name=confirmation]`).val();
            if (confirm.length > 4 && $(`input[name=password]`).val() !== confirm) {
                ValidAlert('#confirm_alert', msgClass['invalid'], feedMsg['notMatching']);
                return false;
            }
            else {
                $(`#confirm_alert`).hide();
                confirmed = true;
            }
        });


        $(`#pass_form`).on(`submit`, function (ev) {
            ev.preventDefault();
            $(`#pass-btn`).prop('disabled', true);

            if (confirmed == false) {
                $('#msg-modal-body').html(`Please check all fields again!`);
                $('#msg-alert').modal('toggle');
                $(`#pass-btn`).prop('disabled', false);
                return false;
            }

            var Oldpass = $(`input[name=old_password]`).val();
            var Newpass = $(`input[name=password]`).val();

            $.ajax(`../../api.php?section=users&do=password_update`, {
                method: `POST`,
                data: {
                    'old_password': Oldpass,
                    'new_password': Newpass,
                },
                success: function (data, textStatus, jqXHR) {
                console.log("Output: data", data)
                    userReg = JSON.parse(data);
                    if (userReg.includes('old password')) {
                        $('#msg-modal-body').html(userReg);
                        $('#msg-alert').modal('toggle');
                        $(`#pass-btn`).prop('disabled', false);
                        return false;
                    }
                    else{
                        $('#msg-modal-body').html(userReg);
                        $('#msg-alert').modal('toggle');
                        setTimeout(() => {
                            location.href = "pass_update.php"
                        }, 2000);

                    }

                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log("Error: ", errorThrown);
                }
            })

        });

    })
}




/* ==================================== 
    Update - Delete - Add  (org service)
=======================================*/
if (checkPage("service_org_add.php") || checkPage("service_org_update.php")) {

    // get the value of clicked button(add - update - delete)
    var action;
    $(`.btn`).click(function () {
        action = $(this).attr("value");
    })

    $(`#org_service_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`.form-btn`).prop('disabled', true);


        var serviceID = $(`#service_id option:selected`).val();
        var name = $('#_name').val();
        var details = $('#details').val();
        var time = $('#time').val();
        var chars = $('#char').val();

        $.ajax(`../../api.php?section=services&do=service_update`, {
            method: `POST`,
            data: {
                'form-btn': action,
                'service_id': serviceID,
                'name': name,
                'details': details,
                'time': time,
                'chars': chars
            },
            success: function (data, textStatus, jqXHR) {
                reply = JSON.parse(data);
                $('#msg-modal-body').html(reply);
                $('#msg-alert').modal('toggle');
                $(`.form-btn`).prop('disabled', false);
                setTimeout(() => {
                    location.href = "services_org.php"
                }, 2000);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
        $(`.form-btn`).prop('disabled', false);
    }

    );
}

if (checkPage("ticket_details")) {

    // hide table before getting ticket details
    $('#ticket_details_table').hide();

    $(`#ticket_details_form`).on(`submit`, function (e) {
        e.preventDefault();
        $(`#ticket_btn`).prop('disabled', true);


        var chars = $('#ticket_chars').val().trim();
        var number = $('#ticket_number').val().trim();


        $.ajax(`../../api.php?section=tickets&do=ticket_details`, {
            method: `POST`,
            data: {
                'chars': chars,
                'receipt_number': number,
            },
            success: function (data, textStatus, jqXHR) {
                if (data == 'false') {
                    $('.table tr:last').after(`<tr><td valign="top" colspan="5" class="dataTables_empty text-center"><h4 class='text-danger' > Ticket Number not found!</h4> </td></tr>`);
                    $('#msg-modal-body').html(`Ticket Number not found!`);
                    $('#msg-alert').modal('toggle');
                    $(`#ticket_btn`).prop('disabled', false);
                    return false;
                } else {
                    ticket = JSON.parse(data);
                    row = $('#ticket_tbody');
                    row.html('');
                    $(`#ticket_btn`).prop('disabled', false);
                    ticket.name = Capitalize(ticket.name);
                    row.append(`<tr>
                      <td>${ticket.chars}${ticket.receipt_no}</td>
                      <td>${ticket.name}</td>
                        <td>${ticket.started}</td>
                        <td>${ticket.ended}</td> 
                        <td>${ticket.status}</td>
                        </tr>`);
                    $('#ticket_details_table').show();
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
    })

}